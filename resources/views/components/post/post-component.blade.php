<div class="relative resource-container">
    <input type="hidden" class="votable-type" value="post">
    <input type="hidden" class="votable-id" value="{{ $post->id }}">
    <div class="absolute full-shadowed br6" style="z-index: 1">
        <div class="full-center full-width full-height">
            <div class="flex align-center">
                <input type="button" class="simple-white-button pointer delete-post" value="Delete">
                <a href="" class="simple-link close-shadowed-view-button" style="text-decoration: none; margin-left: 6px; font-size: 10px">CANCEL</a>
                <input type="hidden" class="post-id" value="{{ $post_id }}">
            </div>
        </div>
    </div>
    <div class="show-post-container fs11">
        <div class="line-separator"></div>
        Reply hidden (<a href="" class="show-post black-link bold">click here to show it</a>)
        <div class="line-separator"></div>
    </div>
    <div class="flex post-container relative">
        <div id="{{ $post_id }}" class="absolute" style="top: -65px">
        </div>
        <div class="vote-section post-vs">
            <a href="" class="@auth votable-up-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/up-filled.png') }}" class="small-image vote-up-filled-image @upvoted($post, 'App\Models\Post') @else none @endupvoted" alt="">
                <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image vote-up-image @upvoted($post, 'App\Models\Post') none @endupvoted" alt="">
            </a>
            <p class="bold fs16 no-margin text-center votable-count">{{ $post_votes }}</p>
            <a href="" class="@auth votable-down-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/down-filled.png') }}" class="small-image vote-down-filled-image @downvoted($post, 'App\Models\Post') @else none @enddownvoted" alt="">
                <img src="{{ asset('assets/images/icons/down-arrow.png') }}" class="small-image vote-down-image @downvoted($post, 'App\Models\Post') none @enddownvoted" alt="">
            </a>
        </div>
        <div class="post-main-section">
            <div class="flex space-between">
                <div class="no-margin fs12 gray light-border-bottom">replied by 
                        <div class="inline-block relative">
                            <a href="" class="bold button-with-container forum-style-link fs12">{{ $post_owner_username }}</a>
                            @include('partials.user-profile-card')
                        </div>
                        <span class="relative">
                            <span class="tooltip-section">- {{ $post_date }}</span>
                            <span class="tooltip tooltip-style-1">{{ $post_created_at }}</span>
                        </span>
                        @if($post_updated_at)
                            <span class="relative" style="margin-left: 8px">
                                <span class="tooltip-section post-updated-date">(upated {{ $post_update_date }})</span>
                                <span class="tooltip tooltip-style-1 post-updated-date-human">{{ $post_updated_at }}</span>
                            </span>
                        @endif
                </div>


                <div class="relative">
                    <a href="" class="black-link button-with-suboptions">
                        <img src="{{ asset('assets/images/icons/dotted-menu.svg') }}" class="small-image" alt="">
                    </a>
                    <div class="absolute suboptions-container suboption-style-left" style="margin-top: 8px">
                        <a href="" class="button-style hide-post">Hide Post</a>
                        @can('update', $post)
                        <a href="" class="button-style edit-post">Edit Post</a>
                        @endcan
                        @can('destroy', $post)
                        <div class="simple-line-separator my4"></div>
                        <a href="" class="button-style delete-post-button">Delete Post</a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="post-content">{{ $post_content }}</div>
            @can('update', $post)
            <div class="post-edit-container none">
                <p class="bold my8">{{ __('EDIT YOUR POST') }} <span class="error fs13"></span></p>
                <textarea name="content" class="reply-content" id="post-edit-content-{{ $post_id }}"></textarea>
                <a href="" class="button-style inline-block exit-edit-post">{{ __('Discard') }}</a>
                <a href="" class="button-style inline-block save-edit-post">{{ __('Save Changes') }}</a>
                <input type="hidden" class="post_id" value="{{ $post_id }}">
            </div>
            @endcan
        </div>
    </div>
</div>