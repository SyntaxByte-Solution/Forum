<div class="relative">
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
            <a href="" class="up-icon post-vote-button thread-up-vote"></a>
            <p class="bold fs20 no-margin text-center">0</p>
            <a href="" class="down-icon post-vote-button thread-down-vote"></a>
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
                            <span class="tooltip">{{ $post_created_at }}</span>
                        </span>
                        @if($post_updated_at)
                            <span class="relative" style="margin-left: 8px">
                                <span class="tooltip-section post-updated-date">(upated {{ $post_update_date }})</span>
                                <span class="tooltip post-updated-date-human">{{ $post_updated_at }}</span>
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