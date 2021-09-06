<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
?>

<header>
    <input type="hidden" class="uid" autocomplete="off" value="@auth{{ auth()->user()->id }}@endauth">
    <div id="header" class="relative">
        <div id="header-logo-container" style="min-width: 144px; max-width: 144px">
            <a href="/">
                <img src='{{ asset("assets/images/logos/header-logo.png") }}' alt="header logo" id="header-logo">
            </a>
        </div>
        <div class="flex align-center full-height" style="margin-left: 10px;">
            <a href="/" class="menu-button-style">
                <svg class="size14 mr8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                <span style="margin-top: 1px; @if(isset($globalpage) && $globalpage == 'home') color: white; @endif">{{ __('Home') }}</span>
                @if(isset($globalpage) && $globalpage == 'home')
                <div class="menu-button-style-selected-stripe"></div>
                @endif
            </a>
            <a href="{{ route('explore') }}" class="menu-button-style">
                <svg class="size14 mr8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 510 510"><path d="M255,227A28.05,28.05,0,1,0,283.05,255,28.3,28.3,0,0,0,255,227ZM255,0C114.75,0,0,114.75,0,255S114.75,510,255,510,510,395.25,510,255,395.25,0,255,0Zm56.1,311.1L102,408l96.9-209.1L408,102Z"/></svg>
                <span style="margin-top: 1px; @if(isset($globalpage) && $globalpage == 'explore') color: white; @endif">{{ __('Explore') }}</span>
                @if(isset($globalpage) && $globalpage == 'explore')
                <div class="menu-button-style-selected-stripe"></div>
                @endif
            </a>
            <a href="{{ route('announcements') }}" class="menu-button-style">
                <svg class="size14 mr8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 390.34 390.34"><path d="M294.17,21.07c-3.29,0-6.52,2.08-9.6,6.18-.33.44-34.42,44.62-119.62,70.89-6.23,1.92-13.57,4.39-21.86,5.4-4.59.56-5.67-.41-6-1.07a15,15,0,0,0-13.13-7.79H39.78a15,15,0,0,0-15,15v5.58c0,3.38-2.38,3.53-3.21,3.59l-2,.15A21.48,21.48,0,0,0,0,140.08v56.24a21.47,21.47,0,0,0,19.6,21.07l2.8.22c.68,0,2.38.65,2.38,3.65v5.45a15,15,0,0,0,15,15h6.51a3.6,3.6,0,0,1,3.44,2.91L73,350.69c2.29,10.42,12.44,18.58,23.1,18.58H123a16.56,16.56,0,0,0,16.66-20.72L116.91,244.92s-.87-3.21,2.38-3.21h4.63c5.63,0,10.11-3.37,13.09-7.71,1.28-1.86,3.94-1.59,5.38-1.29,8.46,1.71,16.15,3.56,22.56,5.54,85.2,26.32,119.28,70.45,119.61,70.89,3.08,4.11,6.32,6.19,9.61,6.19h0a7.68,7.68,0,0,0,7-4.62,17.38,17.38,0,0,0,1.43-7.57V33.25C302.56,21.66,295.57,21.07,294.17,21.07Zm72.31,71.81A10,10,0,1,0,350,104.23c13.3,19.29,20.33,42.54,20.33,67.27s-7.35,48.71-20.7,67.81A10,10,0,1,0,366,250.76c15.89-22.75,24.3-50.16,24.3-79.26C390.34,142.7,382.09,115.52,366.48,92.88Zm-32.86,28.26a10,10,0,0,0-16.47,11.35A68.47,68.47,0,0,1,329,171.61a69.33,69.33,0,0,1-12,39.44,10,10,0,0,0,16.4,11.46,90.74,90.74,0,0,0,.29-101.37Z"/></svg>
                <span style="@if(isset($globalpage) && $globalpage == 'announcements') color: white; @endif">{{ __('Announcements') }}</span>
                @if(isset($globalpage) && $globalpage == 'announcements')
                <div class="menu-button-style-selected-stripe"></div>
                @endif
            </a>
            <a href="{{ route('contactus') }}" class="menu-button-style">
                <svg class="size14 mr8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,64H400V16A16,16,0,0,0,384,0H96A48.06,48.06,0,0,0,48,48V448a64.06,64.06,0,0,0,64,64H448a16,16,0,0,0,16-16V80A16,16,0,0,0,448,64ZM368,400a16,16,0,0,1-16,16H160a16,16,0,0,1-16-16V368a80.09,80.09,0,0,1,80-80h64a80.07,80.07,0,0,1,80,80ZM192,192a64,64,0,1,1,64,64A64.06,64.06,0,0,1,192,192ZM368,64H96a16,16,0,0,1,0-32H368Z"/></svg>
                <span style="@if(isset($globalpage) && $globalpage == 'contactus') color: white; @endif">{{ __('Contact Us') }}</span>
                @if(isset($globalpage) && $globalpage == 'contactus')
                <div class="menu-button-style-selected-stripe"></div>
                @endif
            </a>
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
                            <svg class="small-image-2" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                        </div>    
                        <div class="suboptions-container suboptions-header-button-style">
                            <div class="triangle"></div>
                            <div class="suboptions-container-header flex align-center space-between">
                                <div class="flex align-center">
                                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                                    <h2 class="no-margin">Notifications</h2>
                                </div>
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
                                    <svg class="flex size28 move-to-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 438.53 438.53"><path d="M431.4,211l-68-157.6A25.47,25.47,0,0,0,353,41.4q-7.56-4.86-15-4.86H100.5q-7.43,0-15,4.86a25.52,25.52,0,0,0-10.42,12L7.14,211A91.85,91.85,0,0,0,0,246.1V383.72a17.59,17.59,0,0,0,5.42,12.85A17.61,17.61,0,0,0,18.27,402h402a18.51,18.51,0,0,0,18.26-18.27V246.1A91.84,91.84,0,0,0,431.4,211ZM292.07,237.54,265,292.36H173.59l-27.12-54.82H56.25a12.85,12.85,0,0,0,.71-2.28,13.71,13.71,0,0,1,.72-2.29L118.2,91.37H320.34L380.86,233c.2.58.43,1.34.71,2.29s.53,1.7.72,2.28Z"/></svg>
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
                            <svg class="small-image-2" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                        </div>
                        <div class="suboptions-container suboptions-header-button-style">
                            <div class="triangle"></div>
                            <div class="suboptions-container-header">
                                <div class="flex align-center">
                                    <svg class="size18 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                                    <h2 class="no-margin">Messages</h2>
                                </div>
                            </div>
                            <div class="suboptions-container-dims messages-box" style="overflow-y: unset">
                                <div style="width: 80%; margin: 0 auto">
                                    <svg class="flex size34 move-to-middle my8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                                    <h3 class="my4 fs17 text-center">{{__('Chatting and rooms features are not available in the current time')}}</h3>
                                    <p class="my4 fs13 gray text-center">{{ __('We are working on these features and you are going to receive a notification as soon as we complete them') }}.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="header-button button-with-suboptions pointer" title="{{ __('Quick access') }}">
                            <svg class="small-image-2" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M106.67,0H21.33A21.34,21.34,0,0,0,0,21.33v85.34A21.34,21.34,0,0,0,21.33,128h85.34A21.34,21.34,0,0,0,128,106.67V21.33A21.34,21.34,0,0,0,106.67,0Zm0,192H21.33A21.34,21.34,0,0,0,0,213.33v85.34A21.34,21.34,0,0,0,21.33,320h85.34A21.34,21.34,0,0,0,128,298.67V213.33A21.34,21.34,0,0,0,106.67,192Zm0,192H21.33A21.34,21.34,0,0,0,0,405.33v85.34A21.34,21.34,0,0,0,21.33,512h85.34A21.34,21.34,0,0,0,128,490.67V405.33A21.34,21.34,0,0,0,106.67,384Zm192-384H213.33A21.34,21.34,0,0,0,192,21.33v85.34A21.34,21.34,0,0,0,213.33,128h85.34A21.34,21.34,0,0,0,320,106.67V21.33A21.34,21.34,0,0,0,298.67,0Zm0,192H213.33A21.34,21.34,0,0,0,192,213.33v85.34A21.34,21.34,0,0,0,213.33,320h85.34A21.34,21.34,0,0,0,320,298.67V213.33A21.34,21.34,0,0,0,298.67,192Zm0,192H213.33A21.34,21.34,0,0,0,192,405.33v85.34A21.34,21.34,0,0,0,213.33,512h85.34A21.34,21.34,0,0,0,320,490.67V405.33A21.34,21.34,0,0,0,298.67,384Zm192-384H405.33A21.34,21.34,0,0,0,384,21.33v85.34A21.34,21.34,0,0,0,405.33,128h85.34A21.34,21.34,0,0,0,512,106.67V21.33A21.34,21.34,0,0,0,490.67,0Zm0,192H405.33A21.34,21.34,0,0,0,384,213.33v85.34A21.34,21.34,0,0,0,405.33,320h85.34A21.34,21.34,0,0,0,512,298.67V213.33A21.34,21.34,0,0,0,490.67,192Zm0,192H405.33A21.34,21.34,0,0,0,384,405.33v85.34A21.34,21.34,0,0,0,405.33,512h85.34A21.34,21.34,0,0,0,512,490.67V405.33A21.34,21.34,0,0,0,490.67,384Z"/></svg>
                        </div>
                        <div class="suboptions-container" style="display: block">
                            <div id="quick-access-box">
                                <div class="triangle"></div>
                                <div id="quick-access-header">
                                    <div class="flex align-center">
                                        <svg class="size16 mr8" fill="#000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M106.67,0H21.33A21.34,21.34,0,0,0,0,21.33v85.34A21.34,21.34,0,0,0,21.33,128h85.34A21.34,21.34,0,0,0,128,106.67V21.33A21.34,21.34,0,0,0,106.67,0Zm0,192H21.33A21.34,21.34,0,0,0,0,213.33v85.34A21.34,21.34,0,0,0,21.33,320h85.34A21.34,21.34,0,0,0,128,298.67V213.33A21.34,21.34,0,0,0,106.67,192Zm0,192H21.33A21.34,21.34,0,0,0,0,405.33v85.34A21.34,21.34,0,0,0,21.33,512h85.34A21.34,21.34,0,0,0,128,490.67V405.33A21.34,21.34,0,0,0,106.67,384Zm192-384H213.33A21.34,21.34,0,0,0,192,21.33v85.34A21.34,21.34,0,0,0,213.33,128h85.34A21.34,21.34,0,0,0,320,106.67V21.33A21.34,21.34,0,0,0,298.67,0Zm0,192H213.33A21.34,21.34,0,0,0,192,213.33v85.34A21.34,21.34,0,0,0,213.33,320h85.34A21.34,21.34,0,0,0,320,298.67V213.33A21.34,21.34,0,0,0,298.67,192Zm0,192H213.33A21.34,21.34,0,0,0,192,405.33v85.34A21.34,21.34,0,0,0,213.33,512h85.34A21.34,21.34,0,0,0,320,490.67V405.33A21.34,21.34,0,0,0,298.67,384Zm192-384H405.33A21.34,21.34,0,0,0,384,21.33v85.34A21.34,21.34,0,0,0,405.33,128h85.34A21.34,21.34,0,0,0,512,106.67V21.33A21.34,21.34,0,0,0,490.67,0Zm0,192H405.33A21.34,21.34,0,0,0,384,213.33v85.34A21.34,21.34,0,0,0,405.33,320h85.34A21.34,21.34,0,0,0,512,298.67V213.33A21.34,21.34,0,0,0,490.67,192Zm0,192H405.33A21.34,21.34,0,0,0,384,405.33v85.34A21.34,21.34,0,0,0,405.33,512h85.34A21.34,21.34,0,0,0,512,490.67V405.33A21.34,21.34,0,0,0,490.67,384Z"/></svg>
                                        <span class="no-margin fs20 bold">{{ __('Quick access') }}</span>
                                    </div>
                                </div>
                                <div id="quick-access-content-box">
                                    <div id="quick-access-panel">
                                        <div>
                                            <a href="{{ auth()->user()->profilelink }}" class="no-underline flex align-center button-with-icon-style">
                                                <svg class="size17 mr8" fill="#181818" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                                                <span class="fs16 bblack">{{ __('Profile') }}</span>
                                            </a>
                                            <a href="{{ route('user.activities', ['user'=>auth()->user()->username]) }}" class="no-underline flex align-center button-with-icon-style">
                                                <svg class="size17 mr8" fill="#181818" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M80,368H16A16,16,0,0,0,0,384v64a16,16,0,0,0,16,16H80a16,16,0,0,0,16-16V384A16,16,0,0,0,80,368ZM80,48H16A16,16,0,0,0,0,64v64a16,16,0,0,0,16,16H80a16,16,0,0,0,16-16V64A16,16,0,0,0,80,48Zm0,160H16A16,16,0,0,0,0,224v64a16,16,0,0,0,16,16H80a16,16,0,0,0,16-16V224A16,16,0,0,0,80,208ZM496,384H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V400A16,16,0,0,0,496,384Zm0-320H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V80A16,16,0,0,0,496,64Zm0,160H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V240A16,16,0,0,0,496,224Z"/></svg>
                                                <span class="fs16 bblack">{{ __('My Activities') }}</span>
                                            </a>
                                            <a href="{{ route('user.settings') }}" class="no-underline flex align-center button-with-icon-style">
                                                <svg class="size17 mr8" fill="#181818" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                                                <span class="fs16 bblack">{{ __('Settings') }}</span>
                                            </a>
                                            <span class="block fs18 bold bblack my8 unselectable">{{ __('Create') }}</span>
                                            <div class="pl8">
                                                <a href="{{ route('thread.add') }}" class="no-underline flex align-center button-with-icon-style">
                                                    <svg class="size17 mr8" fill="#181818" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.18,217.58a23.4,23.4,0,0,0-23.4,23.4V428.2a23.42,23.42,0,0,1-23.4,23.4H83.76a23.42,23.42,0,0,1-23.4-23.4V100.57a23.42,23.42,0,0,1,23.4-23.4H271a23.4,23.4,0,0,0,0-46.8H83.76a70.29,70.29,0,0,0-70.21,70.2V428.2a70.29,70.29,0,0,0,70.21,70.2H411.38a70.29,70.29,0,0,0,70.21-70.2V241A23.39,23.39,0,0,0,458.18,217.58Zm-302,56.25a11.86,11.86,0,0,0-3.21,6l-16.54,82.75a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L233,359.76a11.68,11.68,0,0,0,6-3.21L424.12,171.4,341.4,88.68ZM481.31,31.46a58.53,58.53,0,0,0-82.72,0L366.2,63.85l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72ZM155.72,273.08a11.86,11.86,0,0,0-3.21,6L136,361.8a11.69,11.69,0,0,0,11.49,14,11.26,11.26,0,0,0,2.29-.23L232.48,359a11.68,11.68,0,0,0,6-3.21L423.62,170.65,340.9,87.93ZM480.81,30.71a58.53,58.53,0,0,0-82.72,0L365.7,63.1l82.73,82.72,32.38-32.39a58.47,58.47,0,0,0,0-82.72Z"/></svg>
                                                    <span class="fs16 bblack">{{ __('Discussion') }}</span>
                                                </a>
                                                <div class="flex align-center button-with-icon-style">
                                                    <svg class="size17 mr8" fill="#181818" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 478 478"><path d="M128.5,191.61H33.81A15.86,15.86,0,0,0,18,207.42V444.14A15.8,15.8,0,0,0,33.81,460H128.5a15.81,15.81,0,0,0,15.81-15.81V207.42A15.81,15.81,0,0,0,128.5,191.61Z"/><path d="M286.34,18.05H191.66a15.78,15.78,0,0,0-15.82,15.72V444.14A15.8,15.8,0,0,0,191.66,460h94.68a15.81,15.81,0,0,0,15.82-15.81V33.86A15.8,15.8,0,0,0,286.34,18.05Z"/><path d="M444.19,144.27H349.5a15.74,15.74,0,0,0-15.81,15.81V444.14A15.8,15.8,0,0,0,349.5,460h94.69A15.81,15.81,0,0,0,460,444.14V160.08A15.8,15.8,0,0,0,444.19,144.27Z"/></svg>
                                                    <span class="fs16 bblack">{{ __('Poll') }}</span>
                                                </div>
                                            </div>
                                            <div class="simple-line-separator my8"></div>
                                            <a href="{{ route('contactus') }}" class="no-underline flex align-center button-with-icon-style">
                                                <svg class="size20 mr8" fill="#181818" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128,132,57.22,238.11,256,470,454.78,238.11,384,132Zm83,90H104l35.65-53.49Zm-30-60H331l-75,56.25Zm60,90V406.43L108.61,252Zm30,0H403.39L271,406.43Zm30-30,71.32-53.49L408,222ZM482,72V42H452V72H422v30h30v30h30V102h30V72ZM60,372H30v30H0v30H30v30H60V432H90V402H60ZM0,282H30v30H0Zm482-90h30v30H482Z"/></svg>
                                                <span class="fs16 bblack">{{ __('Feedback') }}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="quick-access-content">
                                        @php
                                            $forums = \App\Models\Forum::all();
                                            $categories = $forums->first()->categories()->excludeannouncements()->get();
                                            $category = $categories->first();
                                        @endphp
                                        <span class="block bold forum-color fs19 mb8">{{ __('Forums & Categories') }}</span>
                                        <div class="forum-category-changer-box">
                                            <div class="flex align-center">
                                                <span class="fs11 lblack bold mr4">{{__('FORUM')}} :</span>
                                                <div class="relative flex align-center">
                                                    <div class="relative flex align-center forum-color nested-soc-button pointer thread-add-posted-to fs13">
                                                        <svg class="small-image-size fcc-selected-forum-ico mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                            <polygon points="207.22 174.76 309.32 0 457.57 0 355.48 174.76 207.22 174.76" style="fill:#f1543f"/><polygon points="58.46 0 160.55 174.76 308.81 174.76 206.72 0 58.46 0" style="fill:#ff7058"/><circle cx="258.02" cy="323.63" r="188.37" style="fill:#f8b64c"/><circle cx="258.02" cy="323.63" r="148.86" style="fill:#ffd15c"/><circle cx="258.02" cy="323.63" r="112.68" style="fill:#f8b64c"/><polygon points="258.02 244.31 283.82 296.52 341.37 304.88 299.74 345.5 309.52 402.95 258.02 375.84 206.51 402.95 216.29 345.5 174.66 304.88 232.21 296.52 258.02 244.31" style="fill:#ffd15c"/>
                                                        </svg>
                                                        <span class="fcc-selected-forum">{{ __($forums->first()->forum) }}</span>
                                                        <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                                                    </div>
                                                    <div class="spinner fcc_spinner size14 opacity0" style="fill: #2ca0ff; margin-left: 2px">
                                                        <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                                    </div>
                                                    <div class="suboptions-container nested-soc thread-add-suboptions-container" style="max-height: 236px; overflow-y: scroll">
                                                        @foreach($forums as $forum)
                                                        <div class="flex align-center">
                                                            <div class="thread-add-suboption forum-category-changer flex align-center full-width">
                                                                <svg class="small-image-size forum-ico mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                    {!! $forum->icon !!}
                                                                </svg>
                                                                <span class="forum-name mr8">{{ __($forum->forum) }}</span>
                                                                <div class="loading-dots-anim ml4 none">•</div>
                                                                <input type="hidden" class="forum-id" value="{{ $forum->id }}">
                                                            </div>
                                                            <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="flex no-underline underline-when-hover blue bold fs13 ml8">{{ __('visit') }}</a>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <a href="{{ route('forums') }}" class="flex align-center no-underline blue fs12 bold move-to-right">
                                                    <svg class="size14 mr4" style="margin-top: -2px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M352,289V416H64V128h96V64H32A32,32,0,0,0,0,96V448a32,32,0,0,0,32,32H384a32,32,0,0,0,32-32V289Z"/><path d="M505.6,131.2l-128-96A16,16,0,0,0,352,48V96H304C206.94,96,128,175,128,272a16,16,0,0,0,12.32,15.59A16.47,16.47,0,0,0,144,288a16,16,0,0,0,14.3-8.83l3.78-7.52A143.2,143.2,0,0,1,290.88,192H352v48a16,16,0,0,0,25.6,12.8l128-96a16,16,0,0,0,0-25.6Z"/></svg>
                                                    {{ __('Forums') }}
                                                </a>
                                            </div>
                                            <div class="relative flex width-max-content" style="margin-left: 17px">
                                                <svg class="size14 mr8" style="margin-top: 1px" fill="#d2d2d2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284.93 284.93"><polygon points="281.33 281.49 281.33 246.99 38.25 246.99 38.25 4.75 3.75 4.75 3.75 281.5 38.25 281.5 38.25 281.49 281.33 281.49"/></svg>
                                                <span class="fs11 lblack bold mr4" style="margin-top: 6px">{{__('CATEGORY')}} :</span>
                                                <div class="flex align-center">
                                                    <div class="flex align-center fcc-selected-category forum-color nested-soc-button pointer light-grey-hover fs13 br4" style="padding: 5px 8px">
                                                        <span class="thread-add-selected-category">{{ __('All categories') }}</span>
                                                        <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                                                    </div>
                                                    <div class="suboptions-container nested-soc thread-add-suboptions-container" style="width: max-content; max-height: 236px; overflow-y: scroll; right: 0">
                                                        <div class="fcc-categories-container">
                                                            <a href="{{ route('forum.all.threads', ['forum'=>$forums->first()->slug]) }}" class="no-underline black thread-add-suboption fcc-category flex align-center">
                                                                <span class="thread-add-category-val">{{ __('All categories') }}</span>
                                                            </a>
                                                            @foreach($categories as $category)
                                                                <a href="{{ route('category.threads', ['forum'=>$category->forum->slug, 'category'=>$category->slug]) }}" class="no-underline black thread-add-suboption fcc-category flex align-center">
                                                                    <span class="thread-add-category-val">{{ __($category->category) }}</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simple-line-separator my8"></div>
                                        <div class="my8">
                                            <div class="flex align-center space-between mb8">
                                                <span class="block bold forum-color fs19">{{ __('Search') }}</span>
                                                <a href="{{ route('advanced.search') }}" class="flex align-center no-underline blue bold move-to-right fs13">
                                                    <svg class="size12 mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511"><path d="M492,0H21A20,20,0,0,0,1,20,195,195,0,0,0,66.37,165.55l87.42,77.7a71.1,71.1,0,0,1,23.85,53.12V491a20,20,0,0,0,31,16.6l117.77-78.51a20,20,0,0,0,8.89-16.6V296.37a71.1,71.1,0,0,1,23.85-53.12l87.41-77.7A195,195,0,0,0,512,20,20,20,0,0,0,492,0ZM420.07,135.71l-87.41,77.7a111.1,111.1,0,0,0-37.25,83V401.82l-77.85,51.9V296.37a111.1,111.1,0,0,0-37.25-83L92.9,135.71A155.06,155.06,0,0,1,42.21,39.92H470.76A155.06,155.06,0,0,1,420.07,135.71Z"/></svg>
                                                    {{ __('Adv. search') }}
                                                </a>
                                            </div>
                                            <div class="mb4">
                                                <style>
                                                    .search-path-switcher {
                                                        padding: 2px 4px;
                                                        border-radius: 3px;
                                                        border: 1px solid gray;
                                                        cursor: pointer;
                                                    }
                                                    .search-path-switcher:hover {
                                                        box-shadow: 0 0 2px 0 #999;
                                                    }
                                                    .search-path-switcher-selected {
                                                        fill: #2ca0ff;
                                                        color: #2ca0ff !important;
                                                        border-color: #2ca0ff;
                                                    }
                                                </style>
                                                <span class="fs12 mb2">{{ __('Search for') }} :</span>
                                                <div class="flex align-center" style="margin: 2px 0">
                                                    <div class="flex align-center search-path-switcher search-path-switcher-selected lblack mr4">
                                                        <svg class="mr4 size13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.67,0H53.33A53.39,53.39,0,0,0,0,53.33V458.67A53.39,53.39,0,0,0,53.33,512H458.67A53.39,53.39,0,0,0,512,458.67V53.33A53.39,53.39,0,0,0,458.67,0Zm10.66,53.33V234.67h-192v-192H458.67A10.68,10.68,0,0,1,469.33,53.33Zm-416-10.66H234.67v192h-192V53.33A10.68,10.68,0,0,1,53.33,42.67Zm-10.66,416V277.33h192v192H53.33A10.68,10.68,0,0,1,42.67,458.67Zm416,10.66H277.33v-192h192V458.67A10.68,10.68,0,0,1,458.67,469.33Z"/></svg>
                                                        <span class="fs13 bold">{{ __('All') }}</span>
                                                        <input type="hidden" class="search-path" value="{{ route('search') }}">
                                                    </div>
                                                    <div class="flex align-center search-path-switcher lblack mr4">
                                                        <svg class="mr4 size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M317,31H45A44.94,44.94,0,0,0,0,76V256a44.94,44.94,0,0,0,45,45H60v45c0,10.84,11.22,18.69,22.2,13.2.3-.3.9-.3,1.2-.6,82.52-55.33,64-43,82.5-55.2A15.09,15.09,0,0,1,174,301H317a44.94,44.94,0,0,0,45-45V76A44.94,44.94,0,0,0,317,31ZM197,211H75c-19.77,0-19.85-30,0-30H197C216.77,181,216.85,211,197,211Zm90-60H75c-19.77,0-19.85-30,0-30H287C306.77,121,306.85,151,287,151Zm180,0H392V256a75,75,0,0,1-75,75H178.5L150,349.92V376a44.94,44.94,0,0,0,45,45H342.5l86.1,57.6c11.75,6.53,23.4-1.41,23.4-12.6V421h15a44.94,44.94,0,0,0,45-45V196A44.94,44.94,0,0,0,467,151Z"/></svg>
                                                        <span class="fs13 bold">{{ __('Discussions') }}</span>
                                                        <input type="hidden" class="search-path" value="{{ route('threads.search') }}">
                                                    </div>
                                                    <div class="flex align-center search-path-switcher lblack">
                                                        <svg class="mr4 size13" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511"><path d="M413.88,250.22A126.79,126.79,0,0,0,256.09,52.27a126.85,126.85,0,0,0-158,198A180.21,180.21,0,0,0,1.94,410.37v54.44A18.15,18.15,0,0,0,20.09,483H491.92a18.15,18.15,0,0,0,18.14-18.15V410.37A180.21,180.21,0,0,0,413.88,250.22ZM328.59,65.57A90.61,90.61,0,0,1,365.88,238.8c-1.4.64-2.79,1.22-4.21,1.82a90.14,90.14,0,0,1-13.81,4.3c-.91.2-1.81.31-2.74.49a90.08,90.08,0,0,1-16,1.61c-2.41,0-4.84-.18-7.26-.4a13.87,13.87,0,0,1-2.72-.18,91.7,91.7,0,0,1-29.67-8.74c-.35-.17-.75-.15-1.09-.29-1.81-.88-3.63-1.64-5.24-2.62.14-.18.23-.38.38-.56A127.24,127.24,0,0,0,303,198.82l.56-1.52a128,128,0,0,0,4.81-18.68c.17-.92.29-1.81.44-2.81a127.46,127.46,0,0,0,1.65-19.51,127.05,127.05,0,0,0-1.65-19.47c-.15-.94-.27-1.81-.44-2.81a126.76,126.76,0,0,0-4.81-18.68l-.56-1.52a127.39,127.39,0,0,0-19.43-35.41c-.15-.18-.24-.38-.38-.56A90.15,90.15,0,0,1,328.59,65.57ZM92.67,156.3A90.5,90.5,0,0,1,245.82,90.76c1.05,1,2.09,2,3.1,3.08a93.61,93.61,0,0,1,8.61,10.44c.79,1.12,1.52,2.32,2.26,3.48A87.92,87.92,0,0,1,266.45,120c.46,1,.8,2.09,1.2,3.12a88.72,88.72,0,0,1,4.5,14.52c.13.54.17,1.09.27,1.65a85.37,85.37,0,0,1,0,34.15c-.11.56-.14,1.11-.27,1.65a88.72,88.72,0,0,1-4.5,14.52c-.4,1-.74,2.09-1.2,3.12A88.76,88.76,0,0,1,259.79,205c-.74,1.16-1.47,2.36-2.26,3.49a93.5,93.5,0,0,1-8.61,10.43c-1,1.05-2,2.07-3.1,3.09a90.6,90.6,0,0,1-25.06,16.91c-1.47.67-3,1.29-4.47,1.81a90.38,90.38,0,0,1-13.46,4.18c-1.14.25-2.32.4-3.48.6a90.28,90.28,0,0,1-14.94,1.5h-2a90.16,90.16,0,0,1-14.93-1.5c-1.16-.2-2.34-.35-3.49-.6a90.74,90.74,0,0,1-13.46-4.18c-1.51-.59-3-1.21-4.46-1.81A90.75,90.75,0,0,1,92.67,156.3ZM328.59,446.66H38.23V410.37a144.28,144.28,0,0,1,96.51-136.76,126.62,126.62,0,0,0,97.34,0,145.88,145.88,0,0,1,17.68,7.82c3.77,1.94,7.26,4.16,10.89,6.39,2.36,1.47,4.75,2.9,7,4.52,3.5,2.48,6.8,5.19,10.05,8,2.09,1.82,4.16,3.63,6.12,5.45,3,2.83,5.81,5.82,8.51,8.89,1.94,2.21,3.83,4.46,5.63,6.79,2.37,3.05,4.64,6.17,6.75,9.38,1.81,2.72,3.43,5.55,5,8.38,1.82,3.12,3.49,6.25,5,9.49s2.87,6.81,4.17,10.28c1.15,3,2.36,6,3.31,9.07,1.27,4.21,2.16,8.56,3.05,12.92.54,2.58,1.25,5.1,1.65,7.71a151.69,151.69,0,0,1,1.65,21.71v36.29Zm145.18,0H364.88V410.37c0-5.68-.32-11.31-.83-16.88-.15-1.63-.4-3.25-.58-4.88-.49-4-1.05-8-1.82-11.92-.32-1.69-.67-3.37-1-5.07q-1.31-6.06-3-12c-.38-1.31-.73-2.63-1.13-3.92a179.83,179.83,0,0,0-21.86-45.86l-.71-1q-4.68-7-10-13.45l-.13-.16a164.86,164.86,0,0,0-11.7-13h.74a126.65,126.65,0,0,0,15.45,1.09h1a128.88,128.88,0,0,0,14.3-.92c1.49-.18,3-.46,4.45-.69q5.79-.88,11.43-2.31c1.07-.27,2.16-.52,3.25-.83a121.66,121.66,0,0,0,14.52-4.94,144.28,144.28,0,0,1,96.58,136.8v36.29Z"/></svg>
                                                        <span class="fs13 bold">{{ __('Users') }}</span>
                                                        <input type="hidden" class="search-path" value="{{ route('users.search') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('search') }}" method="GET" class="quick-access-search-form relative flex">
                                                <svg class="header-search-field-icon" style="width: 13px; height: 13px" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                                                <input type="text" name="k" value="{{ request()->get('k') }}" class="search-field full-width" style="min-width: unset; border: 1px solid #c1c1c1; font-size: 12px; padding: 6px 6px 6px 26px" placeholder="{{ __('Search keywords') }}.." title="{{ __('search field') }}" required>
                                                <button type="submit" class="search-button full-center">
                                                    <svg class="size14" fill="#fff" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                        <div class="simple-line-separator" style="margin: 12px 0 8px 0"></div>
                                        <div>
                                            <span class="block bold forum-color fs19 my8">{{ __('Quick links') }}</span>
                                            <span class="fs11 lblack bold">{{__('EXPLORE DISCUSSIONS')}}</span>
                                            <div class="mt4">
                                                <a href="{{ route('explore') . '?sortby=popular-and-recent' }}" class="thread-add-suboption flex no-underline">
                                                    <svg class="size17 mr4" style="margin-top: 1px; min-width: 17px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path d="M380.27,162.56l-16-13-7.47,19.26c-.14.37-14.48,36.62-36.5,30A15.58,15.58,0,0,1,310,190c-5.47-11.72-3.14-32.92,5.93-54,12.53-29.18,7-59.75-15.88-88.41a161.1,161.1,0,0,0-36.32-32.88L240.23,0l.52,27.67c0,.49.52,49.65-35.88,67.67-22.3,11-38.26,29.31-45,51.43a79,79,0,0,0,7.21,62.09c4.44,7.67,5.78,14.19,4,19.35-2.55,7.38-10.79,11.18-13.25,12.17-26,10.45-43-24.44-43.74-25.88l-11.87-25.33-14.54,23.9A196.29,196.29,0,0,0,59.18,315.19c0,107.73,87,195.51,194.46,196.78.78,0,1.57,0,2.36,0h0c108.53,0,196.82-88.29,196.82-196.81a196.15,196.15,0,0,0-72.55-152.63ZM194.44,420.43v-.19c-.15-11.94,2.13-24.75,6.78-38.22l37,10.82.37-19.63c.57-30.07,17.53-48.52,31.08-58.51a135.37,135.37,0,0,0,16.38,40.84c8.53,13.92,16.61,25.72,24.06,36.39,4.79,6.87,7.51,17.24,7.45,28.44v.08A61.52,61.52,0,0,1,256,482h0a61.63,61.63,0,0,1-61.55-61.55ZM338.62,460a91.08,91.08,0,0,0,9-39.56c.08-17.5-4.48-33.73-12.85-45.73s-15.42-22.39-23.08-34.89c-8.54-14-13.68-30.42-15.7-50.3l-2-19.44L275.7,277c-1.72.65-17.19,6.75-33.06,21.14-16.82,15.26-27.68,34.14-32,55.33l-26.84-7.85-5.29,12.08c-9.59,21.87-14.34,43-14.11,62.78a91,91,0,0,0,9.05,39.57,166.81,166.81,0,0,1-71-210.09c1.33,1.47,2.75,2.94,4.25,4.39,18.39,17.7,40.54,22.62,62.38,13.85,14.76-5.92,25.85-16.94,30.44-30.23,3.27-9.46,4.81-24.8-6.38-44.17a48.12,48.12,0,0,1-4.46-38.38c4.26-14.1,14.75-25.89,29.53-33.22C249.31,106.83,262,77.9,267.22,56A117.11,117.11,0,0,1,277,66.83c15.42,19.56,19.23,38.82,11.3,57.26-12.67,29.49-14.74,58.86-5.55,78.57a45.48,45.48,0,0,0,28.87,24.93c20.6,6.18,40.75-1,56.73-20.25a98.36,98.36,0,0,0,6.64-9A166.76,166.76,0,0,1,338.62,460Z"/>
                                                    </svg>
                                                    <div>
                                                        <p class="no-margin sort-by-val bold forum-color">{{ __('Popular and recent') }}</p>
                                                        <p class="no-margin fs12 gray">{{ __('Get most recent discussions and sort by views') }}</p>
                                                        <input type="hidden" class="sort-by-key" value="popular-and-recent">
                                                    </div>
                                                </a>
                                                <a href="{{ route('explore') . '?sortby=replies-and-likes' }}" class="thread-add-suboption flex no-underline">
                                                    <svg class="size17 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/>
                                                    </svg>
                                                    <div>
                                                        <p class="no-margin sort-by-val bold forum-color">{{ __('Replies and likes') }}</p>
                                                        <p class="no-margin fs12 gray">{{ __('Sort by most viewed and replied discussions') }}</p>
                                                        <input type="hidden" class="sort-by-key" value="replies-and-likes">
                                                    </div>
                                                </a>
                                                <a href="{{ route('explore') . '?sortby=votes' }}" class="thread-add-suboption flex no-underline">
                                                    <svg class="size15 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path d="M50.25,340.54c-21,0-39.37-10.63-46.89-27.09-6.1-13.32-3.82-27.63,6.24-39.27L215.27,35.67c9.53-11.06,24.34-17.4,40.62-17.4S287,24.61,296.5,35.67l206.09,238.4c9.95,11.66,12.13,26,6,39.36-7.57,16.41-25.95,27-46.82,27h-73V285.76h22.81a9.4,9.4,0,0,0,8.61-5.32,8.34,8.34,0,0,0-1.34-9L263.19,91.07a9.92,9.92,0,0,0-7.28-3.24,9.73,9.73,0,0,0-7.06,3L93.08,271.49a8.31,8.31,0,0,0-1.33,9,9.4,9.4,0,0,0,8.61,5.34h22v54.72ZM350,493.73a39,39,0,0,0,38.81-39.15V285.82H327.68v146H183.33v-146h-61V454.58a39,39,0,0,0,38.81,39.15Z" style="fill:#010202"/>
                                                    </svg>
                                                    <div>
                                                        <p class="no-margin sort-by-val bold forum-color">{{ __('Top votes') }}</p>
                                                        <p class="no-margin fs12 gray">{{ __('Get most voted discussions') }}</p>
                                                        <input type="hidden" class="sort-by-key" value="votes">
                                                    </div>
                                                </a>
                                                <a href="" class="thread-add-suboption flex no-underline">
                                                    <svg class="size15 mr4" style="min-width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#353535"/></svg>
                                                    <div>
                                                        <p class="no-margin sort-by-val bold forum-color">{{ __('Discussions with best reply') }}</p>
                                                        <p class="no-margin fs12 gray">{{ __('List discussions that has a best reply and sorting from the newest to the oldest') }}</p>
                                                        <input type="hidden" class="sort-by-key" value="has-best-reply">
                                                    </div>
                                                </a>
                                            </div>
                                            <span class="block fs11 lblack bold my4">{{__('OTHER LINKS')}}</span>
                                            <div class="flex flex-wrap">
                                                <div class="flex relative my4" style="margin-right: 12px">
                                                    <a href="{{ route('guidelines') }}" class="no-underline blue underline-when-hover">{{__('Guidelines')}}</a>
                                                </div>
                                                <div class="flex relative my4" style="margin-right: 12px">
                                                    <a href="{{ route('about') }}" class="no-underline blue underline-when-hover">{{__('About Us')}}</a>
                                                </div>
                                                <div class="flex relative my4" style="margin-right: 12px">
                                                    <a href="{{ route('faqs') }}" class="no-underline blue underline-when-hover" title="Frequently Asked Questions">{{ __('FAQs') }}</a>
                                                </div>
                                                <div class="flex relative my4" style="margin-right: 12px">
                                                    <a href="{{ route('privacy') }}" class="no-underline blue underline-when-hover" title="Frequently Asked Questions">{{ __('Privacy Policy') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex align-center pointer button-with-suboptions">
                            <div class='header-profile-button relative' style="align-items: flex-start">
                                <img src="{{ auth()->user()->sizedavatar(36, '-l') }}" alt="profile picture" class="header-profile-picture size36">
                            </div>
                            <p class="no-margin fs13 mx4 light-gray flex align-center">
                                {{ $user->username }} 
                                <svg class="size7 ml8" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                            </p>
                        </div>
                        <div class="suboptions-container suboptions-account-style">
                            <div class="flex first-profile-container-part">
                                <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="relative">
                                    <img src="{{ auth()->user()->sizedavatar(36, '-l') }}" alt="profile picture" class="rounded size36 mr8">
                                </a>
                                <div>
                                    <p class="no-margin fs15 bold unselectable">{{ $user->firstname . ' ' . $user->lastname }}</p>
                                    <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="no-underline">
                                        <p class="no-margin fs12 blue">{{ $user->username }}</p>
                                    </a>

                                </div>
                            </div>
                            <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="suboption-style-1">
                                <svg class="size17 mr8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
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
                                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 174.25 174.25"><path d="M173.15,73.91A7.47,7.47,0,0,0,168.26,68l-13.72-4.88a70.76,70.76,0,0,0-2.76-6.7L158,43.27a7.47,7.47,0,0,0-.73-7.63A87.22,87.22,0,0,0,138.6,17a7.45,7.45,0,0,0-7.62-.72l-13.14,6.24a70.71,70.71,0,0,0-6.7-2.75L106.25,6a7.46,7.46,0,0,0-5.9-4.88,79.34,79.34,0,0,0-26.45,0A7.45,7.45,0,0,0,68,6L63.11,19.72a70.71,70.71,0,0,0-6.7,2.75L43.27,16.23a7.47,7.47,0,0,0-7.63.72A87.17,87.17,0,0,0,17,35.64a7.47,7.47,0,0,0-.73,7.63l6.24,13.15a70.71,70.71,0,0,0-2.75,6.7L6,68A7.47,7.47,0,0,0,1.1,73.91,86.15,86.15,0,0,0,0,87.13a86.25,86.25,0,0,0,1.1,13.22A7.47,7.47,0,0,0,6,106.26l13.73,4.88a72.06,72.06,0,0,0,2.76,6.71L16.22,131a7.47,7.47,0,0,0,.72,7.62,87.08,87.08,0,0,0,18.71,18.7,7.42,7.42,0,0,0,7.62.72l13.14-6.24a70.71,70.71,0,0,0,6.7,2.75L68,168.27a7.45,7.45,0,0,0,5.9,4.88,86.81,86.81,0,0,0,13.22,1.1,86.94,86.94,0,0,0,13.23-1.1,7.46,7.46,0,0,0,5.9-4.88l4.88-13.73a69.83,69.83,0,0,0,6.71-2.75L131,158a7.42,7.42,0,0,0,7.62-.72,87.26,87.26,0,0,0,18.7-18.7A7.45,7.45,0,0,0,158,131l-6.25-13.14q1.53-3.25,2.76-6.71l13.72-4.88a7.46,7.46,0,0,0,4.88-5.91,86.25,86.25,0,0,0,1.1-13.22A87.44,87.44,0,0,0,173.15,73.91ZM159,93.72,146.07,98.3a7.48,7.48,0,0,0-4.66,4.92,56,56,0,0,1-4.5,10.94,7.44,7.44,0,0,0-.19,6.78l5.84,12.29a72.22,72.22,0,0,1-9.34,9.33l-12.28-5.83a7.42,7.42,0,0,0-6.77.18,56.13,56.13,0,0,1-11,4.5,7.46,7.46,0,0,0-4.91,4.66L93.71,159a60.5,60.5,0,0,1-13.18,0L76,146.07A7.48,7.48,0,0,0,71,141.41a56.29,56.29,0,0,1-11-4.5,7.39,7.39,0,0,0-6.77-.18L41,142.56a72.14,72.14,0,0,1-9.33-9.33l5.84-12.29a7.5,7.5,0,0,0-.19-6.78,56.31,56.31,0,0,1-4.5-10.94,7.48,7.48,0,0,0-4.66-4.92L15.3,93.72a60.5,60.5,0,0,1,0-13.18L28.18,76A7.48,7.48,0,0,0,32.84,71a56.29,56.29,0,0,1,4.5-11,7.48,7.48,0,0,0,.19-6.77L31.69,41A72.22,72.22,0,0,1,41,31.69l12.29,5.84a7.44,7.44,0,0,0,6.78-.18A56,56,0,0,1,71,32.85,7.5,7.5,0,0,0,76,28.19l4.58-12.88a59.27,59.27,0,0,1,13.18,0L98.3,28.19a7.49,7.49,0,0,0,4.91,4.66,56.13,56.13,0,0,1,11,4.5,7.42,7.42,0,0,0,6.77.18l12.28-5.84A72.93,72.93,0,0,1,142.56,41l-5.84,12.29a7.42,7.42,0,0,0,.19,6.77,56.81,56.81,0,0,1,4.5,11A7.48,7.48,0,0,0,146.07,76L159,80.54a60.5,60.5,0,0,1,0,13.18ZM87.12,50.8a34.57,34.57,0,1,0,34.57,34.57A34.61,34.61,0,0,0,87.12,50.8Zm0,54.21a19.64,19.64,0,1,1,19.64-19.64A19.66,19.66,0,0,1,87.12,105Z" style="stroke:#fff;stroke-miterlimit:10"/></svg>
                                <p class="no-margin">{{__('Settings')}}</p>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="suboption-style-1 pointer">
                                @csrf
                                <button type="submit" class="flex align-center bold pointer" style="background: unset; border: unset">
                                    <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M496,240H293.32a16,16,0,1,1,0-32H496a16,16,0,0,1,0,32Zm-80,80a16,16,0,0,1-11.31-27.33L473.37,224,404.68,155.3a16,16,0,0,1,22.63-22.64l80,80a16,16,0,0,1,0,22.63l-80,80A15.87,15.87,0,0,1,416,320ZM170.66,512a44,44,0,0,1-13.22-2L29.05,467.24A43.06,43.06,0,0,1,0,426.67v-384A42.71,42.71,0,0,1,42.67,0,44.07,44.07,0,0,1,55.89,2L184.27,44.77a43.06,43.06,0,0,1,29.06,40.58v384A42.72,42.72,0,0,1,170.66,512ZM42.67,32A10.71,10.71,0,0,0,32,42.68v384A11.08,11.08,0,0,0,39.4,437l127.78,42.58a11.53,11.53,0,0,0,3.48.47,10.7,10.7,0,0,0,10.67-10.67v-384a11.09,11.09,0,0,0-7.41-10.29L46.14,32.48A11.73,11.73,0,0,0,42.67,32ZM325.32,170.68a16,16,0,0,1-16-16v-96A26.7,26.7,0,0,0,282.66,32h-240a16,16,0,1,1,0-32h240a58.71,58.71,0,0,1,58.66,58.66v96A16,16,0,0,1,325.32,170.68ZM282.66,448H197.33a16,16,0,0,1,0-32h85.33a26.7,26.7,0,0,0,26.66-26.66v-96a16,16,0,0,1,32,0v96A58.71,58.71,0,0,1,282.66,448Z"/></svg>
                                    <p class="no-margin">{{__('Logout')}}</p>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            @guest
            <div id="login" class="flex align-center ml8">
                <a href="" class="flex align-center login-signin-button fs13 light-gray no-underline">
                    <svg class="size20 mr4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="#FFF" d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
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
                    <a href="" class="suboption-style-1 @if($local == 'ma-ar') block-click @else set-lang @endif" style="@if($local == 'ma-ar') background-color: #e6e6e6; cursor: pointer @endif">
                        <div class="small-image-2 sprite sprite-2-size ma-arabic17-flag mr8"></div>
                        <p class="no-margin">{{ __('Arabic-Morocco') }}</p>
                        <div class="loading-dots-anim ml4 none">•</div>
                        <input type="hidden" class="lang-value" value="ma-ar">
                    </a>
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
                </div>
            </div>
        </div>
    </div>
    <div id="loading-strip" class="none">
        <div class="loading-strip-line"></div>
    </div>
</header>