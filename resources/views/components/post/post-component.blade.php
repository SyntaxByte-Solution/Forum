<div class="relative post-container resource-container" id="@if($post->ticked){{'ticked-post'}}@endif">
    <input type="hidden" class="votable-type" value="post">
    <input type="hidden" class="votable-id" value="{{ $post->id }}">
    <input type="hidden" class="likable-type" value="post">
    <input type="hidden" class="likable-id" value="{{ $post->id }}">
    <div class="absolute full-shadowed br6" style="z-index: 1">
        @can('destroy', $post)
        <div class="full-center full-width full-height">
            <div class="flex align-center">
                <input type="button" class="simple-white-button pointer delete-post" value="Delete">
                <a href="" class="simple-link close-shadowed-view-button" style="text-decoration: none; margin-left: 6px; font-size: 10px">CANCEL</a>
                <input type="hidden" class="post-id" value="{{ $post_id }}">
            </div>
        </div>
        @endcan
    </div>
    <div class="show-post-container fs11">
        <div class="line-separator"></div>
        {{ __('Reply hidden') }} [<a href="" class="show-post black-link bold">{{ __('click here to show it') }}</a>]
        <div class="line-separator"></div>
    </div>
    <div class="flex post-main-component relative" style="@if($post->ticked) border-color: #1c8e19b3; @endif">
        <div id="{{ $post_id }}" class="absolute" style="top: -65px">
        </div>
        <div class="vote-section post-vs relative">
            <div class="informer-message-container absolute left100 zi1">
                <div class="left-middle-triangle"></div>
                <div class="flex align-center">
                    <p class="informer-message">{{ __("you can't up vote your thread") }}</p>
                    <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                </div>
            </div>
            <a href="" class="@auth votable-up-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/up-filled.png') }}" class="small-image vote-up-filled-image @upvoted($post, 'App\Models\Post') @else none @endupvoted" alt="">
                <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image vote-up-image @upvoted($post, 'App\Models\Post') none @endupvoted" alt="">
            </a>
            <p class="bold fs16 no-margin text-center votable-count">{{ $post_votes }}</p>
            <a href="" class="@auth votable-down-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/down-filled.png') }}" class="small-image vote-down-filled-image @downvoted($post, 'App\Models\Post') @else none @enddownvoted" alt="">
                <img src="{{ asset('assets/images/icons/down-arrow.png') }}" class="small-image vote-down-image @downvoted($post, 'App\Models\Post') none @enddownvoted" alt="">
            </a>

            <div class="mt8 relative informer-box tick-post-container">
                @can('update', $post->thread)
                <div class="informer-message-container absolute zi1" style="left: 126%; top: -10px">
                    <div>
                        <p class="informer-message"></p>
                    </div>
                </div>
                <a href="" class="hover-informer-display-element">
                    <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="size28 green-tick @if(!$post->ticked) none @endif" alt="">
                    <img src="{{ asset('assets/images/icons/grey-tick.png') }}" class="size28 grey-tick @if($post->ticked) none @endif" alt="">
                </a>
                <input type="hidden" value="{{ $post->id }}" class="post-id">
                @else
                    @if($post->ticked)
                    <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="size28 grey-tick" alt="">
                    @endif
                @endcan
            </div>
        </div>
        <div class="post-main-section" style="@if($post->ticked) background-color: #e1ffe44a; @endif">
            <div class="flex space-between">
                <div>
                    <div class="no-margin fs12 gray">
                        <div class="inline-block relative">
                            <div class="flex">
                                <div class="relative">
                                    <a href="{{ route('user.profile', ['user'=>$post->user->username]) }}" class="button-with-container forum-style-link fs12 flex">
                                        <img src="{{ $post_owner->avatar }}" class="size28 mr4 rounded" alt="">
                                    </a>
                                    
                                    @include('partials.user-profile-card', ['user'=>$post_owner])
                                </div>
                                <div>
                                    <a href="{{ route('user.profile', ['user'=>$post->user->username]) }}" class="bold link-path">{{ $post_owner_username }}</a>
                                    <span class="relative block">
                                        <span class="tooltip-section">{{ __('replied') }}: {{ $post_date }}</span>
                                        <span class="tooltip tooltip-style-1">{{ $post_created_at }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($post_updated_at)
                            <span class="relative" style="margin-left: 8px">
                                <span class="tooltip-section post-updated-date">(updated {{ $post_update_date }})</span>
                                <span class="tooltip tooltip-style-1 post-updated-date-human">{{ $post_updated_at }}</span>
                            </span>
                        @endif
                    </div>
                    <div class="simple-line-separator my4"></div>
                </div>
                <div class="flex align-center relative">
                    @auth
                    <div class="resource-like-container like-resource pointer">
                        <div class="small-image-2 sprite sprite-2-size resource17-like-gicon gray-love @if($post->liked_by(auth()->user())) none @endif"></div>
                        <div class="small-image-2 sprite sprite-2-size resource17-like-ricon red-love @if(!$post->liked_by(auth()->user())) none @endif"></div>
                        <p class="no-margin mx4 fs13 resource-likes-counter">{{ $post->likes->count() }}</p>
                    </div>
                    @endauth
                    <p class="best-reply-ticket unselectable @if(!$post->ticked) none @endif">{{ __('BEST REPLY') }}</p>
                    <div>
                        <a href="" class="black-link button-with-suboptions">
                            <img src="{{ asset('assets/images/icons/dotted-menu.svg') }}" class="small-image" alt="">
                        </a>
                        <div class="absolute suboptions-container suboption-style-left">
                            <a href="" class="button-style hide-post">Hide Post</a>
                            @can('update', $post)
                            <a href="" class="button-style edit-post">Edit Post</a>
                            @endcan
                            @can('destroy', $post)
                            <div class="simple-line-separator my4" style="background-color: #474c5e"></div>
                            <a href="" class="button-style delete-post-button">Delete Post</a>
                            @endcan
                        </div>
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