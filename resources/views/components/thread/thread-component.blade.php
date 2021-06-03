<div style="margin: 14px 0">
    <!-- <div class="thread-container flex">
        <div class="thread-owner-section">
            <img src="{{ asset('avatar.jpg') }}" class="thread-owner-picture block" alt="{{ __('thread owner profile picture') }}">
            <p class="thread-owner-username text-center">{{ $thread_owner_username }}</p>
            <div class="thread-owner-badges">

            </div>
            <div class="thread-owner-infos-container">
                <p class="thread-owner-info"><span class="bold fs13">{{__('Reputation')}}</span>: {{ $thread_owner_reputation }}</p>
                <p class="thread-owner-info"><span class="bold fs13">{{__('Posts')}}</span>: {{ $thread_owner_posts_number }}</p>
                <p class="thread-owner-info"><span class="bold fs13">{{__('Threads')}}</span>: {{ $thread_owner_threads_number }}</p>
                <p class="thread-owner-info"><span class="bold fs13">{{__('Joined')}}</span>: {{ $thread_owner_joined_at }}</p>
            </div>
        </div>
        <div class="full-width thread-content-container relative">
            <div class="flex">
                <div class="thread-vote-container">
                    <a href="" class="up-icon thread-vote-button thread-up-vote"></a>
                    <p class="bold fs17 no-margin text-center">0</p>
                    <a href="" class="down-icon thread-vote-button thread-down-vote"></a>
                </div>
                <div>
                    <p class="no-margin fs12 pd4">posted at >> {{ $thread_created_at }}</p>
                    <p class="no-margin fs12 pd4">viewed >> {{ $thread_view_counter }} times</p>
                </div>
            </div>

            <p class="thread-content">
                {{ $thread_content }}
            </p>
            <div class="thread-bottom-strip">
                <div class="thread-l-sep"></div>
                <div class="flex">
                    <a href="" class="link-path" class="block" style="margin: 4px">Direct Link</a>
                    <div class="move-to-right flex">
                        <a href="" class="button-with-icon reply-icon reply-to-thread">reply</a>
                        <a href="" class="button-with-only-icon report-icon"></a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="thread-container flex">
        <div class="vote-section thread-vs">
            <a href="" class="up-icon thread-vote-button thread-up-vote"></a>
            <p class="bold fs17 no-margin text-center">0</p>
            <a href="" class="down-icon thread-vote-button thread-down-vote"></a>
        </div>
        <div class="thread-section">
            <div class="thread-header">
                <div class="flex space-between">
                    <div>
                        <span class="no-margin fs12">Posted by</span>
                        <!-- thread owner username alog with container -->
                        <div class="relative inline-block">
                            <a href="" class="link-style bold fs12 button-with-container" style="margin: 0 1px">grotto_iv</a>
                            <div class="button-container button-container-style absolute">
                                <div class="flex">
                                    <img src="" class="user-container-image mr8" alt="">
                                    <div>
                                        <h2 class="no-margin fs17">Mouad Nassri [<a href="" class="user-container-username">HOSTNAME47</a>]</h2>
                                        <p class="no-margin fs12 gray">Member since: Wed, May 26, 2021 9:35 PM</p>
                                        <div class="flex align-center">
                                            <div class="user-container-connnection-status mr4"></div>
                                            <p class="fs11 no-margin">Active</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-container-line-separator"></div>
                                <div>
                                    <div class="flex space-between my4">
                                        <div class="half-width">
                                            <p class="fs17 bold no-margin">2.5K</p>
                                            <p class="fs13 no-margin">Reputation</p>
                                        </div>
                                        <div class="half-width">
                                            <p class="fs17 bold no-margin">102 <span class="fs12">(<a href="" class="link-path">See</a>)</span></p>
                                            <p class="fs13 no-margin">Questions</p>
                                        </div>
                                    </div>
                                    <div class="flex space-between my4">
                                        <div class="half-width">
                                            <p class="fs17 bold no-margin">20 <span class="fs12">(<a href="" class="link-path">See</a>)</span></p>
                                            <p class="fs13 no-margin">Discussions</p>
                                        </div>
                                        <div class="half-width">
                                            <p class="fs17 bold no-margin">10.2K</p>
                                            <p class="fs13 no-margin">Total Posts</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="no-margin fs12">{{ $thread_created_at }}</span>
                        <p class="no-margin fs12">viewes >> {{ $thread_view_counter }} times</p>
                    </div>
                    <div class="flex">
                        <a href="" class="black-link">
                            <div class="flex align-center" style="margin-right: 6px">
                                <img src="{{ asset('assets/images/icons/follow.png') }}" class="small-image mr4" alt="">
                                <p class="gray no-margin fs13">Follow</p>
                            </div>
                        </a>
                        <div class="relative">
                            <a href="" class="black-link button-with-suboptions">
                                <img src="{{ asset('assets/images/icons/dotted-menu.svg') }}" class="small-image" alt="">
                            </a>
                            <div class="absolute suboptions-container suboption-style-left">
                                <a href="{{ $thread_edit_url }}" class="button-style">Edit Thread</a>
                                <div>
                                    <a href="" class="button-style action-verification">Delete Thread</a>
                                    <input type="hidden" value="thread.destroy" class="verification-action-type">
                                </div>
                            </div>
                        </div>
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
                            <p class="gray no-margin fs13" class="block" style="margin: 4px; font-size: 12px">{{ $thread_replies_num }} Replies</p>
                        </div>
                        <div class="flex" style="margin-right: 6px">
                            <a href=""><img src="{{ asset('assets/images/icons/gray-like.png') }}" class="small-image mr4" alt=""></a>
                            <p class="gray no-margin fs13" style="margin: 4px; font-size: 12px">{{ $thread_replies_num }} Likes</p>
                        </div>
                        <div class="relative">
                            <a href="" class="link-without-underline-style button-with-suboptions copy-container-button" class="block" style="margin: 4px; font-size: 12px">Direct Link ▾</a>
                            <div class="absolute button-simple-container suboptions-container">
                                <div class="flex">
                                    <input type="text" value="{{ $thread_url }}" class="simple-input">
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