<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ readConfig('site_name') }}</title>

    <!-- FAVICON ICON -->
    <link rel="shortcut icon" href="{{ assetImage(readconfig('favicon_icon')) }}" type="image/svg+xml">

    <!-- FAVICON ICON APPLE -->
    <link href="{{ assetImage(readconfig('favicon_icon_apple')) }}" rel="apple-touch-icon">
    <link href="{{ assetImage(readconfig('favicon_icon_apple')) }}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{ assetImage(readconfig('favicon_icon_apple')) }}" rel="apple-touch-icon" sizes="114x114">
    <link href="{{ assetImage(readconfig('favicon_icon_apple')) }}" rel="apple-touch-icon" sizes="144x144">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    @include('simple-alert')

    <div class="bg-gradient-to-tr from-fuchsia-300 to-sky-500">
        <section id="login" class="p-4 flex flex-col justify-center min-h-screen max-w-md mx-auto">
            <div class="p-6 bg-sky-100 rounded">
                <div class="flex items-center justify-center font-black m-3 mb-12">
                    <img src="{{ assetImage(readconfig('site_logo')) }}" alt="Logo" width="40px">
                    <h1 class="tracking-wide text-3xl text-gray-900">Login</h1>
                </div>
                <form action="{{ route('login') }}" method="POST" class="flex flex-col justify-center">
                    @csrf
                    <label class="text-sm font-medium">Email</label>
                    <input
                        class="mb-3 px-2 py-1.5
                                mb-3 mt-1 block w-full px-2 py-1.5 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                                focus:outline-none
                                focus:border-sky-500
                                focus:ring-1
                                focus:ring-sky-500
                                focus:invalid:border-red-500 focus:invalid:ring-red-500"
                        type="email" name="email" placeholder="Enter Email" required>
                    <label class="text-sm font-medium">Password</label>
                    <input
                        class="mb-3 px-2 py-1.5
                                mb-3 mt-1 block w-full px-2 py-1.5 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                                focus:outline-none
                                focus:border-sky-500
                                focus:ring-1
                                focus:ring-sky-500
                                focus:invalid:border-red-500 focus:invalid:ring-red-500"
                        type="password" name="password" placeholder="********" required>
                    <button
                        class="px-4 py-1.5 rounded-md shadow-lg bg-gradient-to-r from-pink-600 to-red-600 font-medium text-gray-100 block transition duration-300"
                        type="submit">
                        <span>Login</span>
                    </button>
                    @if (readConfig('google_sign_up_status'))
                        <div class="mt-2 px-6 sm:px-0 max-w-sm">
                            <a href="{{ route('auth.google') }}"
                                class="text-white w-full  bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center justify-between dark:focus:ring-[#4285F4]/55 mr-2 mb-2"><svg
                                    class="mr-2 -ml-1 w-4 h-4" aria-hidden="true" focusable="false" data-prefix="fab"
                                    data-icon="google" role="img" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 488 512">
                                    <path fill="currentColor"
                                        d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z">
                                    </path>
                                </svg>Login with Google<div></div>
                            </a>
                        </div>
                    @endif
                    <div class="flex justify-center">
                        -- or --
                    </div>
                    <a href="{{ route('signup') }}"
                        class="flex justify-center px-4 py-1.5 rounded-md shadow-lg bg-gradient-to-r from-blue-600 to-purple-600 font-medium text-gray-100 block transition duration-300">
                        <span>Register</span>
                    </a>
                </form>

            </div>
        </section>

    </div>
</body>

</html>
