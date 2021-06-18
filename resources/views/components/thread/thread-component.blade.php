<div style="margin: 14px 0" class="resource-container">
    <input type="hidden" class="votable-id" value="{{ $thread->id }}">
    <input type="hidden" class="votable-type" value="thread">
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
                        <div class="flex align-center">
                            <span class="no-margin fs12 mr4">Posted by:</span>
                            <!-- thread owner username alog with container -->
                            <div class="relative inline-block">
                                <a href="{{ route('user.profile', ['user'=>$thread_owner_username]) }}" class="link-style bold fs12 button-with-container" style="margin: 0 1px">{{ $thread_owner_username }}</a>
                                <div class="button-container button-container-style absolute">
                                    <div class="flex">
                                        <img src="{{ $thread_owner->avatar }}" class="user-container-image mr8" alt="">
                                        <div>
                                            <h2 class="no-margin fs17">{{ $thread_owner->firstname }} {{ $thread_owner->lastname }} [<a href="{{ route('user.profile', ['user'=>$thread_owner_username]) }}" class="user-container-username">{{ $thread_owner_username }}</a>]</h2>
                                            <p class="no-margin fs12 gray ">Member since: {{ $thread_owner_joined_at }}</p>
                                            <div class="flex align-center">
                                                <img src="{{ asset('assets/images/icons/active.png') }}" class="tiny-image mr4" alt="">
                                                <p class="fs11 no-margin">Active</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user-container-line-separator"></div>
                                    <div>
                                        <div class="flex space-between my4">
                                            <div class="half-width">
                                                <p class="fs17 bold no-margin">{{ $thread_owner->reputation }}</p>
                                                <p class="fs13 no-margin">Reputation</p>
                                            </div>
                                            <div class="half-width">
                                                <p class="fs17 bold no-margin">{{ $thread_owner->threads_count() }} <span class="fs12">(<a href="{{ route('user.activities', ['user'=>$thread_owner->username]) }}" class="link-path">See</a>)</span></p>
                                                <p class="fs13 no-margin">Questions</p>
                                            </div>
                                        </div>
                                        <div class="flex space-between my4">
                                            <div class="half-width">
                                                <p class="fs17 bold no-margin">{{ $thread_owner->posts_count() }}</p>
                                                <p class="fs13 no-margin">Total Posts</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative ml4">
                                <span class="no-margin fs12 tooltip-section">{{ $thread_created_at_hummans }}</span>
                                <div class="tooltip tooltip-style-1">
                                    {{ $thread_created_at }}
                                </div>
                            </div>
                        </div>
                        <p class="no-margin fs12">viewes: {{ $thread_view_counter }} times</p>
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
                                    <a href="" class="button-style action-verification">Close Thread</a>
                                    <input type="hidden" value="thread.close" class="verification-action-type">
                                </div>
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