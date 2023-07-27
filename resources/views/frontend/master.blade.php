<!DOCTYPE html>
<html lang="en">

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

    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta name="author" content="Qtec Solution Limited">

    <meta name="description" content="{{ readconfig('meta_description') }}">
    <meta name="keywords" content="{{ readconfig('meta_keywords') }}">
    <!-- OPEN-GRAPH META TAGS -->
    <meta property="og:title" content="{{ readconfig('site_name') }}">
    <meta property="og:description" content="{{ readconfig('meta_description') }}">
    <meta property="og:image" content="{{ assetImage(readconfig('favicon_icon')) }}">

    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">

    @if (readconfig('custom_css'))
        <style>
            {{ readconfig('custom_css') }}
        </style>
    @endif

    @vite('resources/css/app.css')
    @stack('style')
</head>

<body>
    <x-frontend.header />
    @include('simple-alert')

    {{-- === main content === --}}
    <div class="main-content">
        @yield('content')
    </div>
    {{-- === main content end === --}}

    @include('frontend.footer')
    @stack('script')

</body>

</html>
