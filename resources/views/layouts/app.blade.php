<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Moroccan Gladiator')</title>

    <script src="{{ asset('js/bootstrap.js') }}" async></script>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/app-depth.js') }}" defer></script>
    @stack('styles')
    @stack('scripts')
</head>
<body>
    <div id="app">
        <!-- IMPORT HEADER FROM PARTIALS LATER -->
        @yield('header')
        <main class="relative">
            @yield('content')
            <div class='hidden-notification-container flex align-center'>
                <div class="mr8 relative">
                    <img src="" class="hidden-notification-image size60 rounded" alt="">
                    <div class="hidden-notification-type-icon rounded"></div>
                </div>
                <div>
                    <div class="mb4">
                        <strong class="hidden-notification-action-taker">Mouad Nassri</strong>
                        <span class="inline hidden-notification-content">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vitae, suscipit</span>
                    </div>
                    <p class="no-margin blue fs12">Now</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
