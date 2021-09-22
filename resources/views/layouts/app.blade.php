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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <script type="text/javascript" src="{{ asset('js/imagesloaded.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/core.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
    @stack('scripts')
</head>
<body>
    <div id="app">
        <!-- IMPORT HEADER FROM PARTIALS LATER -->
        @yield('header')
        @include('partials.thread.poll.option-delete-viewer')
        @include('partials.thread.delete-viewer')
        <main class="relative">
            @include('partials.shared-components')
            @yield('content')
        </main>
    </div>
</body>
</html>