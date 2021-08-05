<div>
    <div class="thread-media-viewer-infos-header">
        <div class="flex">
            <a href="{{ $thread->user->profilelink }}" class="relative hidden-overflow rounded">
                <img src="{{ $thread->user->sizedavatar(100) }}" class="size40 rounded">
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
                <span><a href="{{ $thread->link }}" class="expandable-text bold fs20 blue no-underline my4">{{ $thread->mediumslice }}</a></span>
                @if($thread->mediumslice != $thread->subject)
                <input type="hidden" class="expand-slice-text" value="{{ $thread->mediumslice }}">
                <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
                <input type="hidden" class="expand-text-state" value="0">
                <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
                <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                @endif
            </div>
            <div class="mb8 expand-box">
                <span class="expandable-text fs15 no-underline">{{ $thread->mediumcontentslice }}</span>
                @if($thread->content != $thread->mediumcontentslice)
                <input type="hidden" class="expand-slice-text" value="{{ $thread->mediumcontentslice }}">
                <input type="hidden" class="expand-whole-text" value="{{ $thread->content }}">
                <input type="hidden" class="expand-text-state" value="0">
                <span class="pointer expand-button fs12 inline-block blue">{{ __('see all') }}</span>
                <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                @endif
            </div>
        </div>
        <div class="simple-line-separator mb4"></div>
        <div class="flex align-center thread-viewer-react-container px8">
            <div class="relative vote-box thread-vote-box">
                <input type="hidden" class="votable-type" value="thread">
                <input type="hidden" class="votable-id" value="{{ $thread->id }}">
                <div class="informer-message-container absolute zi1" style="left: -1px; bottom: calc(100% + 2px)">
                    <div class="flex align-center">
                        <p class="informer-message"></p>
                        <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                    </div>
                </div>
                <div class="suboptions-container suboptions-above-button-style width-max-content " style="top: calc(100% + 2px); bottom: unset;">
                    <!-- this will be thread voting -->
                    <div class="full-center">
                        <div class="sprite sprite-2-size size28 vote28-icon"></div>
                    </div>
                    <p class="no-margin bold fs13 mx4 my4 unselectable">{{ __('Vote this discussion') }}</p>
                    <div class="flex justify-center mb4">
                        <div class="flex align-center">
                            <div class="pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest">
                                <div class="small-image-2 sprite sprite-2-size vote-icon @upvoted($thread, 'App\Models\Thread') upvotefilled17-icon @else upvote17-icon @endupvoted"></div>
                            </div>
                            <div class="fs10 gray mx4">•</div>
                            <div class="pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest">
                                <div class="small-image-2 sprite sprite-2-size vote-icon @downvoted($thread, 'App\Models\Thread') downvotefilled17-icon @else downvote17-icon @enddownvoted"></div>
                            </div>
                            <p class="fs12 no-margin text-center bold ml8">(<span class="votable-count">{{ $thread->votevalue }}</span>)</p>
                        </div>
                    </div>
                </div>
                <div class="thread-react-hover votes-button @auth button-with-suboptions @endauth @guest login-signin-button @endguest">
                    <div class="small-image-2 sprite sprite-2-size votes-button-icon @downvoted($thread, 'App\Models\Thread') downvoted17-icon @else votes17-icon @enddownvoted @upvoted($thread, 'App\Models\Thread') upvoted17-icon @else votes17-icon  @endupvoted"></div>
                    <p class="gray no-margin fs12 votable-count unselectable" style="margin-left: 3px">{{ $thread->votevalue }}</p>
                </div>
            </div>
            <div class="thread-react-hover @auth like-resource viewer-thread-like like-resource-from-viewer @endauth @guest login-signin-button @endguest">
                <input type="hidden" class="likable-type" value="thread">
                <input type="hidden" class="likable-id" value="{{ $thread->id }}">
                <div class="small-image-2 sprite sprite-2-size like-icon @if($thread->liked) resource17-like-ricon @else resource17-like-gicon @endif"></div>
                <p class="gray no-margin fs12 resource-likes-counter unselectable ml4">{{ $thread->likes->count() }}</p>
            </div>
            <div class="thread-react-hover @auth move-to-thread-viewer-reply @endauth flex align-center">
                <div class="small-image-2 sprite sprite-2-size replyfilled17-icon mr4"></div>
                <p class="no-margin unselectable fs12"><span class="viewer-thread-replies-number">{{ $thread->posts->count() }}</span> {{__('replies')}}</p>
            </div>
            <div class="flex align-center move-to-right mr4">
                <div class="small-image-2 sprite sprite-2-size eye17-icon mr4"></div>
                <p class="no-margin fs12 unselectable">{{ $thread->view_count }}</p>
            </div>
        </div>
        <div class="simple-line-separator my4"></div>
        @auth
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
                var viewer_reply_simplemde = new SimpleMDE({
                    placeholder: '{{ __("Your reply here..") }}',
                    hideIcons: ["guide", "heading", "link", "image"],
                    spellChecker: false,
                    showMarkdownLineBreaks: true,
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
                
                .viewer-thread-reply .CodeMirror {
                    border-left: 1px solid #dbdbdb;
                    border-right: 1px solid #dbdbdb;
                    border-color: #dbdbdb;
                }

                .viewer-thread-reply .editor-toolbar {
                    border-left: 1px solid #dbdbdb;
                    border-right: 1px solid #dbdbdb;
                    border-top-color: #dbdbdb;
                }
            </style>
        </div>
        @endauth
        <p id="viewer-replies-site" class="my4 py4 ml8 fs15 bold viewer-thread-replies-number-container @if(!$thread->posts->count()) none @endif">Replies (<span class="viewer-thread-replies-number">{{ $thread->posts->count() }}</span>)</p>
        <div class="mx8">
            <div class="viewer-replies-container mt8" id="viewer-replies-box">
            @if($thread->posts->count())
                @if($ticked = $thread->tickedPost())
                    <x-thread.viewer-reply :post="$ticked"/>
                @endif
                @foreach($posts as $post)
                    <x-thread.viewer-reply :post="$post"/>
                @endforeach
                @if($thread->posts->count() > ($thread->tickedPost() ? $posts->count()+1 : $posts->count()))
                <div>
                    <input type='button' class="see-all-full-style" id="viewer-replies-load" value="{{__('View more replies')}}">
                    <input type="hidden" class="button-text-ing" value="{{ __('Loading replies') }}">
                    <input type="hidden" class="button-text-no-ing" value="{{ __('View more replies') }}">
                    <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                </div>
                @endif
            @endif
            </div>
        </div>
    </div>
    <script>
        // $('#viewer-replies-box textarea').each(function() {
        //     var simplemde = new SimpleMDE({
        //         element: this,
        //         placeholder: "{{ __('Edit Your reply') }}",
        //         hideIcons: ["guide", "heading", "link", "image"],
        //         spellChecker: false,
        //         status: false,
        //     });
        //     simplemde.render();
        // });
    </script>
</div>