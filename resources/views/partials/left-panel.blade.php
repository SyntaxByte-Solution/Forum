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
    @auth
    <div class="relative">
        <a href="" class="left-panel-item toggle-container-button simple-suboption-button lp-wpadding @if($page == 'myspace') {{ 'lp-selected' }} @endif">My Space <span class="toggle-arrow">@if($page == 'myspace') ▾ @else ▸ @endif</span></a>
        <div class="toggle-container" @isset($subpage) style="display: block" @endisset>
            <div class="relative">
                <a href="{{ route('myspace.index') }}" @isset($subpage) @if($subpage == 'myspace.index') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'myspace') {{ 'lp-selected' }} @endif">Index</a>
                @isset($subpage)
                    @if($subpage == 'myspace.index')
                        <div class="selected-colored-slice"></div>
                    @endif
                @endisset
            </div>
            <div class="relative">
                <a href="{{ route('myspace.index') }}" @isset($subpage) @if($subpage == 'myspace.profile') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'myspace') {{ 'lp-selected' }} @endif">Profile</a>
                @isset($subpage)
                    @if($subpage == 'myspace.profile')
                        <div class="selected-colored-slice"></div>
                    @endif
                @endisset
            </div>
            <div class="relative">
                <a href="{{ route('myspace.index') }}" @isset($subpage) @if($subpage == 'myspace.activities') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'myspace') {{ 'lp-selected' }} @endif">Activities</a>
                @isset($subpage)
                    @if($subpage == 'myspace.activities')
                        <div class="selected-colored-slice"></div>
                    @endif
                @endisset
            </div>
            <div class="relative">
                <a href="{{ route('myspace.index') }}" @isset($subpage) @if($subpage == 'myspace.settings') style="color: #53baff" @endif @endisset class="left-panel-item lp-sub-item @if($page == 'myspace') {{ 'lp-selected' }} @endif">Settings</a>
                @isset($subpage)
                    @if($subpage == 'myspace.settings')
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
                <a href="" class="background-partial left-panel-item users-icon lp-padding @if($page == 'users') {{ 'lp-selected' }} @endif">Users</a>
            </div>
            @if($page == 'users')
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
        <div>
            <a href="" class="left-panel-item lp-wpadding @if($page == 'users') {{ 'lp-selected' }} @endif"><span class="line-bootstraper">●</span>Forums</a>
            <div class="left-panel-sub-items">
                <div class="relative">
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Gneral Forum</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div class="relative">
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Body Building</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div class="relative">
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Calisthenics</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div class="relative">
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Tennis</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div class="relative">
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Football</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
            </div>
            <div class="flex">
                <a href="" class="block simple-link move-to-right" style="margin: 8px 8px 8px auto">See all</a>
            </div>
        </div>
    </div>
</div>