<?php

namespace App\Http\Controllers;

use App\Models\ConversionHistory;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $history = ConversionHistory::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('frontend.dashboard.index', compact('history'));
    }
}
