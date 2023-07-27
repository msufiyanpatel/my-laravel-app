<?php

namespace App\Http\Controllers\Backend;

use App\Models\Adds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHandlerController;

class AddsController extends Controller
{
    public function index()
    {
        $top_add = Adds::where('section', 1)->first();
        $middle_add = Adds::where('section', 2)->first();
        $bottom_add = Adds::where('section', 3)->first();

        return view('backend.adds.index', compact('top_add', 'middle_add', 'bottom_add'));
    }

    public function update(Request $request)
    {
        // top 
        if ($request->top_add_type) {
            $top_add = Adds::where('section', 1)->first();
            if (!$top_add) {
                $top_add = new Adds();
                $top_add->section = 1;
            }

            if ($request->top_add_status) {
                $top_add->status = 1;
            } else {
                $top_add->status = 0;
            }

            if ($request->top_add_type == 1) {
                $top_add->type = 1;
                $top_add->code_body = $request->top_add_code;
                $top_add->img_body = null;
                $top_add->img_url = null;
            } else {
                $top_add->type = 2;
                $top_add->code_body = null;

                if ($request->hasFile("top_add_img")) {
                    $imageController = new ImageHandlerController();

                    $imageController->secureUnlink($top_add->top_add_img);

                    $top_add->img_body = $imageController->uploadImageAndGetPath($request->file("top_add_img"), "/public/media/adds");
                }

                $top_add->img_url = $request->top_add_img_url;
            }
            $top_add->save();
        }

        // middle 
        if ($request->middle_add_type) {
            $middle_add = Adds::where('section', 2)->first();
            if (!$middle_add) {
                $middle_add = new Adds();
                $middle_add->section = 2;
            }

            if ($request->middle_add_status) {
                $middle_add->status = 1;
            } else {
                $middle_add->status = 0;
            }

            if ($request->middle_add_type == 1) {
                $middle_add->type = 1;
                $middle_add->code_body = $request->middle_add_code;
                $middle_add->img_body = null;
                $middle_add->img_url = null;
            } else {
                $middle_add->type = 2;
                $middle_add->code_body = null;

                if ($request->hasFile("middle_add_img")) {
                    $imageController = new ImageHandlerController();

                    $imageController->secureUnlink($middle_add->middle_add_img);

                    $middle_add->img_body = $imageController->uploadImageAndGetPath($request->file("middle_add_img"), "/public/media/adds");
                }

                $middle_add->img_url = $request->middle_add_img_url;
            }
            $middle_add->save();
        }
        // bottom 
        if ($request->bottom_add_type) {
            $bottom_add = Adds::where('section', 3)->first();
            if (!$bottom_add) {
                $bottom_add = new Adds();
                $bottom_add->section = 3;
            }

            if ($request->bottom_add_status) {
                $bottom_add->status = 1;
            } else {
                $bottom_add->status = 0;
            }

            if ($request->bottom_add_type == 1) {
                $bottom_add->type = 1;
                $bottom_add->code_body = $request->bottom_add_code;
                $bottom_add->img_body = null;
                $bottom_add->img_url = null;
            } else {
                $bottom_add->type = 2;
                $bottom_add->code_body = null;

                if ($request->hasFile("bottom_add_img")) {
                    $imageController = new ImageHandlerController();

                    $imageController->secureUnlink($bottom_add->bottom_add_img);

                    $bottom_add->img_body = $imageController->uploadImageAndGetPath($request->file("bottom_add_img"), "/public/media/adds");
                }

                $bottom_add->img_url = $request->bottom_add_img_url;
            }
            $bottom_add->save();
        }

        return back()->with('success', 'Successfully updated');
    }
}
