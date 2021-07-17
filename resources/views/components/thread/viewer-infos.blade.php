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
                    <span class="fs10 gray" style="margin: 0 4px 3px 0">•</span>
                    <div class="follow-box" style="padding-bottom: 1px">
                        <div class="pointer @auth follow-resource @endauth @guest login-signin-button @endguest">
                            @if($followed)
                            <p class="fs12 no-margin bold gray btn-txt">{{ __('Followed') }}</p>
                            <input type="hidden" class="status" value="1">
                            @else
                            <p class="fs12 no-margin bold blue btn-txt" style="margin-top=">{{ __('Follow') }}</p>
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
        <div class="px8 py8">
            <div class="expand-box mb8">
                <span><a href="{{ $thread->link }}" class="expandable-text bold fs20 blue no-underline my4">{{ $thread->slice }}</a></span>
                @if($thread->slice != $thread->subject)
                <input type="hidden" class="expand-slice-text" value="{{ $thread->slice }}">
                <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
                <input type="hidden" class="expand-text-state" value="0">
                <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
                <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                @endif
            </div>
            <div class="mb8 expand-box">
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
        </div>
        <div class="flex align-center thread-viewer-react-container px8 mb8">
            <input type="hidden" class="likable-type" value="thread">
            <input type="hidden" class="likable-id" value="{{ $thread->id }}">

            <div class="relative vote-box">
                <input type="hidden" class="votable-type" value="thread">
                <input type="hidden" class="votable-id" value="{{ $thread->id }}">
                <div class="informer-message-container absolute zi1" style="left: -1px; bottom: calc(100% + 2px)">
                    <div class="flex align-center">
                        <p class="informer-message">{{__("you can't up vote your thread")}}</p>
                        <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                    </div>
                </div>
                <div class="suboptions-container suboptions-above-button-style">
                    <!-- this will be thread voting -->
                    <div class="flex align-center">
                        <div class="pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest">
                            <div class="small-image-2 sprite sprite-2-size vote-icon @upvoted($thread, 'App\Models\Thread') upvotefilled17-icon @else upvote17-icon @endupvoted"></div>
                        </div>
                        <div class="fs10 gray mx4">•</div>
                        <div class="pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest">
                            <div class="small-image-2 sprite sprite-2-size vote-icon @downvoted($thread, 'App\Models\Thread') downvotefilled17-icon @else downvote17-icon @enddownvoted"></div>
                        </div>
                        <p class="fs13 no-margin text-center ml8">(<span class="votable-count">{{ $thread->votevalue }}</span>)</p>
                    </div>
                </div>
                <div class="thread-react-hover votes-button button-with-suboptions @guest login-signin-button @endguest">
                    <div class="small-image-2 sprite sprite-2-size votes-button-icon @downvoted($thread, 'App\Models\Thread') downvoted17-icon @else votes17-icon @enddownvoted @upvoted($thread, 'App\Models\Thread') upvoted17-icon @else votes17-icon  @endupvoted"></div>
                    <p class="gray no-margin fs12 votable-count unselectable" style="margin-left: 3px">{{ $thread->votevalue }}</p>
                </div>
            </div>
            <div class="thread-react-hover @auth like-resource @endauth @guest login-signin-button @endguest">
                <div class="small-image-2 sprite sprite-2-size resource17-like-gicon gray-love @if($thread->liked) none @endif"></div>
                <div class="small-image-2 sprite sprite-2-size resource17-like-ricon red-love @if(!$thread->liked) none @endif"></div>
                <p class="gray no-margin fs12 resource-likes-counter unselectable ml4">{{ $thread->likes->count() }}</p>
            </div>
            <div class="thread-react-hover move-to-thread-viewer-reply flex align-center">
                <div class="small-image-2 sprite sprite-2-size replyfilled17-icon mr4"></div>
                <p class="no-margin unselectable fs12">{{ $thread->posts->count() }} {{__('replies')}}</p>
            </div>
            <div class="flex align-center move-to-right mr4">
                <div class="small-image-2 sprite sprite-2-size eye17-icon mr4"></div>
                <p class="no-margin fs12 unselectable">{{ $thread->view_count }}</p>
            </div>
        </div>
        <div class="simple-line-separator mb4"></div>
        <div id="viewer-reply-container">
            <div class="flex space-between my4" id="reply-site">
                <p class="bold fs15 my4 ml8 forum-color" id="viewer-reply-text-label">{{ __('Reply') }}</p>
                <input type="button" value="{{ __('Share reply') }}" class="share-viewer-reply button-style-1 height-max-content mr4">
                <input type="hidden" class="button-text-ing" value="{{ __('Sharing your reply..') }}">
                <input type="hidden" class="button-text-no-ing" value="{{ __('Share reply') }}">
                <input type="hidden" class="thread-id" value="{{ $thread->id }}">

                <input type="hidden" class="required-error" value="{{ __('* Reply field is required') }}">
                <input type="hidden" class="reply-size-error" value="{{ __('* Reply must contain at least 2 characters') }}">
            </div>
            <p class="reply-error error ml8 none"></p>
            <textarea name="content" id="viewer-reply-input"></textarea>
            <script>
                let viewer_reply_simplemde = new SimpleMDE({
                    placeholder: '{{ __("Add a discussion content here..") }}',
                    hideIcons: ["guide", "heading", "link", "image"],
                    spellChecker: false,
                });
            </script>
            <style>
                .thread-media-viewer-infos-content .editor-toolbar {
                    background-color: #f1f9ff;
                }
                .thread-media-viewer-infos-content .fa-arrows-alt, .thread-media-viewer-infos-content .fa-columns {
                    display: none !important;
                }
                .thread-media-viewer-infos-content .separator:last-of-type {
                    display: none !important;
                }
                .thread-media-viewer-infos-content .CodeMirror,
                .thread-media-viewer-infos-content .CodeMirror-scroll {
                    max-height: 100px !important;
                    min-height: 100px !important;
                    border-radius: 0;
                    border-left: none;
                    border-right: none;
                    border-color: #dbdbdb;
                }
                .thread-media-viewer-infos-content .CodeMirror-scroll:focus {
                    border-color: #64ceff;
                    box-shadow: 0 0 0px 3px #def2ff;
                }
                .thread-media-viewer-infos-content .editor-toolbar {
                    padding: 0 4px;
                    opacity: 0.8;
                    height: 38px;
                    border-radius: 0;
                    border-left: none;
                    border-right: none;
                    border-top-color: #dbdbdb;

                    display: flex;
                    align-items: center;
                }
                .thread-media-viewer-infos-content .editor-statusbar {
                    border-radius: 0px !important;
                }
            </style>
        </div>
        @if($thread->posts->count())
        <div class="mx8">
            <p class="my4 fs15 bold">Replies (<span class="thread-replies-number">{{ $thread->posts->count() }}</span>)</p>
            <div class="viewer-replies-container mt8">
                @if($ticked = $thread->tickedPost())
                    <x-thread.viewer-reply :post="$ticked"/>
                @endif
                @foreach($posts as $post)
                    <x-thread.viewer-reply :post="$post"/>
                @endforeach
                @if($thread->posts->count() > $posts->count())
                <div>
                    <input type='button' class="see-all-full-style" id="viewer-replies-load" value="{{__('View more replies')}}">
                    <input type="hidden" class="button-text-ing" value="{{ __('Loading replies') }}">
                    <input type="hidden" class="button-text-no-ing" value="{{ __('View more replies') }}">
                    <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>