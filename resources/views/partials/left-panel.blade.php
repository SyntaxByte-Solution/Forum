<div id="left-panel">
    <div class="flex relative">
        <a href="" class="left-panel-item lp-wpadding @if($page == 'home') {{ 'lp-selected' }} @endif">Home</a>
        @if($page == 'home')
            <div class="selected-colored-slice"></div>
        @endif
    </div>
    <div>
        <p class="left-panel-label">PUBLIC</p>
        <div class="flex relative">
            <a href="" class="qst-icon left-panel-item background-partial lp-padding @if($page == 'questions') {{ 'lp-selected' }} @endif">Questions</a>
            @if($page == 'questions')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="flex relative">
            <a href="" class="background-partial popular-icon left-panel-item lp-padding @if($page == 'popular-posts') {{ 'lp-selected' }} @endif">Popular posts</a>
            @if($page == 'popular')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="flex relative">
            <a href="" class="background-partial left-panel-item users-icon lp-padding @if($page == 'users') {{ 'lp-selected' }} @endif">Users</a>
            @if($page == 'users')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
    </div>
    <div>
        <p class="left-panel-label">TOPICS</p>
        <div>
            <a href="" class="left-panel-item lp-wpadding @if($page == 'users') {{ 'lp-selected' }} @endif"><span class="line-bootstraper">●</span>Admins Notifications</a>
            @if($page == 'users')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div>
            <a href="" class="left-panel-item lp-wpadding @if($page == 'users') {{ 'lp-selected' }} @endif"><span class="line-bootstraper">●</span>Training</a>
            <div class="left-panel-sub-items">
                <div>
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Strength & Power</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div>
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Skills & Techniques</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div>
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Calisthenics & workout</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div>
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Bodybuilding & Diet</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
            </div>
            @if($page == 'users')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div>
            <a href="" class="left-panel-item lp-wpadding @if($page == 'users') {{ 'lp-selected' }} @endif"><span class="line-bootstraper">●</span>Nutrition</a>
            <div class="left-panel-sub-items">
                <div>
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Strength & Power</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div>
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Skills & Techniques</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
                <div>
                    <a href="" class="left-panel-item lp-sub-item @if($page == 'users') {{ 'lp-selected' }} @endif">Calisthenics & workout</a>
                    @if($page == 'users')
                        <div class="selected-colored-slice"></div>
                    @endif
                </div>
            </div>
            @if($page == 'users')
                <div class="selected-colored-slice"></div>
            @endif
        </div>
        <div class="flex">
            <a href="" class="block simple-link move-to-right" style="margin: 8px 8px 8px auto">See all</a>
        </div>

    </div>
</div>