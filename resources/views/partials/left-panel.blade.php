<div id="left-panel" class="flex flex-column">
    <div>
        <div class="flex align-center" style="margin-bottom: 20px">
            <a href="" class="quick-links-button">{{__('Quick links')}} ▸</a>
        </div>

        <div class="flex relative">
            <a href="/" class="left-panel-item lp-wpadding @if($page == 'home') {{ 'lp-selected' }} @endif">{{ __('Home') }}</a>
            @if($page == 'home')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="relative toggle-box pb8">
            <a href="" class="left-panel-item toggle-container-button simple-suboption-button lp-wpadding @if($page == 'search') {{ 'lp-selected' }} @endif">{{__('Search')}} <span class="toggle-arrow mx4">@if($page == 'search') ▾ @else ▸ @endif</span></a>
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
            <a href="" class="left-panel-item toggle-container-button simple-suboption-button lp-wpadding @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">
                <img src="{{ auth()->user()->avatar }}" class="rounded size24 mr8" alt="" loading="lazy">
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
                <a href="{{ $add_thread_link }}" class="left-panel-item lp-padding @if($page == 'add-thread') {{ 'lp-selected' }} @endif">
                    <div class="small-image sprite sprite-2-size plus17-icon mr4"></div>
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
                    <a href="/forums" class="left-panel-item lp-padding @if($page == 'forums') {{ 'lp-selected' }} @endif">
                        <div class="small-image sprite sprite-2-size forums20-icon mr4"></div>
                        {{__('Forums')}}
                    </a>
                </div>
                @if($page == 'forums')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="" class="left-panel-item lp-padding @if($page == 'popular-posts') {{ 'lp-selected' }} @endif">
                        <div class="small-image sprite sprite-2-size fire17-icon mr4"></div>
                        {{__('Popular threads')}}
                    </a>
                </div>
                @if($page == 'popular')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <div class="flex align-center full-width relative">
                    <a href="" class="left-panel-item lp-padding @if($page == 'market') {{ 'lp-selected' }} @endif">
                        <div class="small-image sprite sprite-2-size market17-icon mr4"></div>
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
                <a href="/" class="left-panel-item lp-wpadding @if($page == 'aboutus') {{ 'lp-selected' }} @endif">{{__('About Us')}}</a>
                @if($page == 'aboutus')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
            <div class="flex relative">
                <a href="/" class="left-panel-item lp-wpadding @if($page == 'faqs') {{ 'lp-selected' }} @endif">{{__('FAQs')}}</a>
                @if($page == 'faqs')
                    <div class="selected-colored-slice"></div>
                @endif
            </div>
        </div>
    </div>
    <div class="move-to-bottom" style="margin-bottom: 12px">
        <div class="flex align-center fs13">
            <p>Designed with 
            <div style="height: 19px; width: 19px" class="full-center mx4">
                <img src="{{ asset('assets/images/icons/plove.png') }}" class="heart-beating" style="width: 16px;" loading="lazy"> 
            </div>
            by <a href="https://www.mouad-dev.com" target="_blank" class="no-underline mx4 bold" style="color: rgb(58, 186, 236)">mouad</a></p>
        </div>
    </div>
</div>