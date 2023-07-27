<?php

namespace App\Http\Controllers;

use App\Models\Adds;
use App\Models\ConversionHistory;
use App\Models\ConversionList;
use App\Models\Page;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    function index(Request $request)
    {
        $downloadLinks = [];
        if ($request->downloadLinks) {
            $downloadLinks = $request->downloadLinks;
        }

        $top_add = Adds::where('section', 1)->first();
        $middle_add = Adds::where('section', 2)->first();
        $bottom_add = Adds::where('section', 3)->first();

        return view('frontend.home', compact('downloadLinks', 'top_add', 'middle_add', 'bottom_add'));
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
            'type' => 'required|in:jpg,png,gif,bmp',
            'file.*' => 'required|file|mimes:jpg,png,gif,bmp',
        ]);

        $outputFormat = $request->input('type');
        $downloadLinks = [];

        $item = [];
        foreach ($request->file('file') as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $convertedFileName = $filename . '.' . $outputFormat;

            $storingPath = storage_path() . "/app/public/media/" . $convertedFileName;

            // Convert image to the selected format
            $image = Image::make($file)->encode($outputFormat);
            Image::make($image)->save($storingPath);

            $item['name'] = $convertedFileName;
            $item['link'] = $this->imageRecover("media/" . $convertedFileName);

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
                    'conversion_history_id'=> $history->id,
                    'file_name'=> $image['name'],
                    'file_url'=> $image['link'],
                ]);
            }
        }

        return to_route('home', ['downloadLinks' => $downloadLinks]);
    }

    public function imageRecover($path)
    {
        if ($path == null || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return null;
        }

        $storage_link = \Illuminate\Support\Facades\Storage::url($path);

        return asset($storage_link);
    }

    public function dynamicPage($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('frontend.dynamic-page', compact('page'));
    }
}
