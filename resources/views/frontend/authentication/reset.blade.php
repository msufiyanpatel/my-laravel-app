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
                    <h1 class="tracking-wide text-3xl text-gray-900">
                        Password Reset
                    </h1>
                </div>

                <form action="{{ route('password.reset') }}" method="post" class="flex flex-col justify-center">
                    @csrf
                    <label class="text-sm font-medium">Please enter the code we emailed you.</label>
                    <input
                        class="mb-3 px-2 py-1.5
                                mb-3 mt-1 block w-full px-2 py-1.5 border border-gray-300 rounded-md text-sm shadow-sm placeholder-gray-400
                                focus:outline-none
                                focus:border-sky-500
                                focus:ring-1
                                focus:ring-sky-500
                                focus:invalid:border-red-500 focus:invalid:ring-red-500"
                        type="number" name="code" placeholder="Enter code" required>

                    <button
                        class="px-4 py-1.5 rounded-md shadow-lg bg-gradient-to-r from-pink-600 to-red-600 font-medium text-gray-100 block transition duration-300"
                        type="submit">
                        <span>Continue</span>
                    </button>

                    <div class="w-full flex justify-end mt-1">
                        <a href="{{ route('resend.otp') }}" class="text-red-500">
                            Didn’t receive the email? Click to resend.
                        </a>
                    </div>
                    <div class="w-full flex justify-end mt-1">
                        <a href="{{ route('login') }}"> Back to Log in !</a>
                    </div>
                </form>

            </div>
        </section>

    </div>
</body>

</html>
