<div id="left-panel" class="flex flex-column">
    <div>
        <div class="flex align-center" style="margin-bottom: 20px">
            <a href="" class="quick-links-button">{{__('Quick links')}} ▸</a>
        </div>

        <div class="flex relative">
            <a href="/" class="left-panel-item lp-wpadding @if($page == 'home') {{ 'lp-selected bold white white' }} @endif">{{ __('Home') }}</a>
            @if($page == 'home')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="relative toggle-box pb8">
            <a href="" class="left-panel-item toggle-container-button simple-suboption-button lp-wpadding @if($page == 'search') {{ 'lp-selected bold white white' }} @endif">
                <svg class="size17 mr4" fill="#FFFFFF" enable-background="new 0 0 515.558 515.558" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                {{__('Search')}} <span class="toggle-arrow mx4">@if($page == 'search') ▾ @else ▸ @endif</span>
            </a>
            <div class="toggle-container" @isset($subpage) @if($page == 'search') style="display: block" @endif @endisset>
                <div class="relative">
                    <a href="{{ route('search') }}" @isset($subpage) @if($subpage == 'search') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'search') {{ 'lp-selected' }} @endif">{{__('Search Index')}}</a>
                    @isset($subpage)
                        @if($subpage == 'search')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('threads.search') }}" @isset($subpage) @if($subpage == 'threads-search') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'search') {{ 'lp-selected' }} @endif">{{__('Threads Search')}}</a>
                    @isset($subpage)
                        @if($subpage == 'threads-search')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('users.search') }}" @isset($subpage) @if($subpage == 'users-search') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'search') {{ 'lp-selected' }} @endif">{{__('Users Search')}}</a>
                    @isset($subpage)
                        @if($subpage == 'users-search')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="simple-line-separator" style="background-color: #626266;"></div>
                <div class="relative">
                    <a href="{{ route('advanced.search') }}" @isset($subpage) @if($subpage == 'advanced-search') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'search') {{ 'lp-selected' }} @endif">{{__('Advanced Search')}}</a>
                    @isset($subpage)
                        @if($subpage == 'advanced-search')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        @php
            $same_user = false;
            if(auth()->user()) {
                if(request()->user) {
                    $same_user = (auth()->user()->username == request()->user->username) ? true : false;

                } else {
                    if(isset($subpage)) {
                        if($subpage == 'user.settings') {
                            $same_user = true;
                        }
                    }
                }
            }
        @endphp
        @auth
        <div class="relative toggle-box pb8">
            <a href="" class="left-panel-item toggle-container-button simple-suboption-button lp-wpadding @if($page == 'user' && $same_user) {{ 'lp-selected bold white white' }} @endif">
                <div class="relative has-fade size24 mr8 rounded hidden-overflow full-center">
                    <div class="fade-loading"></div>
                    <img src="{{ auth()->user()->avatar }}" class="size24 handle-image-center-positioning" alt="" loading="lazy">
                </div>
                {{__('My Space')}} 
                <span class="toggle-arrow mx4">@if($page == 'user' && $same_user) ▾ @else ▸ @endif</span>
            </a>
            <div class="toggle-container" @isset($subpage) @if($same_user) style="display: block" @endif @endisset>
                <div class="relative">
                    <a href="{{ route('user.activities', ['user'=>auth()->user()->username]) }}" @isset($subpage) @if($subpage == 'user.activities' && $same_user) style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">{{__('Activities')}}</a>
                    @isset($subpage)
                        @if($subpage == 'user.activities' && $same_user)
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('user.profile', ['user'=>auth()->user()->username]) }}" @isset($subpage) @if($subpage == 'user.profile' && $same_user) style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">{{__('Profile')}}</a>
                    @isset($subpage)
                        @if($subpage == 'user.profile' && $same_user)
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
                <div class="relative">
                    <a href="{{ route('user.settings') }}" @isset($subpage) @if($subpage == 'user.settings') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">{{__('Settings')}}</a>
                    @isset($subpage)
                        @if($subpage == 'user.settings')
                            <div class="selected-colored-slice"></div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
        <div class="flex relative">
            <div class="flex align-center full-width">
                @php
                    $add_thread_link = route('thread.add');
                @endphp
                <a href="{{ $add_thread_link }}" class="left-panel-item lp-padding @if($page == 'add-thread') {{ 'lp-selected bold white white' }} @endif">
                    <svg class="small-image mr4" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 397.15 397.15"><path d="M390.88,12.37c-4.14-4.15-10.13-6.25-17.78-6.25-26.78,0-70.16,26-93.64,41.55l-1.91,1.27-5.28,41.68-14-28.34-4.81,3.52a763.05,763.05,0,0,0-85.75,73.26c-4.62,4.62-9.16,9.31-13.5,13.94l-.93,1-18.7,82.35-9.86-49.17L118,196.36c-3.84,5.26-7.46,10.53-10.78,15.65l-.62,1-8,62.92L86.17,250.56,82.63,263.1c-4.3,15.28-4.5,28.32-.67,38.5l-80,80a5.52,5.52,0,0,0-1.55,6.22A5.21,5.21,0,0,0,5.24,391a6.85,6.85,0,0,0,2.46-.49l36.94-14a15.23,15.23,0,0,0,5.11-3.41l49.61-52.77A44.27,44.27,0,0,0,118,324h0a82.94,82.94,0,0,0,22.18-3.4l12.54-3.54-25.33-12.49,62.92-8,.95-.62c5.12-3.31,10.39-6.94,15.66-10.79l9.19-6.7-49.17-9.86,82.34-18.71,1-.92c4.64-4.35,9.33-8.89,13.94-13.5,35.17-35.17,70.11-78.39,95.85-118.59l3-4.7L338.24,100,373,95.59l1.23-2.2C397.46,51.81,403.07,24.56,390.88,12.37Z"/></svg>
                    {{__('Start discussion')}}
                </a>
            </div>
            @if($page == 'add-thread')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        @endauth
        <div>
            <p class="left-panel-label">{{__('PUBLIC')}}</p>
            <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="/forums" class="left-panel-item lp-padding @if($page == 'forums') {{ 'lp-selected bold white' }} @endif">
                        <svg class="small-image mr4" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/></svg>
                        {{__('Forums')}}
                    </a>
                </div>
                @if($page == 'forums')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="" class="left-panel-item lp-padding @if($page == 'popular-posts') {{ 'lp-selected bold white' }} @endif">
                        <svg class="small-image mr4" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M446.91,299.77c-5.87-76.36-41.42-124.21-72.78-166.44C345.08,94.24,320,60.48,320,10.69a10.68,10.68,0,0,0-5.79-9.49A10.53,10.53,0,0,0,303.13,2C256,35.71,216.72,92.52,203,146.73c-9.53,37.73-10.79,80.16-11,108.18-43.5-9.29-53.35-74.36-53.46-75.07a10.73,10.73,0,0,0-5.55-7.92,10.61,10.61,0,0,0-9.67-.17c-2.28,1.1-56,28.39-59.11,137.35C64,312.73,64,316.36,64,320c0,105.85,86.14,192,192,192a1.24,1.24,0,0,0,.43,0h.13C362.17,511.68,448,425.67,448,320,448,314.67,446.91,299.77,446.91,299.77ZM256,490.65c-35.29,0-64-30.58-64-68.17,0-1.28,0-2.57.08-4.16.43-15.85,3.44-26.67,6.74-33.87C205,397.74,216.07,410,234,410a10.66,10.66,0,0,0,10.67-10.67c0-15.18.31-32.7,4.09-48.51,3.37-14,11.41-28.94,21.6-40.9,4.53,15.52,13.36,28.08,22,40.34,12.34,17.54,25.1,35.68,27.34,66.6.14,1.84.27,3.68.27,5.66C320,460.07,291.29,490.65,256,490.65Z"/></svg>
                        {{__('Popular threads')}}
                    </a>
                </div>
                @if($page == 'popular')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="" class="left-panel-item lp-padding @if($page == 'market') {{ 'lp-selected bold white' }} @endif">
                        <svg class="small-image mr4" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 456.03 456.03"><path d="M345.6,338.86a53.25,53.25,0,1,0,53.25,53.25C398.34,362.93,374.78,338.86,345.6,338.86ZM439.3,84.91c-1,0-2.56-.51-4.1-.51H112.64l-5.12-34.31A45.85,45.85,0,0,0,62,10.67H20.48a20.48,20.48,0,0,0,0,41H62a5.44,5.44,0,0,1,5.12,4.61L98.82,272.3a56.12,56.12,0,0,0,55.29,47.62h213c26.63,0,49.67-18.95,55.3-45.06l33.28-166.4A20.24,20.24,0,0,0,439.3,84.91ZM215,389.55c-1-28.16-24.58-50.69-52.74-50.69a53.56,53.56,0,0,0-51.2,55.3,52.49,52.49,0,0,0,52.23,50.69h1C193.54,443.31,216.58,418.73,215,389.55Z"/></svg>
                        {{ __('Market place') }}
                    </a>
                </div>
                @if($page == 'market')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
        </div>
        <div>
            <p class="left-panel-label">{{__('MORE')}}</p>
            <div class="flex relative">
                <a href="/" class="left-panel-item lp-wpadding @if($page == 'aboutus') {{ 'lp-selected bold white' }} @endif">{{__('About Us')}}</a>
                @if($page == 'aboutus')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <a href="/" class="left-panel-item lp-wpadding @if($page == 'faqs') {{ 'lp-selected bold white' }} @endif">{{__('FAQs')}}</a>
                @if($page == 'faqs')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
        </div>
    </div>
    <div class="move-to-bottom" style="margin-bottom: 12px">
        <div class="flex align-center fs13">
            <p>Designed with 
            <div style="max-height: 19px; height: 19px; max-width: 19px; width: 19px" class="full-center mx4">
                <svg class="heart-beating" fill="#FF0000" style="width: 16px; stroke: #331010; stroke-width: 5px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 94.5"><path d="M86.82,26.63v-7.3H78.64V12H62.27v7.29H54.09v7.3H45.91v-7.3H37.73V12H21.36v7.29H13.18v7.3H5V48.5h8.18v7.29h8.18v7.29h8.19v7.29h8.18v7.3h8.18V85h8.18V77.67h8.18v-7.3h8.18V63.08h8.19V55.79h8.18V48.5H95V26.63Z"/></svg>
            </div>
            by <a href="https://www.mouad-dev.com" target="_blank" class="no-underline mx4 bold" style="color: rgb(58, 186, 236)">mouad</a></p>
        </div>
    </div>
</div>