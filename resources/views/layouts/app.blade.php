<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Moroccan Gladiator')</title>
    
    <link rel="preload" as="image" href="{{ asset('assets/images/logos/header-logo.png') }}">
    @auth
    <link rel="preload" as="image" href="{{ auth()->user()->sizedavatar(36, '-l') }}">
    @endauth
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
            @include('partials.general.top-message-informer')
            @yield('content')
            @include('partials.notification')
            @include('partials.general.basic-notification')
        </main>
    </div>
</body>
</html>