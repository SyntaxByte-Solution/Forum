<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
?>

<header>
    <div id="header" class="relative">
        <div id="header-logo-container">
            <a href="">
                <img src="assets/images/logos/large-logo.png" alt="header logo" id="header-logo">
            </a>
        </div>
        <div class="h-menu">
            <a href="" class="menu-link-button">Home</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">Annoucemenets</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">About Us</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">Contact</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">FAQ</a>
        </div>

        <div id="search-and-login" class="flex align-center move-to-right">
            <div id="header-search-container">
                <form action="" method="POST" class="search-forum">
                    <input type="text" name="search-field" autocomplete="off" class="search-field" placeholder="Search ..">
                    <input type="submit" value="search" class="search-button" style="margin-left: -10px">
                </form>
            </div>
            @auth
                <div class="flex">
                    <div class="relative">
                        <a href="" class="header-profile-button button-with-suboptions">
                            <img src="avatar.jpg" alt="profile picture" class="header-profile-picture">
                        </a>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                            
                            <div class="flex first-profile-container-part">
                                <img src="avatar.jpg" alt="profile picture" class="rounded-style-1">
                                <h2>Mouad Nassri</h2>
                            </div>
                            <a href="" class="suboption-style-1 calendar-icon background-partial">Profile</a>
                            <a href="" class="suboption-style-1 calendar-icon background-partial">Your questions</a>
                            <a href="" class="suboption-style-1 calendar-icon background-partial">Settings</a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="suboption-style-1 calendar-icon background-partial">Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            @guest
            <div id="login">
                <a href="" id="login-signin-button" class="white background-partial">Register / Login</a>
            </div>
            @endguest
        </div>
    </div>
    <div id="second-header">
        <div id="forum-header" class="flex">
            <div class="h-menu">
                <div class="relative">
                    <a href="" class="menu-link-button wmenu-icon button-with-suboptions background-partial">Quick links</a>
                    <div class="suboptions-container suboptions-buttons-style">
                        <a href="" class="menu-link-button calendar-icon background-partial">Today's posts</a>        
                        <a href="" class="menu-link-button calendar-icon background-partial">Today's posts</a>
                        <a href="" class="menu-link-button calendar-icon background-partial">Today's posts</a>
                    </div>
                </div>
                <div class="menu-separator">〡</div>
                <a href="" class="menu-link-button calendar-icon background-partial">Today's posts</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button question-icon background-partial">Questions</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button fire-icon background-partial">Active Topics</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button article-icon background-partial">Articles</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button settings-icon background-partial">Adv. Search</a>
            </div>

            <div class="move-to-right flex align-center">
                <a href="" class="menu-link-button feather-icon background-partial">Become a writer</a>
                <div class="fs11 menu-separator">〡</div>
                <a href="" class="menu-link-button edit-icon background-partial">Add Question</a>
            </div>
        </div>
    </div>

    <div class="absolute full-shadowed zi12">
        <a href="" class="close-shadowed-view"></a>
        <div id="login-view">
            <div>
                <img id="login-top-logo" class="move-to-middle" src="assets/images/logos/b-large-logo.png" alt="logo">
            </div>
            <h1>{{ __('Login') }}</h1>
            <form method="POST" action="{{ route('login') }}" class="move-to-middle">
                @csrf

                <div class="input-container">
                    <label for="email" class="label-style">{{ __('Email address') }} @error('email') <span class="error">*</span> @enderror</label>

                    <input type="email" name="email" class="full-width input-style @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <p class="error">{{ $message }}</p>
                        </span>
                    @enderror
                </div>

                <div class="input-container">
                    <label for="password" class="label-style">{{ __('Password') }} </label>

                    <input type="password" name="password" class="full-width input-style" required placeholder="{{ __('Password') }}" autocomplete="current-password">
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
                <div><strong>Not a member?</strong> <a href="{{ route('register') }}" class="link-style no-underline">{{ __('Signup now') }}</a></div>
            </div>
        </div>
    </div>
</header>