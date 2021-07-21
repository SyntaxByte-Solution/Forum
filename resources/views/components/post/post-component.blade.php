<div class="relative post-container resource-container" id="@if($post->ticked){{'ticked-post'}}@endif">
    <input type="hidden" class="post-id" value="{{ $post->id }}">
    <input type="hidden" class="likable-type" value="post">
    <input type="hidden" class="likable-id" value="{{ $post->id }}">
    <div class="absolute full-shadowed br6" style="z-index: 1">
        @can('destroy', $post)
        <div class="full-center full-width full-height">
            <div class="flex align-center">
                <input type="button" class="simple-white-button pointer delete-post delete-from-outside-viewer" value="Delete">
                <a href="" class="simple-link close-shadowed-view-button" style="text-decoration: none; margin-left: 6px; font-size: 10px">CANCEL</a>
                <input type="hidden" class="post-id" value="{{ $post->id }}">
                <input type="hidden" class="button-ing-text" value="{{ __('Deleting') }}..">
            </div>
        </div>
        @endcan
    </div>
    <div class="show-post-container fs11">
        <div class="line-separator"></div>
        {{ __('Reply hidden') }} [<a href="" class="show-post show-post-from-outside-viewer black-link bold">{{ __('click here to show it') }}</a>]
        <div class="line-separator"></div>
    </div>
    <div class="flex post-main-component relative" style="@if($post->ticked) border-color: #28882678; @endif">
        <div id="{{ $post->id }}" class="absolute" style="top: -65px"></div>
        <div class="vote-section post-vs relative">
            <div class="vote-box relative">
                <input type="hidden" class="votable-id" value="{{ $post->id }}">
                <input type="hidden" class="votable-type" value="post">
                <div class="informer-message-container absolute zi1" style="left: calc(100% + 8px); top: 10px;">
                    <div class="left-middle-triangle"></div>
                    <div class="flex align-center">
                        <p class="informer-message"></p>
                        <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                    </div>
                </div>
                <div class="pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest">
                    <div class="small-image sprite sprite-2-size vote-icon @upvoted($post, 'App\Models\Post') upvotefilled20-icon @else upvote20-icon @endupvoted"></div>
                </div>
                <p class="bold fs16 no-margin text-center votable-count">{{ $post_votes }}</p>
                <div class="pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest">
                    <div class="small-image sprite sprite-2-size vote-icon @downvoted($post, 'App\Models\Post') downvotefilled20-icon @else downvote20-icon @enddownvoted"></div>
                </div>
            </div>

            <div class="mt8 relative informer-box tick-post-container">
                @can('update', $post->thread)
                <div class="informer-message-container absolute zi1" style="left: 126%; top: -10px">
                    <div>
                        <p class="informer-message"></p>
                    </div>
                </div>
                <a href="" class="hover-informer-display-element">
                    <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="size20 green-tick @if(!$post->ticked) none @endif" alt="">
                    <img src="{{ asset('assets/images/icons/grey-tick.png') }}" class="size20 grey-tick @if($post->ticked) none @endif" alt="">
                </a>
                <input type="hidden" value="{{ $post->id }}" class="post-id">
                @else
                    @if($post->ticked)
                        <div class="sprite sprite-2-size size20 greentick20-icon" alt="{{ __('This is the best reply') }}"></div>
                    @endif
                @endcan
            </div>
        </div>
        <div class="post-main-section" style="@if($post->ticked) background-color: #e1ffe438; @endif">
            <div class="flex align-center space-between px8 py8">
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
                        <span class="@if(!$post->is_updated) none @endif post-updated-date">({{ __('edited') }})</span>
                    </div>
                </div>
                <div class="flex align-center relative height-max-content">
                    <div class="thread-react-hover @auth like-resource like-resource-from-outside-viewer @endauth @guest login-signin-button @endguest">
                        <input type="hidden" class="likable-id" value="{{ $post->id }}">
                        <input type="hidden" class="likable-type" value="post">
                        <div class="small-image-2 sprite sprite-2-size like-icon @auth @if($post->liked_by(auth()->user())) resource17-like-ricon @else resource17-like-gicon @endif @endauth @guest resource17-like-gicon @endguest"></div>
                        <p class="no-margin mx4 fs13 resource-likes-counter">{{ $post->likes->count() }}</p>
                    </div>
                    <p class="best-reply-ticket unselectable @if(!$post->ticked) none @endif">{{ __('BEST REPLY') }}</p>
                    <div>
                        <a href="" class="black-link button-with-suboptions">
                            <img src="{{ asset('assets/images/icons/dotted-menu.svg') }}" class="small-image" alt="">
                        </a>
                        <div class="suboptions-container suboptions-container-right-style">
                            <div class="simple-suboption hide-post hide-post-from-outside-viewer flex align-center">
                                <div class="small-image-2 sprite sprite-2-size eyecrossed17-icon mr4"></div>
                                {{ __('Hide reply') }}
                            </div>
                            @can('update', $post)
                            <div class="simple-suboption edit-post edit-post-from-outside-viewer flex align-center">
                                <div class="small-image-2 sprite sprite-2-size pen17-icon mr4"></div>
                                {{ __('Edit reply') }}
                                <div style="width: 8px">
                                    <div class="loading-dots-anim ml4 none">•</div>
                                </div>
                            </div>
                            @endcan
                            @can('destroy', $post)
                            <div class="simple-line-separator my4" style="background-color: #474c5e"></div>
                            <div class="simple-suboption delete-post-button flex align-center">
                                <div class="small-image-2 sprite sprite-2-size delete17b-icon mr4"></div>
                                {{ __('Delete reply') }}
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-line-separator mb4"></div>
            <div class="post-content px8">
                {{ $post->parsed_content }}
            </div>
            @can('update', $post)
            <div class="post-edit-container px8 py8 none">
                <div class="flex align-center space-between">
                    <p class="fs12 bold my8">{{ __('EDIT YOUR POST') }} <span class="error fs13"></span></p>
                    <div class="flex align-center">
                        <a href="" class="simple-white-button save-edit-post" style="background-color: #a8d8ff">{{ __('Save') }}</a>
                        <a href="" class="simple-white-button exit-edit-post ml4">✖</a>
                    </div>
                </div>
                <textarea name="content" class="reply-content" id="post-edit-content-{{ $post->id }}"></textarea>
                <input type="hidden" class="post_id" value="{{ $post->id }}">
            </div>
            @endcan
        </div>
    </div>
</div>