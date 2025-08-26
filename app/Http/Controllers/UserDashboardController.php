<?php

namespace App\Http\Controllers;

use App\Models\ConversionHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Rules\ValidImageType;
use Illuminate\Support\Facades\Hash;

class UserDashboardController extends Controller
{
    public function index()
    {
        $history = ConversionHistory::with('items')
            ->whereHas('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('frontend.dashboard.index', compact('history'));
    }

    public function profile(Request $request)
    {
        $user = User::find(auth()->id());

        if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            if ($request->name !== $user->name) {
                $user->name = $request->name;
            }

            if ($request->email !== $user->email) {
                $user->email = $request->email;
                $user->google_id = null;
            }

            if ($request->current_password || $request->password) {

                $request->validate([
                    'password' => 'required|min:6',
                ]);

                if ($user->is_google_registered) {
                    $user->is_google_registered = false;
                } else {
                    $request->validate([
                        'current_password' => 'required',
                    ]);

                    $currentPassword = $request->current_password;

                    if (!Hash::check($currentPassword, $user->password)) {
                        throw ValidationException::withMessages([
                            'current_password' => 'The current password is incorrect',
                        ]);
                    }
                }

                $user->password = bcrypt($request->password);
            }

            $user->save();

            return back()->with('success', 'Updated Successfully');
        } else {
            return view('frontend.dashboard.profile', compact('user'));
        }
    }
}
