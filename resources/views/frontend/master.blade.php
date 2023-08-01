<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ readConfig('site_name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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


    {{-- Google Tags and google analytics --}}
    @if (readConfig('google_analytics_status') == 1 &&
            readConfig('google_analytics_id') &&
            readConfig('google_analytics_type') == 'id')
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', "{!! readConfig('google_analytics_id') !!}");
        </script>
        <!-- End Google Tag Manager -->
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

    {{-- Google Tags and google analytics --}}
    @if (readConfig('google_analytics_status') == 1)
        <!-- Google Tag Manager (noscript) -->
        @if (readConfig('google_analytics_id') && readConfig('google_analytics_type') == 'id')
            <noscript>
                <iframe src="//www.googletagmanager.com/ns.html?id={!! readConfig('google_analytics_id') !!}" height="0"
                    width="0" style="display:none;visibility:hidden"></iframe>
            </noscript>
        @endif
        <!-- End Google Tag Manager (noscript) -->
        @if (readConfig('google_analytics_type') == 'code')
            {!! readConfig('google_analytics_code') !!}
        @endif
    @endif

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    @stack('script')

</body>

</html>
