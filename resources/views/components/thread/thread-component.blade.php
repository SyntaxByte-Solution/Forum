<div style="margin: 14px 0" class="resource-container relative">

    <input type="hidden" class="votable-id" value="{{ $thread->id }}">
    <input type="hidden" class="votable-type" value="thread">

    <div class="absolute full-shadowed br6 turn-off-viewer" style="z-index: 1">
        <div class="full-center full-width full-height">
            <div>
                @php
                    $posts_switch = ($thread->status->id == 3) ? 'on' : 'off';
                @endphp
                
                @if($thread->status->id != 3)
                <p class="white bold fs15 my4">{{ __('Important: If you turn off replies, no one could reply to your tread') }}.</p>
                <p class="white fs15 mt4 mb8">{{ __('However if there are already some replies, they will not disappeared.') }}</p>
                @else
                <p class="white bold fs15 my8">{{ __('Turn on replies on this thread') }}.</p>
                @endif
                <div class="full-center">
                    <input type="button" class="simple-white-button pointer turn-off-posts fs13" value="Turn {{ $posts_switch }} replies">
                    <a href="" class="simple-link close-shadowed-view-button fs14" style="text-decoration: none; margin-left: 6px;">cancel</a>
                    <input type="hidden" class="id" value="{{ $thread->id }}">
                    <input type="hidden" class="switch" value="{{ $posts_switch }}">
                </div>
            </div>
        </div>
    </div>

    <div class="thread-container flex">
        <div class="my8 px8 py8 flex flex-column align-center relative">
            <div class="vote-message-container absolute left100 zi1">
                <div class="left-middle-triangle"></div>
                <div class="flex align-center">
                    <p class="vote-message">you can't up vote your thread</p>
                    <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-vote-message-container rounded pointer" alt="">
                </div>
            </div>
            <a href="" class="@auth votable-up-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/up-filled.png') }}" class="small-image vote-up-filled-image @upvoted($thread, 'App\Models\Thread') @else none @endupvoted" alt="">
                <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image vote-up-image @upvoted($thread, 'App\Models\Thread') none @endupvoted" alt="">
            </a>
            <p class="bold fs16 no-margin text-center votable-count">{{ $thread_votes }}</p>
            <a href="" class="@auth votable-down-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/down-filled.png') }}" class="small-image vote-down-filled-image @downvoted($thread, 'App\Models\Thread') @else none @enddownvoted" alt="">
                <img src="{{ asset('assets/images/icons/down-arrow.png') }}" class="small-image vote-down-image @downvoted($thread, 'App\Models\Thread') none @enddownvoted" alt="">
            </a>
        </div>
        <div class="thread-section">
            <div class="thread-header">
                <div class="flex space-between">
                    <div>
                        <div class="flex">
                            <div class="flex align-center">
                                <img src="{{ asset('assets/images/icons/' . request()->forum->icon) }}" class="small-image-size mr4" alt="">
                                <div class="flex align-center">
                                    <a href="{{ route('forum.all.threads', ['forum'=>request()->forum->slug]) }}" class="fs11 black-link">{{ request()->forum->forum }}</a>
                                    <span class="mx4 fs13 gray">▸</span>
                                    <a href="{{ route('category.threads', ['forum'=>request()->forum->slug, 'category'=>request()->category->slug]) }}" class="fs11 black-link">{{ request()->category->category }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex align-center">
                            <span class="no-margin fs12 mr4">Posted by:</span>
                            <!-- thread owner username alog with container -->
                            <div class="relative inline-block">
                                <a href="{{ route('user.profile', ['user'=>$thread_owner_username]) }}" class="link-style bold fs12 button-with-container" style="margin: 0 1px">{{ $thread_owner_username }}</a>
                                @include('partials.user-profile-card', ['user'=>$thread_owner])
                            </div>
                            <div class="relative ml4">
                                <span class="no-margin fs12 tooltip-section">{{ $thread_created_at_hummans }}</span>
                                <div class="tooltip tooltip-style-1">
                                    {{ $thread_created_at }}
                                </div>
                            </div>
                        </div>
                        <!-- <p class="no-margin fs12">viewes: {{ $thread_view_counter }} times</p> -->
                    </div>
                    <div class="flex">
                        <a href="" class="black-link">
                            <div class="flex align-center" style="margin-right: 6px">
                                <img src="{{ asset('assets/images/icons/follow.png') }}" class="small-image mr4" alt="">
                                <p class="gray no-margin fs13">Follow</p>
                            </div>
                        </a>
                        @can('update', $thread)
                        <div class="relative">
                            <a href="" class="black-link button-with-suboptions">
                                <img src="{{ asset('assets/images/icons/dotted-menu.svg') }}" class="small-image" alt="">
                            </a>
                            <div class="absolute suboptions-container suboption-style-left">
                                <a href="{{ $thread_edit_url }}" class="button-style">Edit Thread</a>
                                <div>
                                    <a href="" class="button-style action-verification">Turn {{ $posts_switch }} replies</a>
                                    <input type="hidden" value="turn.off.posts" class="verification-action-type">
                                </div>
                                <div class="simple-line-separator my4" style="background-color: #474c5e"></div>
                                <div>
                                    <a href="" class="button-style action-verification">Delete Thread</a>
                                    <input type="hidden" value="thread.destroy" class="verification-action-type">
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
                <p class="thread-title">{{ $thread_subject }}</p>    
            </div>
            <p class="thread-content">
                {{ $thread_content }}
            </p>
            <div class="thread-bottom-strip">
                <div class="thread-bottom-strip-line-separator"></div>
                <div class="flex">
                    <div class="flex">
                        <div class="flex" style="margin-right: 6px">
                            <img src="{{ asset('assets/images/icons/gray-reply.png') }}" class="small-image mr4" alt="">
                            <p class="gray no-margin fs13" class="block" style="margin: 4px; font-size: 12px"><span class="thread-replies-number">{{ $thread_replies_num }}</span> Replies</p>
                        </div>
                        <div class="flex" style="margin-right: 6px">
                            <a href=""><img src="{{ asset('assets/images/icons/love-gray.png') }}" class="small-image mr4" alt=""></a>
                            <p class="gray no-margin fs13" style="margin: 4px; font-size: 12px">{{ $thread_replies_num }}</p>
                        </div>
                        <div class="relative">
                            <a href="" class="link-without-underline-style button-with-suboptions copy-container-button" class="block" style="margin: 4px; font-size: 12px">Direct Link ▾</a>
                            <div class="absolute button-simple-container suboptions-container" style="z-index: 1">
                                <div class="flex">
                                    <input type="text" value="{{ $thread_url }}" class="simple-input" style="width: 240px">
                                    <a href="" class="input-button-style flex align-center copy-button">
                                        <div>copy</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="move-to-right flex">
                        <a href="" class="reply-to-thread black-link">
                            <div class="flex align-center" style="margin-right: 6px">
                                <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image mr4" alt="">
                                <p class="no-margin fs14">Reply</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>