<div class="resource-container thread-container-box">
    <input type="hidden" class="votable-id" value="{{ $thread->id }}">
    <input type="hidden" class="votable-type" value="thread">
    <div class="hidden-thread-section none px8 py8">
        <p class="my4 fs12">Thread hidden. If you want to show it again <span class="pointer blue thread-display-button">click here</span></p>
    </div>
    <div class="flex thread-component">
        <div class="thread-vote-section">
            <div class="informer-message-container absolute left100 zi1">
                <div class="left-middle-triangle"></div>
                <div class="flex align-center">
                    <p class="informer-message">{{__("you can't up vote your thread")}}</p>
                    <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                </div>
            </div>
            <div class="pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/up-filled.png') }}" class="small-image vote-up-filled-image @upvoted($thread, 'App\Models\Thread') @else none @endupvoted" alt="">
                <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image vote-up-image @upvoted($thread, 'App\Models\Thread') none @endupvoted" alt="">
            </div>
            <p class="bold fs15 no-margin text-center votable-count">{{ $thread->votevalue }}</p>
            <div class="pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/down-filled.png') }}" class="small-image vote-down-filled-image @downvoted($thread, 'App\Models\Thread') @else none @enddownvoted" alt="">
                <img src="{{ asset('assets/images/icons/down-arrow.png') }}" class="small-image vote-down-image @downvoted($thread, 'App\Models\Thread') none @enddownvoted" alt="">
            </div>
            @if($thread->tickedPost())
            <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="small-image mt8" title="{{ __('This thread has a ticked reply') }}" alt="">
            @endif
        </div>
        <div class="thread-main-section">
            <div class="thread-header-section space-between">
                <div class="flex">
                    <div class="flex">
                        <img src="{{ $thread->user->avatar }}" class="flex size28 rounded mr4" alt="">
                        <div>
                            <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}" class="blue no-underline bold fs13">{{ $thread->user->firstname }} {{ $thread->user->lastname }} - {{ $thread->user->username }}</a>
                            <div class="flex align-center">
                                <div class="relative height-max-content">
                                    <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ $at_hummans }}</p>
                                    <div class="tooltip tooltip-style-1">
                                        {{ $at }}
                                    </div>
                                </div>
                                <div class="gray height-max-content mx4 fs10">•</div>
                                <div class="size12 sprite sprite-2-size public12-icon" title="public"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex align-center">
                    <div class="thread-views mr8">
                        <div class="small-image-2 sprite sprite-2-size eye17-icon mr8"></div>
                        <p class="no-margin fs12 unselectable">{{ $views }}</p>
                    </div>
                    <div class="relative">
                        <div class="pointer button-with-suboptions size20 sprite sprite-2-size menu20-icon mr4"></div>
                        <div class="suboptions-container suboptions-container-right-style">
                            @can('update', $thread)
                            <div class="pointer simple-suboption flex align-center">
                                <div class="small-image-2 sprite sprite-2-size pen17-icon mr4"></div>
                                <a href="{{ $edit_link }}" target="_blank" class="no-underline black">{{ __('Edit thread') }}</a>
                            </div>
                            <div class="pointer simple-suboption flex align-center">
                                <div class="small-image-2 sprite sprite-2-size delete17b-icon mr4"></div>
                                <a href="{{ $thread->link }}?action=thread-delete" target="_blank" class="no-underline black">{{ __('Delete thread') }}</a>
                            </div>
                            @endcan
                            <div class="pointer simple-suboption thread-display-button flex align-center">
                                <div class="small-image-2 sprite sprite-2-size eyecrossed17-icon mr4"></div>
                                <div>{{ __('Hide thread') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="thread-content-section">
                <div class="flex align-center">
                    <img src="{{ asset('assets/images/icons/' . $forum->icon) }}" class="small-image-size mr4" alt="">
                    <div class="flex align-center">
                        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                        <span class="mx4 fs13 gray">▸</span>
                        <a href="{{ $category_threads_link }}" class="fs11 black-link">{{ $category->category }}</a>
                    </div>
                </div>
                <div class="my8 expand-box">
                    <span><a href="{{ $thread->link }}" class="expandable-text bold fs18 blue no-underline">{{ $thread->slice }}</a></span>
                    @if($thread->slice != $thread->subject)
                    <input type="hidden" class="expand-slice-text" value="{{ $thread->slice }}">
                    <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
                    <input type="hidden" class="expand-text-state" value="0">
                    <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
                    <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                    @endif
                </div>
                <div class="my4">
                    <span class="expandable-text fs15 no-underline">{{ $thread->contentslice }}</span>
                    @if($thread->content != $thread->contentslice)
                    <input type="hidden" class="expand-slice-text" value="{{ $thread->contentslice }}">
                    <input type="hidden" class="expand-whole-text" value="{{ $thread->content }}">
                    <input type="hidden" class="expand-text-state" value="0">
                    <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
                    <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                    @endif
                </div>
            </div>
            <div class="thread-bottom-section space-between">
                <div class="flex align-center">
                    <div class="flex align-center mr8">
                        <div class="small-image-2 sprite sprite-2-size resource17-like-ricon mr4"></div>
                        <p class="fs12 no-margin">{{ $likes }} @if($likes>1) {{ __("likes") }} @endif</p>
                    </div>
                    <div class="flex align-center">
                        <div class="small-image-2 sprite sprite-2-size reply17-icon mr4"></div>
                        <p class="no-margin fs12">{{ $replies }} {{__('replies')}}</p>
                    </div>
                </div>
                <div class="flex align-center">
                    <div class="relative mr8">
                        <a href="" class="link-without-underline-style button-with-suboptions copy-container-button" class="block" style="margin: 4px; font-size: 12px">Link ▾</a>
                        <div class="absolute button-simple-container suboptions-container" style="z-index: 1; right: 0">
                            <div class="flex">
                                <input type="text" value="{{ $thread->link }}" class="simple-input" style="width: 240px; padding: 3px; ">
                                <a href="" class="input-button-style flex align-center copy-button">
                                    <div>copy</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex align-center">
                        <div class="thread-report pointer small-image-2 sprite sprite-2-size report17-icon mr8"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        
    </div>
</div>