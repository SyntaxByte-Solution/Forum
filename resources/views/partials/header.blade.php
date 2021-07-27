<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
?>

<header>
    <input type="hidden" class="uid" value="@auth{{ auth()->user()->id }}@endauth">
    <div id="header" class="relative">
        <div id="header-logo-container" style="min-width: 133px">
            <a href="/">
                <img src='{{ asset("assets/images/logos/large-logo.png") }}' alt="header logo" id="header-logo">
            </a>
        </div>
        <div class="flex align-center full-height">
            <a href="/" class="menu-button-style">{{ __('Home') }}</a>
            <a href="{{ route('user.notifications') }}" class="menu-button-style">{{ __('Notifications') }}</a>
            <a href="" class="menu-button-style">{{ __('Announcements') }}</a>
            <a href="" class="menu-button-style">{{ __('Contact') }}</a>
        </div>

        <div id="search-and-login" class="flex align-center move-to-right">
            <div id="header-search-container">
                <form action="{{ route('search') }}" method="GET" class="search-forum relative">
                    <svg class="header-search-field-icon" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                    <input type="text" name="k" value="{{ request()->get('k') }}" class="search-field" placeholder="{{ __('Search everything') }}.." title="{{ __('search field') }}" required>
                    <input type="submit" value="{{ __('search') }}" class="search-button">
                </form>
            </div>
            @auth
                @php
                    $user = auth()->user();
                    if($unread_notifications_counter = $user->unreadNotifications->count()) {
                        $unread_notifications_counter = ($unread_notifications_counter > 99) 
                            ? ('+'.$unread_notifications_counter)
                            : $unread_notifications_counter;
                    }
                @endphp
                <div class="flex align-center">
                    <div class="relative">
                        <div class="header-button-counter-indicator @if(!$unread_notifications_counter) none @endif">{{ $unread_notifications_counter }}</div>
                        <div class="header-button button-with-suboptions pointer notification-button" title="Notifications">
                            <!-- let's try using paths -->
                            <svg class="small-image-2" fill="#FFFFFF" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M439.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C118.56,68.1,64.08,130.3,64.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,0,384c.11,16.4,13,32,32.1,32H415.9c19.12,0,32-15.6,32.1-32a31.23,31.23,0,0,0-8.61-21.71ZM67.53,368c21.22-28,44.42-74.33,44.53-159.42,0-.2-.06-.38-.06-.58a112,112,0,0,1,224,0c0,.2-.06.38-.06.58.11,85.1,23.31,131.46,44.53,159.42ZM224,512a64,64,0,0,0,64-64H160A64,64,0,0,0,224,512Z"/></svg>
                        </div>    
                        <div class="suboptions-container suboptions-header-button-style">
                            <div class="triangle"></div>
                            <div class="suboptions-container-header flex align-center space-between">
                                <h2 class="no-margin">Notifications</h2>
                                <a href="{{ route('user.notifications') }}" class="link-path">{{ __('See all') }}</a>
                            </div>
                            <div class="suboptions-container-dims notifs-box">
                                @foreach($user->notifs as $notification)
                                    @if($loop->index == 6)
                                        @break
                                    @endif
                                    <x-user.header-notification :notification="$notification"/>
                                @endforeach
                                <div class="notification-empty-box my8 @if($user->notifications->count()) none @endif">
                                    <div class="size28 sprite sprite-2-size binbox28-icon move-to-middle"></div>
                                    <h3 class="my4 fs17 text-center">{{__('Notifications box is empty')}}</h3>
                                    <p class="my4 fs13 gray text-center">{{ __('Try to start discussions/questions or react to people posts') }}.</p>
                                </div>
                                @if($user->notifs->count() > 6)
                                    <input type='button' class="see-all-full-style notifications-load" value="{{__('load more')}}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="header-button button-with-suboptions pointer" title="Messages">
                            <svg class="small-image-2" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M510.19,217,441.74,59.83c-2.93-6.7-8.91-10.94-15.46-10.94H85.72c-6.55,0-12.53,4.24-15.45,10.94L1.81,217A22,22,0,0,0,0,225.76V443.38c0,10.9,7.73,19.73,17.26,19.73H494.74c9.53,0,17.26-8.83,17.26-19.73V225.76A22,22,0,0,0,510.19,217ZM96.4,88.34H415.6l51.56,118.35H355.52c-8.15,0-15.21,6.61-16.9,15.73C338,225.75,322.75,304,253.12,304s-84.88-78.25-85.48-81.5c-1.63-9.2-8.71-15.81-16.92-15.81H44.84ZM477.48,423.66h-443V246.14H137.63c12.12,40.39,46.64,97.31,115.49,97.31s103.38-56.92,115.5-97.31H477.48V423.66Z"/></svg>
                        </div>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="triangle"></div>
                            <div class="suboptions-container-header">
                                
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex align-center pointer button-with-suboptions">
                            <div class='header-profile-button relative has-fade' style="align-items: flex-start">
                                <div class="fade-loading"></div>
                                <img src="{{ auth()->user()->avatar }}" alt="profile picture" class="header-profile-picture handle-image-center-positioning">
                            </div>
                            <p class="no-margin fs13 mx4 light-gray">{{ $user->username }} <span>▾</span></p>
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
                                <svg class="size17 mr8" fill="#000000" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="currentColor" d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                                <p class="no-margin">{{__('Profile')}}</p>
                            </a>
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}" class="suboption-style-1">
                                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,0H64A64.08,64.08,0,0,0,0,64V448a64.08,64.08,0,0,0,64,64H448a64.07,64.07,0,0,0,64-64V64A64.08,64.08,0,0,0,448,0Zm21.33,448A21.35,21.35,0,0,1,448,469.33H64A21.34,21.34,0,0,1,42.67,448V64A21.36,21.36,0,0,1,64,42.67H448A21.36,21.36,0,0,1,469.33,64ZM147.63,119.89a22.19,22.19,0,0,0-4.48-7c-1.07-.85-2.14-1.7-3.2-2.56a16.41,16.41,0,0,0-3.84-1.92,13.77,13.77,0,0,0-3.84-1.28,20.49,20.49,0,0,0-12.38,1.28,24.8,24.8,0,0,0-7,4.48,22.19,22.19,0,0,0-4.48,7,20.19,20.19,0,0,0,0,16.22,22.19,22.19,0,0,0,4.48,7A22.44,22.44,0,0,0,128,149.33a32.71,32.71,0,0,0,4.27-.42,13.77,13.77,0,0,0,3.84-1.28,16.41,16.41,0,0,0,3.84-1.92c1.06-.86,2.13-1.71,3.2-2.56A22.44,22.44,0,0,0,149.33,128,21.38,21.38,0,0,0,147.63,119.89ZM384,106.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM148.91,251.73a13.77,13.77,0,0,0-1.28-3.84,16.41,16.41,0,0,0-1.92-3.84c-.86-1.06-1.71-2.13-2.56-3.2a24.8,24.8,0,0,0-7-4.48,21.38,21.38,0,0,0-16.22,0,24.8,24.8,0,0,0-7,4.48c-.85,1.07-1.7,2.14-2.56,3.2a16.41,16.41,0,0,0-1.92,3.84,13.77,13.77,0,0,0-1.28,3.84,32.71,32.71,0,0,0-.42,4.27A21.1,21.1,0,0,0,128,277.33,21.12,21.12,0,0,0,149.34,256,34.67,34.67,0,0,0,148.91,251.73ZM384,234.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66ZM147.63,375.89a20.66,20.66,0,0,0-27.74-11.52,24.8,24.8,0,0,0-7,4.48,24.8,24.8,0,0,0-4.48,7,21.38,21.38,0,0,0-1.7,8.11,21.33,21.33,0,1,0,42.66,0A17.9,17.9,0,0,0,147.63,375.89ZM384,362.67H213.33a21.33,21.33,0,0,0,0,42.66H384a21.33,21.33,0,0,0,0-42.66Z"/></svg>
                                <p class="no-margin">{{__('My activities')}}</p>
                            </a>
                            <a href="/help" class="suboption-style-1">
                                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <p class="no-margin">{{__('Help')}}</p>
                            </a>
                            <a href="{{ route('user.settings') }}" class="suboption-style-1">
                                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,133.61A122.39,122.39,0,1,0,378.39,256,122.54,122.54,0,0,0,256,133.61Zm0,214.18A91.79,91.79,0,1,1,347.79,256,91.9,91.9,0,0,1,256,347.79ZM500,197.7l-39.35-8.55a214,214,0,0,0-12.66-30.54l21.78-33.89a15.3,15.3,0,0,0-2.05-19.09l-61.3-61.3a15.3,15.3,0,0,0-19.09-2L353.39,64.06A214,214,0,0,0,322.85,51.4L314.3,12.05A15.31,15.31,0,0,0,299.35,0h-86.7a15.31,15.31,0,0,0-15,12.05L189.15,51.4a214,214,0,0,0-30.54,12.66L124.72,42.28a15.3,15.3,0,0,0-19.09,2l-61.3,61.3a15.3,15.3,0,0,0-2,19.09l21.78,33.89A214,214,0,0,0,51.4,189.15L12.05,197.7a15.31,15.31,0,0,0-12,15v86.7A15.31,15.31,0,0,0,12.05,314.3l39.35,8.55a214,214,0,0,0,12.66,30.54L42.28,387.28a15.3,15.3,0,0,0,2,19.09l61.3,61.3a15.3,15.3,0,0,0,19.09,2.05l33.89-21.78a214,214,0,0,0,30.54,12.66L197.7,500a15.31,15.31,0,0,0,15,12.05h86.7A15.31,15.31,0,0,0,314.3,500l8.55-39.35a214,214,0,0,0,30.54-12.66l33.89,21.78a15.3,15.3,0,0,0,19.09-2.05l61.3-61.3a15.3,15.3,0,0,0,2.05-19.09l-21.78-33.89a214,214,0,0,0,12.66-30.54L500,314.3A15.31,15.31,0,0,0,512,299.35v-86.7A15.31,15.31,0,0,0,500,197.7ZM481.4,287l-36.08,7.84a15.33,15.33,0,0,0-11.49,10.84,183.41,183.41,0,0,1-16.95,40.88,15.29,15.29,0,0,0,.46,15.79l20,31.08-43.87,43.87-31.08-20a15.29,15.29,0,0,0-15.79-.46,183.41,183.41,0,0,1-40.88,16.95,15.33,15.33,0,0,0-10.84,11.49L287,481.4H225l-7.84-36.08a15.33,15.33,0,0,0-10.84-11.49,183.41,183.41,0,0,1-40.88-16.95,15.29,15.29,0,0,0-15.79.46l-31.08,20L74.69,393.45l20-31.08a15.29,15.29,0,0,0,.46-15.79,183.88,183.88,0,0,1-17-40.88,15.31,15.31,0,0,0-11.49-10.84L30.6,287V225l36.08-7.84A15.33,15.33,0,0,0,78.17,206.3a183.41,183.41,0,0,1,17-40.88,15.29,15.29,0,0,0-.46-15.79l-20-31.08,43.87-43.87,31.08,20a15.29,15.29,0,0,0,15.79.46,183.41,183.41,0,0,1,40.88-17,15.33,15.33,0,0,0,10.84-11.49L225,30.6h62l7.84,36.08A15.33,15.33,0,0,0,305.7,78.17a183.41,183.41,0,0,1,40.88,17,15.29,15.29,0,0,0,15.79-.46l31.08-20,43.86,43.87-20,31.08a15.29,15.29,0,0,0-.46,15.79,183.88,183.88,0,0,1,16.95,40.88,15.31,15.31,0,0,0,11.49,10.84L481.4,225Z"/></svg>
                                <p class="no-margin">{{__('Settings')}}</p>
                            </a>

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="suboption-style-1">
                                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M496,240H293.32a16,16,0,1,1,0-32H496a16,16,0,0,1,0,32Zm-80,80a16,16,0,0,1-11.31-27.33L473.37,224,404.68,155.3a16,16,0,0,1,22.63-22.64l80,80a16,16,0,0,1,0,22.63l-80,80A15.87,15.87,0,0,1,416,320ZM170.66,512a44,44,0,0,1-13.22-2L29.05,467.24A43.06,43.06,0,0,1,0,426.67v-384A42.71,42.71,0,0,1,42.67,0,44.07,44.07,0,0,1,55.89,2L184.27,44.77a43.06,43.06,0,0,1,29.06,40.58v384A42.72,42.72,0,0,1,170.66,512ZM42.67,32A10.71,10.71,0,0,0,32,42.68v384A11.08,11.08,0,0,0,39.4,437l127.78,42.58a11.53,11.53,0,0,0,3.48.47,10.7,10.7,0,0,0,10.67-10.67v-384a11.09,11.09,0,0,0-7.41-10.29L46.14,32.48A11.73,11.73,0,0,0,42.67,32ZM325.32,170.68a16,16,0,0,1-16-16v-96A26.7,26.7,0,0,0,282.66,32h-240a16,16,0,1,1,0-32h240a58.71,58.71,0,0,1,58.66,58.66v96A16,16,0,0,1,325.32,170.68ZM282.66,448H197.33a16,16,0,0,1,0-32h85.33a26.7,26.7,0,0,0,26.66-26.66v-96a16,16,0,0,1,32,0v96A58.71,58.71,0,0,1,282.66,448Z"/></svg>
                                <p class="no-margin">{{__('Logout')}}</p>
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
                    <svg class="size20 mr4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="currentColor" d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                    {{__('Sign-in')}}
                </a>
            </div>
            @endguest
            <div class="relative mx4">
                @php
                    $local = \Illuminate\Support\Facades\App::currentLocale();
                @endphp
                <div class="flex align-center no-underline button-with-suboptions pointer" title="{{ __('Languages') }}">
                    <div class='header-profile-button'>
                        <svg class="size24" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M138.71,137h-6.42l-12,60h30.42ZM381.37,257A157,157,0,0,0,406,300.47c9.53-12,19.15-26.07,25.63-43.47ZM467,91H280.72l38.84,311.68c.69,12.75-2.8,24.75-11.12,34.14L242.66,512H467a45.05,45.05,0,0,0,45-45V137C512,112.19,491.81,91,467,91Zm0,166h-4a190.35,190.35,0,0,1-36.13,65.7c11,10.08,22.8,18.34,34.51,27.6a15,15,0,1,1-18.75,23.4c-12.72-10-24.67-18.45-36.62-29.42-11.95,11-22.9,19.38-35.63,29.42a15,15,0,0,1-18.75-23.4c11.72-9.26,22.5-17.52,33.52-27.6-14.06-16.89-26.6-38.32-35.13-65.7h-4a15,15,0,0,1,0-30h45V212a15,15,0,0,1,30,0v15h46a15,15,0,0,1,0,30ZM244.16,39.42A45.05,45.05,0,0,0,199.52,0H45A45.05,45.05,0,0,0,0,45V377a45.05,45.05,0,0,0,45,45H281.55c4.38-5,8.05-8.13,8.2-14.66C289.79,405.7,244.37,41,244.16,39.42ZM183.94,286.71a15,15,0,0,1-17.65-11.77L156.71,227H114.29l-9.58,47.94a15,15,0,1,1-29.42-5.88l30-150A15,15,0,0,1,120,107h31a15,15,0,0,1,14.71,12.06l30,150A15,15,0,0,1,183.94,286.71ZM175.26,452l2.58,20.58c1.71,13.78,10.87,27.84,25.93,34.86L254.13,452Z"/></svg>
                    </div>
                </div>
                <div class="suboptions-container suboptions-account-style">
                    <div class="triangle"></div>
                    <a href="" class="suboption-style-1 @if($local == 'en') block-click @else set-lang @endif" style="@if($local == 'en') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size english17-flag mr8"></div>
                        <p class="no-margin">{{__('English')}}</p>
                        <div class="loading-dots-anim ml4 none">•</div>
                        <input type="hidden" class="lang-value" value="en">
                    </a>
                    <a href="" class="suboption-style-1 @if($local == 'fr') block-click @else set-lang @endif" style="@if($local == 'fr') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size french17-flag mr8"></div>
                        <p class="no-margin">{{__('French')}}</p>
                        <div class="loading-dots-anim ml4 none">•</div>
                        <input type="hidden" class="lang-value" value="fr">
                    </a>
                    <a href="" class="suboption-style-1 @if($local == 'ma-ar') block-click @else set-lang @endif" style="@if($local == 'ma-ar') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size ma-arabic17-flag mr8"></div>
                        <p class="no-margin">{{ __('Arabic-Morocco') }}</p>
                        <div class="loading-dots-anim ml4 none">•</div>
                        <input type="hidden" class="lang-value" value="ma-ar">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="loading-strip" class="none">
        <div class="loading-strip-line"></div>
    </div>
</header>