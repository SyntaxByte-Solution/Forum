<tr class="resource-container">
    <input type="hidden" class="votable-id" value="{{ $thread_id }}">
    <input type="hidden" class="votable-type" value="thread">
    <td>
        <div class="flex">
            <div class="px8 flex flex-column align-center relative">
                <div class="informer-message-container absolute left100 zi1">
                    <div class="left-middle-triangle"></div>
                    <div class="flex align-center">
                        <p class="informer-message">you can't up vote your thread</p>
                        <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
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
                @if($thread->tickedPost())
                <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="small-image mt8" title="{{ __('This thread has a ticked reply') }}" alt="">
                @endif
            </div>
            <div class="flex full-width">
                <div class="full-width">
                    <div class="index-content-section flex">
                        <div>
                            <div class="flex align-center gray">
                                <div class="flex align-center">
                                    <p class="no-margin fs11 flex align-center">posted by</p>
                                    <a href="{{ route('user.profile', ['user'=>$thread_owner]) }}" class="black no-underline bold fs12 mx4">{{ $thread_owner }}</a>
                                    <div class="relative">
                                        <p class="no-margin fs11 flex align-center tooltip-section">: {{ $at_hummans }}</p>
                                        <div class="tooltip tooltip-style-1">
                                            {{ $at }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex align-center my8">
                                <p class="fs16 bold no-margin"><a href="{{ $thread_url }}" class="forum-style-link dark-blue">{{ $thread_title }}</a></p>
                            </div>
                            <div class="fs16 my8">
                                <a href="{{ $thread_url }}" class="black no-underline">{{ $thread_content }}</a>
                            </div>
                        </div>
                        <div class="flex flex-column move-to-right">
                            @can('update', $thread)
                            <div style="margin: 0 4px" class="move-to-right">
                                <div>
                                    <a href="{{ $edit_link }}" target="_blank" class="table-row-button black-sprite-icon sprite-size bedit-icon"></a>
                                </div>
                                <div>
                                    <a href="{{ $thread_url }}?action=thread-delete" target="_blank" class="table-row-button black-sprite-icon sprite-size bdelete-icon"></a>
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div class="simple-line-separator my4"></div>
                    <div class="flex">
                        <div class="flex align-center move-to-right">
                            <img src="{{ asset('assets/images/icons/' . $forum->icon) }}" class="small-image-size mr4" alt="">
                            <div class="flex align-center">
                                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                                <span class="mx4 fs13 gray">▸</span>
                                <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="fs11 black-link">{{ $category->category }}</a>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </td>
    <td class="fs13" style="width: 106px">
        <div class="flex align-center mb4">
            <img src="{{ asset('assets/images/icons/gray-eye.png') }}" class="small-image-2 mr4" alt="">
            <p class="no-margin fs12">{{ $views }} views</p>
        </div>
        <div class="flex align-center">
            <img src="{{ asset('assets/images/icons/gray-reply.png') }}" class="small-image-2 mr4" alt="">
            <p class="no-margin fs12">{{ $replies }} replies</p>
        </div>
    </td>
    <td style="width: 180px;" class="relative">
        @if($hasLastPost)
        <div>
            <a href="{{ $last_post_url }}" class="block forum-style-link fs11 bold">{{ $last_post_content }}</a>
            <div class="form-column-line-separator"></div>
            <p class="no-margin fs11">by <a href="{{ route('user.profile', ['user'=>$last_post_owner_username]) }}" class="bold forum-style-link fs11">{{ $last_post_owner_username }}</a></p>
            <p class="fs11 no-margin" style="margin-top: 3px">{{ $last_post_date }} </p>
        </div>
        @else
            <p class="no-margin fs11">{{ __('No posts yet') }}</p>
        @endif
        <div class="absolute mr8 bottom0 right0">
            <a href="{{ route('thread.show', ['forum'=>$forum->slug, 'category'=>$category->slug, 'thread'=>$thread->id]) }}" class="flex align-center gray link-style no-underline">
                <img src="{{ asset('assets/images/icons/gray-reply.png') }}" class="small-image-2" alt="">
                <p class="fs13 no-margin my4 mx4">Reply</p>
            </a>
        </div>
    </td>
</tr>