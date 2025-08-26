<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConversionList;
use App\Models\ConversionHistory;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageHandlerController extends Controller
{
    public function uploader($file, $path, $width, $height)
    {
        $file_name = time() . "_" . uniqid() . "_" . $file->getClientOriginalName();
        $storingPath = storage_path() . "/app" . $path . "/" . $file_name;

        // if (!file_exists($path)) {
        //     mkdir($path, 0777, true);
        // }

        Image::make($file->getRealPath())->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->save($storingPath);

        // Remove Public from link
        return substr($path . "/" . $file_name, 8);
    }

    function uploadImageAndGetPath($file, $path = "/public/media/others")
    {
        return $this->uploader($file, $path, null, 400);
    }

    function uploadBigImageAndGetPath($file, $path = "/public/media/others")
    {
        return $this->uploader($file, $path, 800, null);
    }

    function uploadIconImageAndGetPath($file, $path = "/public/media/others")
    {
        return $this->uploader($file, $path, null, 200);
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

    public function fileUploadAndGetPath($file, $path = "/public/media/others")
    {
        $file_name = time() . "_" . $file->getClientOriginalName();

        $file->storeAs($path, $file_name);

        // Remove Public from link
        return substr($path . "/" . $file_name, 8);
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

                    if ($request->size_type == "Max") {
                        $file->resize($request->width, $request->height, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } else if ($request->size_type == "Crop") {
                        $file->fit($request->width, $request->height);
                    } else if ($request->size_type == "Scale") {
                        $file->resize($request->width, $request->height);
                    }
                } else if ($request->width) {

                    if ($request->size_type == "Max") {
                        $file->resize($request->width, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } else if ($request->size_type == "Crop") {
                        $file->fit(width: $request->width);
                    } else if ($request->size_type == "Scale") {
                        $file->resize($request->width, null);
                    }
                } else if ($request->height) {

                    if ($request->size_type == "Max") {
                        $file->resize(null, $request->height, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } else if ($request->size_type == "Crop") {
                        $file->fit(height: $request->height);
                    } else if ($request->size_type == "Scale") {
                        $file->resize(null, $request->height);
                    }
                }
            }

            // Convert image to the selected format and image quality
            $file->encode($outputFormat);

            $storingPath = storage_path() . "/app/public/media/converted/" . $convertedFileName;
            $originalPath = storage_path() . "/app/public/media/original/" . $filename;

            // move temp file to original folder
            File::move(storage_path($file_path), $originalPath);

            // save to server
            Image::make($file)->save($storingPath, $request->range);

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
        $extension = $image->extension();

        $imageName = time() . rand(1111, 9999) . '.' . $extension;
        $image->move(storage_path() . "/app/public/media/temp", $imageName);
        $path = "/app/public/media/temp/" . $imageName;

        return response()->json([
            'success' => true,
            'file_name' => $imageName,
            'file_extension' => $extension,
            'file_path' => $path
        ]);
    }

    public function trashOldFile()
    {
        if (readConfig('trash_expiration')) {
            $expiration = now()->subDays(readConfig('trash_expiration'))->toDateString();

            $results = ConversionHistory::with('items')->whereDate('created_at', '<', $expiration)->get();
            if ($results->count() > 0) {
                foreach ($results as $data) {
                    foreach ($data->items as $item) {
                        $this->secureUnlink($item->file_url);
                        $this->secureUnlink($item->original_url);

                        $item->delete();
                    }
                    $data->delete();
                }
            }
        }

        return true;
    }
}
