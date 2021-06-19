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
            <a href="/" class="menu-button-style button-with-strip relative">
                <span class="white bold">Home</span>
                <div class="menu-botton-bottm-strip"></div>
            </a>
            <a href="" class="menu-button-style button-with-strip relative">
                <span class="white bold">Announcements</span>
                <div class="menu-botton-bottm-strip"></div>
            </a>
            <a href="" class="menu-button-style button-with-strip relative">
                <span class="white bold">About Us</span>
                <div class="menu-botton-bottm-strip"></div>
            </a>
            <a href="" class="menu-button-style button-with-strip relative">
                <span class="white bold">Contact</span>
                <div class="menu-botton-bottm-strip"></div>
            </a>
            <a href="" class="menu-button-style button-with-strip relative">
                <span class="white bold">FAQs</span>
                <div class="menu-botton-bottm-strip"></div>
            </a>
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
                            <div class="notifications-icon sprite-icon"></div>
                        </a>    
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                            
                        </div>
                    </div>
                    <div class="relative">
                        <a href="" class="header-profile-button button-with-suboptions">
                            <div class="feedback-icon sprite-icon"></div>
                        </a>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <a href="" class="full-center header-profile-button button-with-suboptions">
                            <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="header-profile-picture handle-image-center-positioning">
                        </a>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                            
                            
                            <div class="flex first-profile-container-part">
                                <a href="{{ route('user.profile', ['user'=>auth()->user()->username]) }}">
                                    <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="rounded size36 mr8">
                                </a>
                                <div>
                                    <p class="no-margin fs15 bold unselectable">{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</p>
                                    <a href="{{ route('user.profile', ['user'=>auth()->user()->username]) }}" class="no-underline">
                                        <p class="no-margin fs12 blue">{{ auth()->user()->username }}</p>
                                    </a>

                                </div>
                            </div>
                            <a href="" class="suboption-style-1 profile-icon background-partial-1">Profile</a>
                            <a href="" class="suboption-style-1 bquestion-icon background-partial-1">Your questions</a>
                            <a href="" class="suboption-style-1 bquestion-icon background-partial-1">Help</a>
                            <a href="" class="suboption-style-1 bsettings-icon background-partial-1">Settings</a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="suboption-style-1 logout-icon background-partial-1">Logout</a>

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
                <a href="" class="white login-signin-button">Register / Login</a>
            </div>
            @endguest
        </div>
    </div>
</header>