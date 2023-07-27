<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Exception\RequestException;

class TestController extends Controller
{
    public function test(Request $request)
    {

        // $user_agent = $request->server('HTTP_USER_AGENT');
        // $user_agent = $request->header('User-Agent');
        // $clientIP = request()->ip();
        // dd($clientIP);
        abort(404);
        
        return view('welcome');
    }
}
