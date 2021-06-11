@php
    $show_login_view = '';
@endphp
@if(!auth()->user())
    @if($errors->has('email'))
        @if($errors->first('email') == __("These credentials do not match our records."))
            @php
                $show_login_view = "display:block;opacity:1";
            @endphp
        @endif
    @endif
@endif

<div class="fixed full-shadowed zi12" style="{{ $show_login_view }}">
        <a href="" class="close-shadowed-view close-shadowed-view-button"></a>
        <div id="login-view" class="auth-card">
            <div>
                <img id="login-top-logo" class="move-to-middle" src="{{ asset('assets/images/logos/b-large-logo.png') }}" alt="logo">
            </div>
            <h1>{{ __('Login') }}</h1>
            <form method="POST" action="{{ route('login') }}" class="move-to-middle">
                @csrf

                <div class="input-container">
                    <label for="email" class="label-style">{{ __('Email address / Username') }} @error('email') <span class="error">*</span> @enderror</label>

                    <input type="text" id="email" name="email" class="full-width input-style @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <p class="error">{{ $message }}</p>
                        </span>
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
            <div>
                <div class="my8 flex">
                    <a href="{{ url('/login/google') }}" class="google-auth-button btn-style half-width full-center mr4">
                        <embed src="{{ asset('assets/images/icons/google.svg') }}" class="small-image auth-buton-left-icon mx8" type="image/svg+xml" />
                        Google
                    </a>
                    <a href="{{ url('/login/facebook') }}" class="facebook-auth-button btn-style half-width full-center ml4">
                        <img src="{{ asset('assets/images/icons/fb.png') }}" class="small-image auth-buton-left-icon mx8"/>
                        Facebook
                    </a>
                </div>
                <a href="{{ url('/login/twitter') }}" class="twitter-auth-button btn-style full-width full-center ">
                    <img src="{{ asset('assets/images/icons/twitter.png') }}" class="small-image auth-buton-left-icon mx8"/>
                    Twitter
                </a>
            </div>
            <div class="line-separator"></div>
            <div>
                <div class="flex">
                    <strong>Not a member?</strong>
                    <a href="{{ route('register') }}" class="link-style no-underline ml4">{{ __('Signup now') }}</a>
                </div>
            </div>
        </div>
    </div>