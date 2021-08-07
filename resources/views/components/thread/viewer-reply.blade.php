<div class="relative viewer-thread-reply my8 @if($post->ticked) viewer-ticked-reply @endif">
    <input type="hidden" class="post-id" value="{{ $post->id }}">
    <input type="hidden" class="votable-type" value="post">
    <input type="hidden" class="votable-id" value="{{ $post->id }}">

    @can('destroy', $post)
    <div class="absolute full-shadowed br6" style="z-index: 1">
        @can('destroy', $post)
        <div class="full-center full-width full-height">
            <div class="flex align-center">
                <input type="button" class="simple-white-button pointer delete-post delete-from-viewer" value="{{ __('Delete') }}">
                <a href="" class="simple-link close-shadowed-view-button" style="text-decoration: none; margin-left: 6px; font-size: 10px">CANCEL</a>
                <input type="hidden" class="post-id" value="{{ $post->id }}">
                <input type="hidden" class="button-ing-text" value="{{ __('Deleting') }}..">
            </div>
        </div>
        @endcan
    </div>
    @endcan

    <div class="show-post-container fs11 mx4 my4">
        {{ __('Reply hidden') }} [<a href="" class="show-post show-post-from-viewer black-link bold">{{ __('click here to show it') }}</a>]
    </div>

    <div class="viewer-post-main-component">
        <div class="viewer-thread-reply-header flex space-between">
            <div class="flex">
                <a href="{{ $post->user->profilelink }}" class="button-with-container forum-style-link fs12 flex">
                    <img src="{{ $post->user->sizedavatar(36) }}" class="size36 mr8 rounded" alt="">
                </a>
                <div>
                    <a href="{{ $post->user->profilelink }}" class="no-margin bold blue no-underline">Mouad Nassri</a>
                    <div class="flex align-center">
                        <p class="no-margin fs12" style="margin-top: 1px">grotto_IV</p>
                        <span class="fs10 gray mx4 unselectable">•</span>
                        <span class="relative block" style="padding-bottom: 1px">
                            <span class="tooltip-section fs11 gray">{{ $post->creation_date_humans }}</span>
                            <span class="tooltip tooltip-style-1">{{ $post->creation_date }}</span>
                        </span>
                        <span class="@if(!$post->is_updated) none @endif gray fs11 ml4 post-updated-date">({{ __('edited') }})</span>
                    </div>
                </div>
            </div>
            <div class="flex align-center">
                <p class="best-reply-ticket unselectable @if(!$post->ticked) none @endif" style="margin-right: 4px; padding: 6px; font-size: 11px">{{ __('BEST REPLY') }}</p>
                <div class="relative">
                    <svg class="pointer button-with-suboptions size20 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                    <div class="suboptions-container suboptions-container-right-style">
                        <div class="simple-suboption pointer hide-post hide-post-from-viewer flex align-center">
                            <div class="small-image-2 sprite sprite-2-size eyecrossed17-icon mr4"></div>
                            {{ __('Hide reply') }}
                        </div>
                        @can('update', $post)
                        <div class="simple-suboption pointer edit-post edit-post-from-viewer flex align-center">
                            <div class="small-image-2 sprite sprite-2-size pen17-icon mr4"></div>
                            {{ __('Edit reply') }}
                            <div style="width: 8px">
                                <div class="loading-dots-anim ml4 none">•</div>
                            </div>
                        </div>
                        @endcan
                        @can('destroy', $post)
                        <div class="simple-suboption pointer delete-post-button flex align-center">
                            <div class="small-image-2 sprite sprite-2-size delete17b-icon mr4"></div>
                            {{ __('Delete reply') }}
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="flex">
            <div style="width: 44px" class="flex justify-center">
                @if($post->ticked)
                <div class="sprite sprite-2-size size20 mt8 greentick20-icon" alt="{{ __('This is the best reply') }}"></div>
                @endif
            </div>
            <div class="border-box full-width">
                <div class="thread-viewer-reply-content post-content">
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
                    <input type="hidden" class="edited-text" value="({{ __('edited') }})">
                </div>
                @endcan
                <div class="flex align-center" style="margin-top: 2px">
                    <div class="flex align-center mr8 vote-box relative">
                        <input type="hidden" class="votable-type" value="post">
                        <input type="hidden" class="votable-id" value="{{ $post->id }}">
                        <div class="informer-message-container absolute zi1" style="left: -1px; bottom: calc(100% + 2px)">
                            <div class="flex align-center">
                                <p class="informer-message"></p>
                                <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                            </div>
                        </div>
                        <div class="pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest">
                            <div class="small-image-2 sprite sprite-2-size vote-icon @upvoted($post, 'App\Models\Post') upvotefilled17-icon @else upvote17-icon @endupvoted"></div>
                        </div>
                        <div class="fs10 gray" style="margin: 0 2px">•</div>
                        <div class="pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest">
                            <div class="small-image-2 sprite sprite-2-size vote-icon @downvoted($post, 'App\Models\Post') downvotefilled17-icon @else downvote17-icon @enddownvoted"></div>
                        </div>
                        <p class="fs12 no-margin text-center bold ml4">(<span class="votable-count">{{ $post->votevalue }}</span>)</p>
                    </div>
                    <div>
                        <div class="thread-react-hover @auth like-resource like-resource-from-viewer @endauth @guest login-signin-button @endguest">
                            <input type="hidden" class="likable-type" value="post">
                            <input type="hidden" class="likable-id" value="{{ $post->id }}">
                            <svg class="size17 like-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                                <path class="red-like @if(!$post->liked_by(auth()->user())) none @endif" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                                <path class="grey-like @if($post->liked_by(auth()->user())) none @endif" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                            </svg>
                            <p class="no-margin mx4 fs13 resource-likes-counter">{{ $post->likes->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>