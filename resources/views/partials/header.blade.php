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
        <div class="h-menu">
            <a href="/" class="menu-link-button">Home</a>
            <div class="menu-separator">〡</div>
            <a href="" class="menu-link-button">Announcements</a>
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
                            
                            <div class="flex align-center first-profile-container-part">
                                <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="rounded rounded-style-1" style="margin-right: 6px">
                                <h2>Mouad Nassri</h2>
                            </div>
                            <div class="flex align-center relative">
                                <div class="profile-icon black-sprite-icon sprite-size-3 absolute left8"></div>
                                <a href="" class="suboption-style-1 full-width">Profile</a>
                            </div>
                            <div class="flex align-center">
                                <div class="bquestion-icon black-sprite-icon sprite-size-3 absolute left8"></div>
                                <a href="" class="suboption-style-1 full-width">Help</a>
                            </div>
                            <div class="flex align-center">
                                <div class="bsettings-icon black-sprite-icon sprite-size-3 absolute left8"></div>
                                <a href="" class="suboption-style-1 full-width">Settings</a>
                            </div>
                            <div class="flex align-center">
                                <div class="logout-icon black-sprite-icon sprite-size-3 absolute left8"></div>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="suboption-style-1 full-width">Logout</a>
                            </div>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <div class="relative">
                        <a href="" class="header-profile-button button-with-suboptions">
                        @auth
                            <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="header-profile-picture">
                        @endauth
                        @guest
                            <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="header-profile-picture">
                        @endguest
                        </a>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                            
                            <div class="flex align-center first-profile-container-part">
                                <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="rounded rounded-style-1" style="margin-right: 6px">
                                <h2>{{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</h2>
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
                <a href="" id="login-signin-button" class="white">Register / Login</a>
            </div>
            @endguest
        </div>
    </div>
    <!-- <div id="second-header">
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
    </div> -->
</header>