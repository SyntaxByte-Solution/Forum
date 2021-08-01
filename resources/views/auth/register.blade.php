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
            <a href="../"><img id="login-top-logo" class="move-to-middle" src="/assets/images/logos/large-logo.png" alt="logo"></a>
        </div>
        <h1 class="forum-color fs26 text-center">{{ __('SIGNUP') }}</h1>
        <p class="fs20 text-center">{{ __('In order to prevent abuse we require users to sign up using social login') }}</p>
        <div>
            <a href="{{ url('/login/google') }}" class="my8 google-auth-button btn-style full-width full-center">
                <svg class="small-image auth-buton-left-icon mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M113.47,309.41,95.65,375.94l-65.14,1.38a256.46,256.46,0,0,1-1.89-239h0l58,10.63L112,206.54a152.85,152.85,0,0,0,1.44,102.87Z" style="fill:#fbbb00"/><path d="M507.53,208.18a255.93,255.93,0,0,1-91.26,247.46l0,0-73-3.72-10.34-64.54a152.55,152.55,0,0,0,65.65-77.91H261.63V208.18h245.9Z" style="fill:#518ef8"/><path d="M416.25,455.62l0,0A256.09,256.09,0,0,1,30.51,377.32l83-67.91a152.25,152.25,0,0,0,219.4,77.95Z" style="fill:#28b446"/><path d="M419.4,58.94l-82.93,67.89A152.23,152.23,0,0,0,112,206.54l-83.4-68.27h0A256,256,0,0,1,419.4,58.94Z" style="fill:#f14336"/></svg>
                Google
            </a>
            <a href="{{ url('/login/facebook') }}" class="my8 facebook-auth-button btn-style full-width full-center">
                <svg class="small-image auth-buton-left-icon mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M456.25,1H54.75A54.75,54.75,0,0,0,0,55.75v401.5A54.75,54.75,0,0,0,54.75,512H211.3V338.27H139.44V256.5H211.3V194.18c0-70.89,42.2-110,106.84-110,31,0,63.33,5.52,63.33,5.52v69.58H345.8c-35.14,0-46.1,21.81-46.1,44.17v53.1h78.45L365.6,338.27H299.7V512H456.25A54.75,54.75,0,0,0,511,457.25V55.75A54.75,54.75,0,0,0,456.25,1Z" style="fill:#fff"/></svg>
                Facebook
            </a>
            <!-- <a href="{{ url('/login/twitter') }}" class="my8 twitter-auth-button btn-style full-width full-center">
                <img src="{{ asset('assets/images/icons/twitter.png') }}" class="small-image auth-buton-left-icon mx8"/>
                Twitter
            </a> -->
        </div>
    </div>
@endsection
