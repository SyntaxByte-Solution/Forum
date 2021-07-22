<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Moroccan Gladiator')</title>
    
    <script type="application/javascript">
        function preloadImages(srcs) {
            if (!preloadImages.cache) {
                preloadImages.cache = [];
            }
            var img;
            for (var i = 0; i < srcs.length; i++) {
                img = new Image();
                img.src = srcs[i];
                preloadImages.cache.push(img);
            }
        }

        // then to call it, you would use this
        var imageSrcs = ["/assets/images/icons/basic-sprite.png", "/assets/images/icons/sp.png", '/assets/images/logos/large-logo.png'];

        preloadImages(imageSrcs);
    </script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('js/imagesloaded.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/app-depth.js') }}" defer></script>
    @stack('styles')
    @stack('scripts')
</head>
<body>
    <div id="app">
        <!-- IMPORT HEADER FROM PARTIALS LATER -->
        @yield('header')
        <main class="relative">
            @yield('content')
            @include('partials.notification')
            @include('partials.general.tick-notification')
            @include('partials.thread.report')
        </main>
    </div>
</body>
</html>
