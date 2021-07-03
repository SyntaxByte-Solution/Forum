@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
@endpush

@section('header')
    @include('partials.header')
@endsection

<style>
    #avatar-preview {
        margin: 8px 0;
        width: 260px;
        height: 260px;

        background-color: gray;
    }

    .auth-card {
        border: 1px solid #d7d7d7;
    }
</style>



@section('content')
    <div class="auth-card relative">
        <a href="/login" class="back-to-login link-style">< {{ __('Back to login') }}</a>
        <div>
            <a href="../"><img id="login-top-logo" class="move-to-middle" src="/assets/images/logos/b-large-logo.png" alt="logo"></a>
        </div>
        <h1 class="forum-color fs26 text-center">{{ __('SIGNUP') }}</h1>
        <p class="fs20 text-center">{{ __('In order to prevent abuse we require users to sign up using social login') }}</p>
        <div>
            <a href="{{ url('/login/google') }}" class="my8 google-auth-button btn-style full-width full-center">
                <embed src="{{ asset('assets/images/icons/google.svg') }}" class="small-image auth-buton-left-icon mx8" type="image/svg+xml" />
                Google
            </a>
            <a href="{{ url('/login/facebook') }}" class="my8 facebook-auth-button btn-style full-width full-center">
                <img src="{{ asset('assets/images/icons/fb.png') }}" class="small-image auth-buton-left-icon mx8"/>
                Facebook
            </a>
            <a href="{{ url('/login/twitter') }}" class="my8 twitter-auth-button btn-style full-width full-center">
                <img src="{{ asset('assets/images/icons/twitter.png') }}" class="small-image auth-buton-left-icon mx8"/>
                Twitter
            </a>
        </div>
    </div>
@endsection
