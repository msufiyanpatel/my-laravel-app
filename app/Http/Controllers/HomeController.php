<?php

namespace App\Http\Controllers;

use App\Models\Adds;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\ConversionList;
use App\Models\ConversionHistory;

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
        $imageHandler = new ImageHandlerController();
        $imageHandler->secureUnlink($image->file_url);
        $imageHandler->secureUnlink($image->original_url);

        $history_id = $image->conversion_history_id;

        $image->delete();

        // delete the history if all image are deleted
        $checkHistory = ConversionHistory::whereDoesntHave('items')->find($history_id);
        if ($checkHistory) {
            $checkHistory->delete();
        }

        return back()->with('success', 'Image deleted successfully !');
    }
}
