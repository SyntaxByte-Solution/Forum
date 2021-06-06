@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #49516a12;
    }
</style>
<div class="auth-card">
    <div>
        <a href="../"><img id="login-top-logo" class="move-to-middle" src="/assets/images/logos/b-large-logo.png" alt="logo"></a>
    </div>
    <h1>{{ __('Login') }}</h1>
    <form method="POST" action="{{ route('login') }}" class="move-to-middle">
        @csrf

        <div class="input-container">
            <label for="email" class="label-style">{{ __('Email address') }} @error('email') <span class="error">*</span> @enderror</label>

            <input type="email" id="email" name="email" class="full-width input-style @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
            @error('email')
                <p class="error" role="alert">{{ $message }}</p>
            @enderror
        </div>

        <div class="input-container">
            <label for="password" class="label-style">{{ __('Password') }} </label>

            <input type="password" id="password" name="password" class="full-width input-style" required placeholder="{{ __('Password') }}" autocomplete="current-password">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="input-container flex">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="flex" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>

        <div class="input-container">
            <input type="submit" class="button-style block full-width" style="margin-bottom: 8px" value="{{ __('Login') }}">
            @if (Route::has('password.request'))
                <a class="link-style" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </form>
    <div class="line-separator"></div>
    <div class="relative flex align-center">
        <embed src="{{ asset('assets/images/icons/google.svg') }}" class="small-image absolute auth-buton-left-icon" type="image/svg+xml" />
        <a href="{{ url('/login/google') }}" class="google-auth-button button-with-left-icon full-width">Login With google</a>
    </div>
    <div class="line-separator"></div>
    <div>
        <div><strong>Not a member?</strong> <a href="{{ route('register') }}" class="link-style no-underline">{{ __('Signup now') }}</a></div>
    </div>
</div>
@endsection
