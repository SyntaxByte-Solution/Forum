<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
?>

@push('scripts')
    <script src="{{ asset('js/bootstrap.js') }}"></script>
@endpush

<header>
    <div id="header" class="relative">
        <div id="header-logo-container">
            <a href="/">
                <img src='{{ asset("assets/images/logos/large-logo.png") }}' alt="header logo" id="header-logo" rel="preload">
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
                <div class="flex align-center">
                    <div class="relative">
                        <div class="header-button button-with-suboptions pointer" title="Notifications">
                            <div class="small-image sprite sprite-2-size notifications-icon"></div>
                        </div>    
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                            <div class="suboptions-container-header">
                                <h2>Notifications</h2>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="header-button button-with-suboptions pointer" title="Messages">
                            <div class="small-image sprite sprite-2-size inbox17-icon"></div>
                        </div>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                            <div class="suboptions-container-header">
                                
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex align-center pointer button-with-suboptions">
                            <div class='header-profile-button'>
                                <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="header-profile-picture handle-image-center-positioning hidden-overflow">
                            </div>
                            <p class="no-margin fs13 mx4 light-gray">Mouad Nassri <span>▾</span></p>
                        </div>
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
                                <div class="small-image-2 sprite sprite-2-size profile17-icon mr8"></div>
                                <p class="no-margin">Profile</p>
                            </a>
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}" class="suboption-style-1">
                                <div class="small-image-2 sprite sprite-2-size activities17-icon mr8"></div>
                                <p class="no-margin">My activities</p>
                            </a>
                            <a href="/help" class="suboption-style-1">
                                <div class="small-image-2 sprite sprite-2-size help17-icon mr8"></div>
                                <p class="no-margin">Help</p>
                            </a>
                            <a href="{{ route('user.settings') }}" class="suboption-style-1">
                                <div class="small-image-2 sprite sprite-2-size settings17-icon mr8"></div>
                                <p class="no-margin">Settings</p>
                            </a>

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="suboption-style-1">
                                <div class="small-image-2 sprite sprite-2-size logout17-icon mr8"></div>
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
                <a href="" class="flex align-center login-signin-button fs13 light-gray no-underline">
                    <div class="small-image sprite sprite-2-size wprofile17-icon mr4"></div>
                    Sign-in
                </a>
            </div>
            @endguest
            <div class="relative mx4">
                @php
                    $local = \Illuminate\Support\Facades\App::currentLocale();
                @endphp
                <a href="" class="flex align-center no-underline button-with-suboptions">
                    <div class='header-profile-button'>
                        <div class="size26 sprite sprite-2-size languages26-icon"></div>
                    </div>
                </a>
                <div class="suboptions-container suboptions-account-style">
                    <div class="triangle"></div>
                    <a href="" class="suboption-style-1 @if($local == 'en') block-click @else set-lang @endif" style="@if($local == 'en') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size english17-flag mr8"></div>
                        <p class="no-margin">{{__('English')}}</p>
                        <input type="hidden" class="lang-value" value="en">
                    </a>
                    <a href="" class="suboption-style-1 @if($local == 'fr') block-click @else set-lang @endif" style="@if($local == 'fr') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size french17-flag mr8"></div>
                        <p class="no-margin">{{__('French')}}</p>
                        <input type="hidden" class="lang-value" value="fr">
                    </a>
                    <a href="" class="suboption-style-1 @if($local == 'ma-ar') block-click @else set-lang @endif" style="@if($local == 'ma-ar') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size ma-arabic17-flag mr8"></div>
                        <p class="no-margin">{{ __('Arabic-Morocco') }}</p>
                        <input type="hidden" class="lang-value" value="ma-ar">
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>