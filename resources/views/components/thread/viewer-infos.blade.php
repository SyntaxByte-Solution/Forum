<div>
    <div class="thread-media-viewer-infos-header">
        <div class="flex">
            <a href="{{ $thread->user->profilelink }}" class="relative hidden-overflow rounded">
                <img src="{{ $thread->user->avatar }}" class="size40 rounded">
            </a>
            <div class="ml8">
                <div class="flex align-end">
                    <a href="{{ $thread->user->profilelink }}" class="bold no-underline blue fs15 mr4">{{ $owner_full_name }}</a>
                    @if(auth()->user() && $thread->user->id != auth()->user()->id)
                    <span class="fs10 gray" style="margin: 0 4px 2px 0">•</span>
                    <div class="follow-box">
                        <div class="pointer @auth follow-resource @endauth @guest login-signin-button @endguest">
                            @if($followed)
                            <p class="fs12 no-margin bold gray btn-txt">{{ __('Followed') }}</p>
                            <input type="hidden" class="status" value="1">
                            @else
                            <p class="fs12 no-margin bold blue btn-txt">{{ __('Follow') }}</p>
                            <input type="hidden" class="status" value="-1">
                            @endif
                            <input type="hidden" class="follow-text" value="{{ __('Follow') }}">
                            <input type="hidden" class="following-text" value="{{ __('Following ..') }}">
                            <input type="hidden" class="followed-text" value="{{ __('Followed') }}">
                            <input type="hidden" class="unfollowing-text" value="{{ __('Unfollowing ..') }}">
                            <input type="hidden" class="followable-id" value="{{ $thread->user->id }}">
                            <input type="hidden" class="followable-type" value="user">

                            <input type="hidden" class="followed-icon" value="followed14-icon">
                            <input type="hidden" class="unfollowed-icon" value="follow14-icon">
                        </div>
                    </div>
                    @endif
                </div>
                <p class="no-margin gray fs13">{{ $owner_username }}</p>
            </div>
        </div>
        <div class="relative">
            <div class="pointer button-with-suboptions size20 sprite sprite-2-size menu20-icon mr4"></div>
        </div>
    </div>
    <div class="thread-media-viewer-infos-content">
        <div class="expand-box">
            <span><a href="{{ $thread->link }}" class="expandable-text bold fs17 blue no-underline my4">{{ $thread->slice }}</a></span>
            @if($thread->slice != $thread->subject)
            <input type="hidden" class="expand-slice-text" value="{{ $thread->slice }}">
            <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
            <input type="hidden" class="expand-text-state" value="0">
            <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
            <input type="hidden" class="expand-text" value="{{ __('see all') }}">
            <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
            @endif
        </div>
        <div class="my8 expand-box">
            <span class="expandable-text fs15 no-underline">{{ $thread->contentslice }}</span>
            @if($thread->content != $thread->contentslice)
            <input type="hidden" class="expand-slice-text" value="{{ $thread->contentslice }}">
            <input type="hidden" class="expand-whole-text" value="{{ $thread->content }}">
            <input type="hidden" class="expand-text-state" value="0">
            <span class="pointer expand-button fs12 inline-block blue">{{ __('see all') }}</span>
            <input type="hidden" class="expand-text" value="{{ __('see all') }}">
            <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
            @endif
        </div>
        <div class="flex align-center thread-viewer-react-container">
            <input type="hidden" class="likable-type" value="thread">
            <input type="hidden" class="likable-id" value="{{ $thread->id }}">
            <div class="thread-react-hover @auth like-resource @endauth @guest login-signin-button @endguest">
                <div class="small-image-2 sprite sprite-2-size resource17-like-gicon gray-love @if($thread->liked) none @endif"></div>
                <div class="small-image-2 sprite sprite-2-size resource17-like-ricon red-love @if(!$thread->liked) none @endif"></div>
                <p class="gray no-margin fs12 resource-likes-counter unselectable ml4">{{ $thread->likes->count() }}</p>
            </div>
            <div class="thread-react-hover flex align-center">
                <div class="small-image-2 sprite sprite-2-size replyfilled17-icon mr4"></div>
                <p class="no-margin unselectable fs12">{{ $thread->posts->count() }} {{__('replies')}}</p>
            </div>
            <div class="thread-react-hover flex align-center move-to-right">
                <div class="small-image-2 sprite sprite-2-size eye17-icon mr4"></div>
                <p class="no-margin fs12 unselectable">{{ $thread->view_count }}</p>
            </div>
        </div>
        <div class="simple-line-separator my4"></div>
        <div>
            <p class="my4 fs15 bold">Replies ({{ $thread->posts->count() }})</p>
            <div class="viewer-replies-container mt8">
                @if($ticked = $thread->tickedPost())
                    <x-thread.viewer-reply :post="$ticked"/>
                @endif
                @foreach($posts as $post)
                    <x-thread.viewer-reply :post="$post"/>
                @endforeach
            </div>
        </div>
    </div>
</div>