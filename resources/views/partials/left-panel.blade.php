<div id="left-panel">
    <div class="flex align-center" style="margin-bottom: 20px">
        <a href="" class="quick-links-button">Quick links ❯</a>
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
    @auth
        @php
            $same_user = false;
            if(request()->user) {
                $same_user = (auth()->user()->username == request()->user->username) ? true : false;

            } else {
                if(isset($subpage)) {
                    if($subpage == 'user.settings') {
                        $same_user = true;
                    }
                }
            }

        @endphp
    <div class="relative">
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
    @endauth
    <div>
        <p class="left-panel-label">PUBLIC</p>
        <div class="flex relative">
            <div class="flex align-center full-width relative">
                <div class="sprite-icon wdiscussion-icon mx8 absolute left0"></div>
                <a href="{{ route('category.discussions', ['forum'=>'general', 'category'=>'general-infos']) }}" class="left-panel-item lp-padding @if($page == 'discussions') {{ 'lp-selected' }} @endif">Discussions</a>
            </div>
            @if($page == 'discussions')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="flex relative">
            <div class="flex align-center full-width relative">
                <div class="sprite-icon question-icon mx8 absolute left0"></div>
                <a href="{{ route('category.questions', ['forum'=>'general', 'category'=>'general-infos']) }}" class="left-panel-item lp-padding @if($page == 'questions') {{ 'lp-selected' }} @endif">Questions</a>
            </div>
            @if($page == 'questions')
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
            <a href="" class="left-panel-item lp-wpadding @if($page == 'misc') {{ 'lp-selected' }} @endif"><span class="line-bootstraper">●</span>{{ __('Miscellaneous') }}</a>
            @if($page == 'misc')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
    </div>
</div>