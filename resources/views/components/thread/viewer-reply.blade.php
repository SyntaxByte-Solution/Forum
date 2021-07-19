<div class="viewer-thread-reply my8 @if($post->ticked) viewer-ticked-reply @endif">
    <input type="hidden" class="post-id" value="{{ $post->id }}">
    <input type="hidden" class="votable-type" value="post">
    <input type="hidden" class="votable-id" value="{{ $post->id }}">

    <div class="show-post-container fs11 mx4 my4">
        {{ __('Reply hidden') }} [<a href="" class="show-post show-post-from-viewer black-link bold">{{ __('click here to show it') }}</a>]
    </div>

    <div class="viewer-post-main-component">
        <div class="viewer-thread-reply-header flex space-between">
            <div class="flex">
                <a href="{{ $post->user->profilelink }}" class="button-with-container forum-style-link fs12 flex">
                    <img src="{{ $post->user->avatar }}" class="size36 mr8 rounded" alt="">
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
                    </div>
                </div>
            </div>
            <div class="flex align-center">
                <p class="best-reply-ticket unselectable @if(!$post->ticked) none @endif" style="margin-right: 4px; padding: 6px; font-size: 11px">{{ __('BEST REPLY') }}</p>
                <div class="relative">
                    <div class="pointer button-with-suboptions size20 sprite sprite-2-size menu20-icon mr4"></div>
                    <div class="suboptions-container suboptions-container-right-style">
                        <div class="simple-suboption pointer hide-post hide-post-from-viewer flex align-center">
                            <div class="small-image-2 sprite sprite-2-size eyecrossed17-icon mr4"></div>
                            {{ __('Hide reply') }}
                        </div>
                        @can('update', $post)
                        <div class="simple-suboption pointer edit-post flex align-center">
                            <div class="small-image-2 sprite sprite-2-size pen17-icon mr4"></div>
                            {{ __('Edit reply') }}
                        </div>
                        @endcan
                        @can('destroy', $post)
                        <div class="simple-line-separator my4" style="background-color: #474c5e"></div>
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
                <div class="thread-viewer-reply-content ">
                    {{ $post->parsed_content }}
                </div>
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
                            <div class="small-image-2 sprite sprite-2-size like-icon @if($post->liked_by(auth()->user())) resource17-like-ricon @else resource17-like-gicon @endif"></div>
                            <p class="no-margin mx4 fs13 resource-likes-counter">{{ $post->likes->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>