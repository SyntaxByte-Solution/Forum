<div id="left-panel">
    <div class="flex align-center" style="margin-bottom: 20px">
        <a href="" class="quick-links-button">Quick links ▸</a>
    </div>

    <div class="flex relative">
        <a href="/" class="left-panel-item lp-wpadding @if($page == 'home') {{ 'lp-selected' }} @endif">Home</a>
        @if($page == 'home')
            <div class="selected-colored-slice"></div>
        @endif
    </div>
    <div class="flex relative">
        <a href="/forums" class="left-panel-item lp-wpadding @if($page == 'forums') {{ 'lp-selected' }} @endif">Forums</a>
        @if($page == 'forums')
            <div class="selected-colored-slice"></div>
        @endif
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
    <div class="relative toggle-box">
        <a href="" class="left-panel-item toggle-container-button simple-suboption-button lp-wpadding @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">My Space <span class="toggle-arrow">@if($page == 'user' && $same_user) ▾ @else ▸ @endif</span></a>
        <div class="toggle-container" @isset($subpage) @if($same_user) style="display: block" @endif @endisset>
            <div class="relative">
                <a href="{{ route('user.activities', ['user'=>auth()->user()->username]) }}" @isset($subpage) @if($subpage == 'user.activities' && $same_user) style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">Activities</a>
                @isset($subpage)
                    @if($subpage == 'user.activities' && $same_user)
                        <div class="selected-colored-slice"></div>
                    @endif
                @endisset
            </div>
            <div class="relative">
                <a href="{{ route('user.profile', ['user'=>auth()->user()->username]) }}" @isset($subpage) @if($subpage == 'user.profile' && $same_user) style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user' && $same_user) {{ 'lp-selected' }} @endif">Profile</a>
                @isset($subpage)
                    @if($subpage == 'user.profile' && $same_user)
                        <div class="selected-colored-slice"></div>
                    @endif
                @endisset
            </div>
            <div class="relative">
                <a href="{{ route('user.settings') }}" @isset($subpage) @if($subpage == 'user.settings') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'user') {{ 'lp-selected' }} @endif">Settings</a>
                @isset($subpage)
                    @if($subpage == 'user.settings')
                        <div class="selected-colored-slice"></div>
                    @endif
                @endisset
            </div>
        </div>
    </div>
    <div class="flex relative">
        <div class="flex align-center full-width relative">
            <div class="sprite-icon wedit-icon mx8 absolute left0"></div>
            @php
                $add_thread_link;

                if($forum = request()->forum) {
                    if($category = request()->category) {
                        $add_thread_link = route('thread.add', ['forum'=>$forum->slug, 'category'=>$category->slug]);
                    } else {
                        $add_thread_link = route('thread.add', ['forum'=>$forum->slug, 'category'=>$forum->categories->first()->slug]);
                    }
                } else {
                    $add_thread_link = route('thread.add', ['forum'=>\App\Models\Forum::first()->slug, 'category'=>\App\Models\Forum::first()->categories->first()->slug]);
                }
            @endphp
            <a href="{{ $add_thread_link }}" class="left-panel-item lp-padding @if($page == 'add-thread') {{ 'lp-selected' }} @endif" style="padding-left: 35px">Add a thread</a>
        </div>
        @if($page == 'add-thread')
            <div class="selected-colored-slice"></div>
        @endif
    </div>
    @endauth
    <div>
        <p class="left-panel-label">PUBLIC</p>
        <div class="flex relative">
            <div class="flex align-center full-width relative">
                <div class="sprite-icon wdiscussion-icon mx8 absolute left0"></div>
                <a href="{{ route('category.threads', ['forum'=>'general', 'category'=>'general-infos']) }}" class="left-panel-item lp-padding @if($page == 'threads') {{ 'lp-selected' }} @endif">Threads</a>
            </div>
            @if($page == 'threads')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="flex relative">
            <div class="flex align-center full-width relative">
                <div class="popular-icon sprite-icon mx8 absolute left0"></div>
                <a href="" class="left-panel-item lp-padding @if($page == 'popular-posts') {{ 'lp-selected' }} @endif">Popular posts</a>
            </div>
            @if($page == 'popular')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="flex relative">
            <div class="flex align-center full-width relative">
                <div class="users-icon sprite-icon mx8 absolute left0"></div>
                <a href="" class="background-partial left-panel-item users-icon lp-padding @if($page == 'user' && !$same_user) {{ 'lp-selected' }} @endif">Users</a>
            </div>
            @if($page == 'user' && !$same_user)
                <div class="selected-colored-slice"></div>
            @endif
        </div>
    </div>
    <div>
        <p class="left-panel-label">MORE</p>
        <div class="relative">
            <a href="{{ route('search') }}" class="left-panel-item lp-wpadding @if($page == 'adv-search') {{ 'lp-selected' }} @endif">{{ __('Search') }}</a>
            @if($page == 'adv-search')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="relative">
            <a href="" class="left-panel-item lp-wpadding @if($page == 'adv-search') {{ 'lp-selected' }} @endif">{{ __('Adv. Search') }}</a>
            @if($page == 'adv-search')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
    </div>
</div>