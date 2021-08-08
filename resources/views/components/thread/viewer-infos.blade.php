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
                <div class="informer-message-container absolute zi1" style="left: -1px; bottom: calc(100% + 2px)">
                    <div class="flex align-center">
                        <p class="informer-message"></p>
                        <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                    </div>
                </div>

                <div class="flex align-center mx4 pr8" style="border-right: 1px solid #c1c1c1">
                    <input type="hidden" class="votable-type" value="thread">
                    <input type="hidden" class="votable-id" value="{{ $thread->id }}">
                    <svg class="size15 pointer @auth votable-up-vote inside-viewer @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                        <title>{{ __('UP') }}</title>
                        <path class="up-vote-filled @unlessupvoted($thread, 'App\Models\Thread') none @endupvoted" d="M63.89,55.78v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58H68.21a7.56,7.56,0,0,0,7.53-7.58V55.78ZM97.8,53.5,57.85,7.29A10.28,10.28,0,0,0,50,3.92a10.25,10.25,0,0,0-7.87,3.37L2.23,53.52A6.9,6.9,0,0,0,1,61.14c1.46,3.19,5,5.25,9.09,5.25h14V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53a1.61,1.61,0,0,1,.26,1.75,1.83,1.83,0,0,1-1.67,1H75.74v10.6H89.88c4.05,0,7.61-2.06,9.08-5.24A6.92,6.92,0,0,0,97.8,53.5Zm-16,1.24a1.83,1.83,0,0,1-1.67,1H63.89v28.3h-28V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53A1.61,1.61,0,0,1,81.83,54.74Z" style="fill:#28b1e7"/>
                        <path class="up-vote @upvoted($thread, 'App\Models\Thread') none @endupvoted" d="M10.11,66.39c-4.06,0-7.63-2.06-9.09-5.25a6.9,6.9,0,0,1,1.21-7.62L42.11,7.29A10.25,10.25,0,0,1,50,3.92a10.28,10.28,0,0,1,7.87,3.37L97.8,53.5A6.92,6.92,0,0,1,99,61.13c-1.47,3.18-5,5.24-9.08,5.24H75.74V55.77h4.42a1.83,1.83,0,0,0,1.67-1A1.61,1.61,0,0,0,81.57,53L51.39,18A1.9,1.9,0,0,0,48.61,18L18.42,53a1.61,1.61,0,0,0-.26,1.75,1.83,1.83,0,0,0,1.67,1h4.26V66.39Zm58.1,29.69a7.56,7.56,0,0,0,7.53-7.58V55.78H63.89v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58Z" style="fill:#1c1c1c"/>
                    </svg>
    
                    <p class="bold text-center votable-count no-margin mx8" style="color: #1c1c1c">{{ $thread->votevalue }}</p>
    
                    <svg class="size15 pointer @auth votable-down-vote inside-viewer @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                        <title>{{ __('DOWN') }}</title>
                        <path class="down-vote-filled @unlessdownvoted($thread, 'App\Models\Thread') none @enddownvoted" d="M63.89,44.22V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58H68.21a7.56,7.56,0,0,1,7.53,7.58V44.22ZM97.8,46.5,57.85,92.71A10.28,10.28,0,0,1,50,96.08a10.25,10.25,0,0,1-7.87-3.37L2.23,46.48A6.9,6.9,0,0,1,1,38.86c1.46-3.19,5-5.25,9.09-5.25h14V44.22H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47a1.61,1.61,0,0,0,.26-1.75,1.83,1.83,0,0,0-1.67-1H75.74V33.63H89.88c4.05,0,7.61,2.06,9.08,5.24A6.92,6.92,0,0,1,97.8,46.5Zm-16-1.24a1.83,1.83,0,0,0-1.67-1H63.89V15.92h-28v28.3H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47A1.61,1.61,0,0,0,81.83,45.26Z" style="fill:#28b1e7"/>
                        <path class="down-vote @downvoted($thread, 'App\Models\Thread') none @enddownvoted" d="M10.11,33.61c-4.06,0-7.63,2.06-9.09,5.25a6.9,6.9,0,0,0,1.21,7.62L42.11,92.71A10.25,10.25,0,0,0,50,96.08a10.28,10.28,0,0,0,7.87-3.37L97.8,46.5A6.92,6.92,0,0,0,99,38.87c-1.47-3.18-5-5.24-9.08-5.24H75.74v10.6h4.42a1.83,1.83,0,0,1,1.67,1A1.61,1.61,0,0,1,81.57,47L51.39,82a1.9,1.9,0,0,1-2.78,0L18.42,47a1.61,1.61,0,0,1-.26-1.75,1.83,1.83,0,0,1,1.67-1h4.26V33.61ZM68.21,3.92a7.56,7.56,0,0,1,7.53,7.58V44.22H63.89V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58Z" style="fill:#1c1c1c"/>
                    </svg>
                </div>

            </div>
            <div class="thread-react-hover @auth like-resource viewer-thread-like like-resource-from-viewer @endauth @guest login-signin-button @endguest">
                <input type="hidden" class="likable-type" value="thread">
                <input type="hidden" class="likable-id" value="{{ $thread->id }}">
                <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                    <path class="red-like @if(!$thread->liked) none @endif" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                    <path class="grey-like @if($thread->liked) none @endif" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                </svg>
                <p class="gray no-margin fs12 resource-likes-counter unselectable ml4">{{ $thread->likes->count() }}</p>
            </div>
            <div class="thread-react-hover @auth move-to-thread-viewer-reply @endauth flex align-center">
                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" fill="#1c1c1c" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                <p class="no-margin unselectable fs12"><span class="viewer-thread-replies-number">{{ $thread->posts->count() }}</span> {{__('replies')}}</p>
            </div>
            <div class="flex align-center move-to-right mr4">
                <svg class="mr4 size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
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
                    hideIcons: ["guide", "link", "image"],
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