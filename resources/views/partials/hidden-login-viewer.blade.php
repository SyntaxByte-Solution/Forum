@php
    $show_login_view = '';
@endphp
@if(!auth()->user())
    @if(!$errors->isEmpty())
        @php
            $show_login_view = "display:block;opacity:1;z-index:100";
        @endphp
    @endif
@endif

<div class="fixed full-shadowed" style="{{ $show_login_view }}z-index:90; margin-top: 52px">
        <div class="close-shadowed-view-button close-button-style" style="right: 20px; top: 20px">
            <span>✖</span>
        </div>
        <div id="login-view" class="auth-card">
            <div>
                <img id="login-top-logo" class="move-to-middle" src="{{ asset('assets/images/logos/header-logo.png') }}" load="lazy" alt="logo">
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
                        <svg class="small-image auth-buton-left-icon mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M113.47,309.41,95.65,375.94l-65.14,1.38a256.46,256.46,0,0,1-1.89-239h0l58,10.63L112,206.54a152.85,152.85,0,0,0,1.44,102.87Z" style="fill:#fbbb00"/><path d="M507.53,208.18a255.93,255.93,0,0,1-91.26,247.46l0,0-73-3.72-10.34-64.54a152.55,152.55,0,0,0,65.65-77.91H261.63V208.18h245.9Z" style="fill:#518ef8"/><path d="M416.25,455.62l0,0A256.09,256.09,0,0,1,30.51,377.32l83-67.91a152.25,152.25,0,0,0,219.4,77.95Z" style="fill:#28b446"/><path d="M419.4,58.94l-82.93,67.89A152.23,152.23,0,0,0,112,206.54l-83.4-68.27h0A256,256,0,0,1,419.4,58.94Z" style="fill:#f14336"/></svg>
                        Google
                    </a>
                    <a href="{{ url('/login/facebook') }}" class="facebook-auth-button btn-style half-width full-center ml4">
                        <svg class="small-image auth-buton-left-icon mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M456.25,1H54.75A54.75,54.75,0,0,0,0,55.75v401.5A54.75,54.75,0,0,0,54.75,512H211.3V338.27H139.44V256.5H211.3V194.18c0-70.89,42.2-110,106.84-110,31,0,63.33,5.52,63.33,5.52v69.58H345.8c-35.14,0-46.1,21.81-46.1,44.17v53.1h78.45L365.6,338.27H299.7V512H456.25A54.75,54.75,0,0,0,511,457.25V55.75A54.75,54.75,0,0,0,456.25,1Z" style="fill:#fff"/></svg>
                        Facebook
                    </a>
                </div>
                <!-- <a href="{{ url('/login/twitter') }}" class="twitter-auth-button btn-style full-width full-center ">
                    <img src="{{ asset('assets/images/icons/twitter.png') }}" class="small-image auth-buton-left-icon mx8"/>
                    Twitter
                </a> -->
            </div>
            <div class="line-separator"></div>
            <div>
                <div class="flex">
                    <strong>{{ __('Not a member') }}?</strong>
                    <a href="{{ route('register') }}" class="link-style no-underline ml4">{{ __('Signup now') }}</a>
                </div>
            </div>
        </div>
    </div>