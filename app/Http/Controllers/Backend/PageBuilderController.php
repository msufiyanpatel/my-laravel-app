<?php

namespace App\Http\Controllers\Backend;

use App\Models\Page;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageHandlerController;

class PageBuilderController extends Controller
{
    public function index()
    {
        return view('backend.page-builder.index');
    }

    public function createPage(Request $request)
    {
        $request->validate([
            "slug" => "required|unique:pages,slug",
            "title" => "required",
            "thumbnail" => "nullable",
            "content" => "required",
        ], [
            "slug.required" => "Select page type",
            "slug.unique" => "Page already exists",
        ]);

        $newPage = new Page();
        $newPage->slug = $request->slug;
        $newPage->title = $request->title;
        $newPage->content = $request->content;
        $newPage->status = $request->status ? 1 : 0;
        $newPage->save();

        return back()->with('success', 'Page created successfully');
    }

    public function fetchPageData(Request $request)
    {
        if ($request->ajax()) {
            $pages = Page::latest()->paginate(10);

            return view('backend.page-builder.page-table-data', compact('pages'))->render();
        }
    }

    public function loadCreateForm()
    {
        return view('backend.page-builder.create-form')->render();
    }

    public function loadEditForm(Request $request)
    {
        $page = Page::findOrFail($request->id);

        return view('backend.page-builder.edit-form', compact('page'))->render();
    }

    public function deletePage($id)
    {
        try {
            $page = Page::findOrFail($id);
            $page->delete();

            return back()->with('success', 'Page deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to delete the selected item: It is associated with other data and cannot be removed');
        }
    }

    public function updatePage(Request $request)
    {
        $page = Page::findOrFail($request->id);

        $request->validate([
            "slug" => "required|unique:pages,slug," . $page->id,
            "title" => "required",
            "thumbnail" => "nullable",
            "content" => "required",
        ]);

        $page->slug = $request->slug;
        $page->title = $request->title;
        $page->content = $request->content;
        $page->status = $request->status ? 1 : 0;
        $page->save();

        return back()->with('success', 'Page updated successfully');
    }

}
