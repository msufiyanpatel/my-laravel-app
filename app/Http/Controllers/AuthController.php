<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\PasswordReset;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Rules\ValidImageType;
use App\Models\ForgetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {

            $request->validate(
                [
                    'email' => 'required',
                    'password' => 'required'
                ]
            );

            if (!Auth::validate($request->only('email', 'password'))) {
                return redirect()->back()->with('error', 'Incorrect email or password');
            }

            $user = User::where('email', $request->email)->first();
            if ($user->is_suspended == 1) {
                return redirect()->back()->with('error', 'Your account is temporarily suspended');
            }

            $remember = $request->remember_me ? true : false;
            $credentials['email'] = $request->email;
            $credentials['password'] = $request->password;
            $credentials['remember'] = $remember;
            $credentials['previous_url'] = $request->previous_url;

            $valid = Arr::only($credentials, ['email', 'password']);

            if (Auth::attempt($valid, $credentials['remember'])) {
                session()->regenerate();

                // trash old/expired files
                $imageHandler = new ImageHandlerController();
                $imageHandler->trashOldFile();

                return $this->userRedirect();
            } else {
                return redirect()->route('login')->with('error', 'Incorrect email or password');
            }
        } else {
            if (auth()->user()) {
                return $this->userRedirect();
            } else {
                return view('frontend.authentication.login');
            }
        }
    }

    public function signup(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'email' => 'email|required|unique:users',
                'password' => 'required|confirmed|min:6'
            ]);

            $newUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'username' => uniqid(),
                'type' => 'User'
            ]);

            if ($newUser) {
                $request->session()->regenerate();
                Auth::login($newUser);

                return redirect()->route('frontend.user.dashboard');
            } else {
                return back()->with('error', 'Something went wrong');
            }
        } else {
            return view('frontend.authentication.sign-up');
        }
    }

    public function forgetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'email' => 'email|required',
            ]);
            $findUser = User::where('email', $request->email)->first();

            $otp = rand(11111, 99999);

            if ($findUser) {
                ForgetPassword::updateOrCreate(
                    [
                        'user_id' => $findUser->id
                    ],
                    [
                        'otp' => $otp,
                        'email' => $findUser->email,
                        'suspend_duration' => now()->addMinutes(5)
                    ]
                );

                session([
                    'user_id' => $findUser->id,
                    'reset-email' => $findUser->email
                ]);

                $mailData = [
                    'title' => readConfig('site_name'),
                    'otp' => $otp,
                    'name' => $findUser->name,
                ];

                try {
                    Mail::to($findUser->email)->send(new PasswordReset($mailData));
                } catch (\Throwable $th) {
                    //throw $th;
                }

                return redirect()->route('password.reset')->with('success', 'Check your inbox for otp code');
            } else {
                return back()->with('error', 'User not found');
            }
        } else {
            return view('frontend.authentication.forget-password');
        }
    }

    public function resendOtp()
    {
        $findUser = ForgetPassword::where('user_id', session('user_id'))
            ->where('email', session('reset-email'))
            ->first();

        if ($findUser) {
            $user = User::find(session('user_id'));
            $otp = rand(11111, 99999);

            $findUser->otp = $otp;
            $findUser->resent_count++;
            $findUser->suspend_duration = now()->addMinutes(5);
            $findUser->save();

            $mailData = [
                'title' => readConfig('site_name'),
                'otp' => $otp,
                'name' => $user->name,
            ];

            try {
                Mail::to($findUser->email)->send(new PasswordReset($mailData));
            } catch (\Throwable $th) {
                //throw $th;
            }

            return back()->with('success', 'Otp resent successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function newPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'password' => 'required|confirmed|min:6',
            ]);

            $user = User::find(session('user_id'));

            if ($user) {
                $user->password = bcrypt($request->password);
                $user->save();

                session()->forget('user_id');

                return redirect()->route('login')->with('success', 'Password reset successfully');
            } else {
                return redirect()->route('forget.password')->with('error', 'Something went wrong');
            }
        } else {
            return view('frontend.authentication.new-password');
        }
    }

    public function passwordReset(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'code' => 'required|max:5',
            ]);
            $otp = $request->code;

            $record = ForgetPassword::where('email', session('reset-email'))
                ->where('otp', $otp)
                ->first();

            if ($record) {
                $record->delete();
                session()->forget('reset-email');

                if (now()->greaterThan(Carbon::parse($record->suspend_duration))) {
                    return redirect()->route('login')->with('error', 'Otp expired');
                }

                return redirect()->route('new.password');
            } else {
                return back()->with('error', 'Invalid otp');
            }
        } else {
            return view('frontend.authentication.reset');
        }
    }

    public function logout()
    {
        if (auth()->user()) {
            Auth::logout();

            return redirect('/');
        } else {
            return back()->with('error', 'You are not logged in');
        }
    }

    public function userDash()
    {
        if (auth()->user()) {
            if (auth()->user()->type == 'Admin') {
                return redirect()->route('backend.admin.settings.website.general', ['active-tab' => 'website-info']);
            } else {
                return redirect()->route('frontend.user.dashboard');
            }
        } else {
            return redirect()->route('login')->with('error', 'You are not logged in');
        }
    }

    public function userRedirect()
    {
        if (auth()->user()) {
            if (auth()->user()->type == 'Admin') {
                return redirect()->route('backend.admin.settings.website.general', ['active-tab' => 'website-info']);
            } else {
                return redirect('/');
            }
        } else {
            return redirect()->route('login')->with('error', 'You are not logged in');
        }
    }

    public function userAuthCheck()
    {
        if (Auth::check()) {
            if (auth()->user()->type == 'User') {
                return response()->json(['authenticated' => true]);
            } else {
                Auth::logout();
                return response()->json(['authenticated' => false]);
            }
        } else {
            return response()->json(['authenticated' => false]);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(auth()->id());

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_image' => ['file', new ValidImageType]
        ]);

        if ($request->name !== $user->name) {
            $user->name = $request->name;
        }

        if ($request->email !== $user->email) {
            $user->email = $request->email;
            $user->google_id = null;
        }

        if ($request->hasFile("profile_image")) {
            $imageController = new ImageHandlerController();

            $imageController->secureUnlink($user->profile_image);

            $user->profile_image = $imageController->uploadImageAndGetPath($request->file("profile_image"), "/public/media/users");
        }

        if ($request->current_password || $request->new_password) {
            $request->validate([
                'current_password' => 'required|min:6',
                'new_password' => 'required|min:6|confirmed',
            ]);

            $currentPassword = $request->current_password;

            if (!Hash::check($currentPassword, $user->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'The current password is incorrect',
                ]);
            }

            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Updated Successfully');
    }
}
