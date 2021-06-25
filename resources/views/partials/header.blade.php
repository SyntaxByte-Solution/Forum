<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
?>

<header>
    <div id="header" class="relative">
        <div id="header-logo-container">
            <a href="/">
                <img src='{{ asset("assets/images/logos/large-logo.png") }}' alt="header logo" id="header-logo">
            </a>
        </div>
        <div class="flex align-center full-height">
            <a href="/" class="menu-button-style">{{ __('Home') }}</a>
            <a href="" class="menu-button-style">{{ __('Notifications') }}</a>
            <a href="" class="menu-button-style">{{ __('Announcements') }}</a>
            <a href="" class="menu-button-style">{{ __('Contact') }}</a>
        </div>

        <div id="search-and-login" class="flex align-center move-to-right">
            <div id="header-search-container">
                <form action="{{ route('search') }}" method="GET" class="search-forum">
                    <input type="text" name="k" value="{{ request()->get('k') }}" class="search-field" placeholder="Search everything.." required>
                    <input type="submit" value="{{ __('search') }}" class="search-button">
                </form>
            </div>
            @auth
                @php
                    $user = auth()->user();
                @endphp
                <div class="flex">
                    <div class="relative">
                        <a href="" class="header-profile-button button-with-suboptions">
                            <div class="notifications-icon sprite-icon"></div>
                        </a>    
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                            
                        </div>
                    </div>
                    <div class="relative">
                        <a href="" class="header-profile-button button-with-suboptions">
                            <div class="sprite-icon" style="background-position: 0 -80px"></div>
                        </a>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <a href="" class="flex align-center no-underline button-with-suboptions">
                            <div class='header-profile-button'>
                                <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="header-profile-picture handle-image-center-positioning">
                            </div>
                            <p class="white no-margin fs13 mx4 light-gray">Mouad Nassri <span>▾</span></p>
                        </a>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="flex first-profile-container-part">
                                <a href="{{ route('user.profile', ['user'=>$user->username]) }}">
                                    <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="rounded size36 mr8">
                                </a>
                                <div>
                                    <p class="no-margin fs15 bold unselectable">{{ $user->firstname . ' ' . $user->lastname }}</p>
                                    <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="no-underline">
                                        <p class="no-margin fs12 blue">{{ $user->username }}</p>
                                    </a>

                                </div>
                            </div>
                            <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="suboption-style-1">
                                <img src="{{ asset('assets/images/icons/user.svg') }}" class="small-image-2 mr8" alt="">
                                <p class="no-margin">Profile</p>
                            </a>
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}" class="suboption-style-1">
                                <img src="{{ asset('assets/images/icons/activities.svg') }}" class="small-image-2 mr8" alt="">
                                <p class="no-margin">My activities</p>
                            </a>
                            <a href="/help" class="suboption-style-1">
                                <img src="{{ asset('assets/images/icons/help.svg') }}" class="small-image-2 mr8" alt="">
                                <p class="no-margin">Help</p>
                            </a>
                            <a href="{{ route('user.settings') }}" class="suboption-style-1">
                                <img src="{{ asset('assets/images/icons/settings.svg') }}" class="small-image-2 mr8" alt="">
                                <p class="no-margin">Settings</p>
                            </a>

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="suboption-style-1">
                                <img src="{{ asset('assets/images/icons/logout.svg') }}" class="small-image-2 mr8" alt="">
                                <p class="no-margin">Logout</p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            @guest
            <div id="login" class="flex align-center">
                <div class="sprite-icon white-sprite login-icon mr4"></div>
                <a href="" class="white login-signin-button fs13 light-gray no-underline">Sign-in</a>
            </div>
            @endguest
            <div class="relative mx4">
                @php
                    $local = \Illuminate\Support\Facades\App::currentLocale();
                @endphp
                <a href="" class="flex align-center no-underline button-with-suboptions">
                    <div class='header-profile-button'>
                        <img src='{{ asset("assets/images/icons/$local.svg") }}' alt="profile picture" class="header-profile-picture handle-image-center-positioning">
                    </div>
                </a>
                <div class="suboptions-container suboptions-account-style">
                    <a href="" class="suboption-style-1 @if($local == 'en') block-click @else set-lang @endif" style="@if($local == 'en') background-color: #e6e6e6; cursor: pointer @endif">
                        <img src="{{ asset('assets/images/icons/en.svg') }}" class="small-image-2 mr8" alt="">
                        <p class="no-margin">{{__('English')}}</p>
                        <input type="hidden" class="lang-value" value="en">
                    </a>
                    <a href="" class="suboption-style-1 @if($local == 'fr') block-click @else set-lang @endif" style="@if($local == 'fr') background-color: #e6e6e6; cursor: pointer @endif">
                        <img src="{{ asset('assets/images/icons/fr.svg') }}" class="small-image-2 mr8" alt="">
                        <p class="no-margin">{{__('French')}}</p>
                        <input type="hidden" class="lang-value" value="fr">
                    </a>
                    <a href="" class="suboption-style-1 @if($local == 'ma-ar') block-click @else set-lang @endif" style="@if($local == 'ma-ar') background-color: #e6e6e6; cursor: pointer @endif">
                        <img src="{{ asset('assets/images/icons/ma-ar.svg') }}" class="small-image-2 mr8" alt="">
                        <p class="no-margin">{{ __('Arabic-Morocco') }}</p>
                        <input type="hidden" class="lang-value" value="ma-ar">
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>