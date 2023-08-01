<?php

namespace App\Http\Controllers;

use App\Models\Adds;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\ConversionList;
use App\Models\ConversionHistory;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    function index(Request $request)
    {
        $files = collect();
        if ($request->links) {
            $files = ConversionList::where('conversion_history_id', routeDecrypt($request->links))->get();
        }

        $top_add = Adds::where('section', 1)->first();
        $middle_add = Adds::where('section', 2)->first();
        $bottom_add = Adds::where('section', 3)->first();

        return view('frontend.home', compact('files', 'top_add', 'middle_add', 'bottom_add'));
    }

    // jpg — return JPEG encoded image data
    // png — return Portable Network Graphics (PNG) encoded image data
    // gif — return Graphics Interchange Format (GIF) encoded image data
    // tif — return Tagged Image File Format (TIFF) encoded image data
    // bmp — return Bitmap (BMP) encoded image data
    // ico — return ICO encoded image data
    // psd — return Photoshop Document (PSD) encoded image data
    // webp — return WebP encoded image data

    public function convertImages(Request $request)
    {
        $request->validate([
            'type' => 'required|in:jpg,png,gif,bmp,webp',
            'height' => 'nullable',
            'width' => 'nullable',
            'size_type' => 'nullable',
            'range' => 'nullable',
        ]);

        $outputFormat = $request->input('type');
        $downloadLinks = [];

        $item = [];
        $files =  json_decode($request->file, true);
        $names =  json_decode($request->name, true);

        if (count($files) == 0) {
            return back()->with('error', 'Upload images first..');
        }

        foreach ($files as $key => $file_path) {
            // Get the image contents from the asset link
            $imageContents = file_get_contents(storage_path($file_path));

            // Create an Intervention Image instance from the contents
            $file = Image::make($imageContents);

            $filename = $names[$key];
            $basename = substr($filename, 0, strrpos($filename, '.'));
            $convertedFileName = $basename . '.' . $outputFormat;

            // convert according to height wight
            if ($request->width || $request->height) {

                if ($request->width && $request->height) {

                    if ($request->size_type == "max") {
                        $file->resizeDown($request->width, $request->height);
                    } else if ($request->size_type == "crop") {
                        $file->fit($request->width, $request->height);
                    } else if ($request->size_type == "scale") {
                        $file->scaleDown($request->width, $request->height);
                    }
                } else if ($request->width) {

                    if ($request->size_type == "max") {
                        $file->resizeDown(width: $request->width);
                    } else if ($request->size_type == "crop") {
                        $file->fit(width: $request->width);
                    } else if ($request->size_type == "scale") {
                        $file->scaleDown(width: $request->width);
                    }
                } else if ($request->height) {

                    if ($request->size_type == "max") {
                        $file->resizeDown(height: $request->height);
                    } else if ($request->size_type == "crop") {
                        $file->fit(height: $request->height);
                    } else if ($request->size_type == "scale") {
                        $file->scaleDown(height: $request->height);
                    }
                }
            }

            // Convert image to the selected format and image quality
            $file->encode($outputFormat, $request->range);

            $storingPath = storage_path() . "/app/public/media/converted/" . $convertedFileName;
            $originalPath = storage_path() . "/app/public/media/original/" . $filename;

            // move temp file to original folder
            File::move(storage_path($file_path), $originalPath);

            // save to server
            Image::make($file)->save($storingPath);

            $item['name'] = $convertedFileName;
            $item['link'] = "media/converted/" . $convertedFileName;
            $item['original_link'] = "media/original/" . $filename;

            $downloadLinks[] = $item;
        }

        // generate history
        if (count($downloadLinks) > 0) {
            $history = ConversionHistory::create([
                'user_id' => @auth()->id(),
                'unique_code' => uniqid(),
                'user_agent' => $request->server('HTTP_USER_AGENT'),
                'user_ip' => request()->ip(),
            ]);

            foreach ($downloadLinks as $image) {
                ConversionList::create([
                    'conversion_history_id' => $history->id,
                    'file_name' => $image['name'],
                    'file_url' => $image['link'],
                    'original_url' => $image['original_link'],
                ]);
            }
        }

        return to_route('home', ['links' => routeEncrypt($history->id)])->with('success', 'Converted successfully !');
    }

    public function dropzoneStore(Request $request)
    {
        $image = $request->file('file');

        $imageName = time() . rand(1111, 9999) . '.' . $image->extension();
        $image->move(storage_path() . "/app/public/media/temp", $imageName);
        $path = "/app/public/media/temp/" . $imageName;

        return response()->json(['success' => true, 'file_name' => $imageName, 'file_path' => $path]);
    }

    public function dynamicPage($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('frontend.dynamic-page', compact('page'));
    }

    public function recentImages(Request $request)
    {
        $images = ConversionList::with('history')
            ->whereHas('history', function ($query) use ($request) {
                $query->where('user_agent', $request->server('HTTP_USER_AGENT'))->where('user_ip', request()->ip());
            })
            ->latest()
            ->take(12)
            ->get();

        return view('frontend.recent-images', compact('images'))->render();
    }

    public function deleteImage($id)
    {
        $image = ConversionList::findOrFail(routeDecrypt($id));
        $this->secureUnlink($image->file_url);
        $this->secureUnlink($image->original_url);

        $history_id = $image->conversion_history_id;

        $image->delete();

        // delete the history if all image are deleted
        $checkHistory = ConversionHistory::whereDoesntHave('items')->find($history_id);
        if ($checkHistory) {
            $checkHistory->delete();
        }


        return back()->with('success', 'Image deleted successfully !');
    }

    public function secureUnlink($path)
    {
        $absolute_path = storage_path() . '/app/public/' . $path;

        if (file_exists($absolute_path) && is_file($absolute_path)) {
            unlink($absolute_path);
            return true;
        } else {
            return false;
        }
    }
}
