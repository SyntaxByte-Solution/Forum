<div class="viewer-thread-reply my8 @if($post->ticked) viewer-ticked-reply @endif">
    <input type="hidden" class="votable-type" value="post">
    <input type="hidden" class="votable-id" value="{{ $post->id }}">
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
            <div>
                <div class="thread-react-hover @auth like-resource @endauth @guest login-signin-button @endguest">
                    <input type="hidden" class="likable-type" value="post">
                    <input type="hidden" class="likable-id" value="{{ $post->id }}">
                    <div class="small-image-2 sprite sprite-2-size like-icon @if($post->liked_by(auth()->user())) resource17-like-ricon @else resource17-like-gicon @endif"></div>
                    <p class="no-margin mx4 fs13 resource-likes-counter">{{ $post->likes->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="flex">
        <div style="width: 44px" class="flex justify-center">
            <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="size20 mt8 @if(!$post->ticked) none @endif" alt="">
        </div>
        <div class="thread-viewer-reply-content">
            {{ $post->parsed_content }}
        </div>
    </div>
</div>