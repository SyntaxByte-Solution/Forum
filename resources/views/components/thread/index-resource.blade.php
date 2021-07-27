<div class="resource-container thread-container-box relative shadow-contained-box">
    <div class="hidden-thread-section none px8 py8">
        <p class="my4 fs12">Thread hidden. If you want to show it again <span class="pointer blue thread-display-button">click here</span></p>
    </div>
    @can('update', $thread)
    <div class="absolute full-shadowed br6 turn-off-viewer" style="z-index: 1">
        <div class="full-center full-width full-height">
            <div>
                @php
                    $posts_switch = ($thread->replies_off) ? 'on' : 'off';
                    // Here we flip it back because the switch will be used to set the replies_off value
                    // and not an indicator of the state of replies
                    $switch = ($thread->replies_off) ? 0 : 1;
                @endphp
                
                @if(!$thread->replies_off)
                <p class="white bold fs15 my4">{{ __('Important: If you turn off replies, no one could reply to your tread') }}.</p>
                <p class="white fs15 mt4 mb8">{{ __('However if there are already some replies, they will not disappeared.') }}</p>
                @else
                <p class="white bold fs15 my8">{{ __('Turn on replies on this thread') }}.</p>
                @endif
                <div class="full-center">
                    <input type="button" class="simple-white-button pointer turn-off-posts fs13" value="Turn {{ $posts_switch }} replies">
                    <a href="" class="simple-link close-shadowed-view-button fs14" style="text-decoration: none; margin-left: 6px;">cancel</a>
                    <input type="hidden" class="id" value="{{ $thread->id }}">
                    <input type="hidden" class="switch" value="{{ $switch }}">
                </div>
            </div>
        </div>
    </div>
    <div class="fixed full-shadowed zi12 thread-deletion-viewer">
        <a href="" class="close-shadowed-view close-shadowed-view-button"></a>
        <div class="shadowed-view-section-style">
            <h2>{{ __('Please make sure you want to delete the thread !') }}</h2>
            <div class="flex">
                <div class="half-width my8 mx4">
                    <form action="{{ route('thread.delete', ['thread'=>$thread->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="button-style mr8" value='DELETE'>
                    </form>
                    <p class="fs12">{{ __('This will throw the thread to the trash. However It will not be deleted completely, you can restore it later if you want by going to your archive and select the thread to restore it !') }}</p>
                </div>
                <div class="half-width my8 mx4">
                    <form action="{{ route('thread.destroy', ['thread'=>$thread->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="button-style mr8" value='FORCE DELETE'>
                    </form>
                    <p class="fs12">{{ __('This will remove the thread completely from our system. If you choose this option the thread will be removed permanently as well as all related replies') }}</p>
                </div>
            </div>
            <div>
                <a href="" class="button-style close-shadowed-view-button move-to-right" style="display: block; text-align: center; width: 60px">Exit</a>
            </div>
        </div>
    </div>
    @endcan
    <div class="flex thread-component">
        <div class="thread-vote-section vote-box">
            <input type="hidden" class="votable-type" value="thread">
            <input type="hidden" class="votable-id" value="{{ $thread->id }}">
            <div class="informer-message-container absolute left100 zi1">
                <div class="left-middle-triangle"></div>
                <div class="flex align-center">
                    <p class="informer-message"></p>
                    <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                </div>
            </div>
            <div class="pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest">
                <div class="small-image sprite sprite-2-size vote-icon @upvoted($thread, 'App\Models\Thread') upvotefilled20-icon @else upvote20-icon @endupvoted"></div>
            </div>
            <p class="bold fs15 no-margin text-center votable-count">{{ $thread->votevalue }}</p>
            <div class="pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest">
                <div class="small-image sprite sprite-2-size vote-icon @downvoted($thread, 'App\Models\Thread') downvotefilled20-icon @else downvote20-icon @enddownvoted"></div>
            </div>
            @if($thread->tickedPost())
            <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="small-image mt8" title="{{ __('This thread has a ticked reply') }}" alt="">
            @endif
        </div>
        <div class="thread-main-section">
            <!-- thread header section -->
            <div class="thread-header-section space-between">
                <div class="flex">
                    <div class="flex">
                        <div style="width: 32px; height: 32px" class="rounded mr4 hidden-overflow">
                            <img src="{{ $thread->user->avatar }}" class="thread-owner-avatar flex handle-image-center-positioning" alt="">
                        </div>
                        <div>
                            <div class="flex align-center follow-box">
                                <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}" class="forum-color no-underline bold fs13"><span class="thread-owner-name">{{ $thread->user->fullname }}</span> - <span class="thread-owner-username">{{ $thread->user->username }}</span></a>
                                @if(auth()->user() && $thread->user->id != auth()->user()->id)
                                    <span class="fs10 gray" style="margin: 0 4px 2px 4px">•</span>
                                    <div class="pointer @auth follow-resource @endauth @guest login-signin-button @endguest">
                                        @if($followed)
                                        <input type="hidden" class="status" value="1">
                                        <p class="no-margin fs12 bold btn-txt gray unselectable">{{ __('Followed') }}</p>
                                        @else
                                        <p class="no-margin fs12 bold btn-txt blue unselectable">{{ __('Follow') }}</p>
                                        <input type="hidden" class="status" value="-1">
                                        @endif
                                        <input type="hidden" class="follow-text" value="{{ __('Follow') }}">
                                        <input type="hidden" class="following-text" value="{{ __('Following ..') }}">
                                        <input type="hidden" class="followed-text" value="{{ __('Followed') }}">
                                        <input type="hidden" class="unfollowing-text" value="{{ __('Unfollowing ..') }}">
                                        <input type="hidden" class="followable-id" value="{{ $thread->user->id }}">
                                        <input type="hidden" class="followable-type" value="user">
                                    </div>
                                @endif
                            </div>
                            <div class="flex align-center">
                                <div class="relative height-max-content">
                                    <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ $at_hummans }}</p>
                                    <div class="tooltip tooltip-style-1">
                                        {{ $at }}
                                    </div>
                                </div>
                                <div class="gray height-max-content mx4 fs10">•</div>
                                <div class="status-box">
                                    <div class="relative ">
                                        <div class="flex align-center @can('update', $thread) pointer button-with-suboptions thread-status-changer @endcan">
                                            @php
                                                $icon;
                                                $alt = $thread->status->status;
                                                if($thread->status_id == 1) {
                                                    $icon = "public14-icon";
                                                } else if($thread->status_id == 2) {
                                                    $icon = "closed14-icon";
                                                } else if($thread->status_id == 3) {
                                                    $icon = "followers14-icon";
                                                } else if($thread->status_id == 4) {
                                                    $icon = "private14-icon";
                                                }
                                            @endphp
                                            <div class="size14 sprite sprite-2-size thread-status-button-14icon {{ $icon }}" title="{{ $alt }}"></div>
                                            @can('update', $thread)
                                            <span class="gray fs12" style="margin-top: 1px">▾</span>

                                            @endcan
                                        </div>
                                        @can('update', $thread)
                                        <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:156px">
                                            <div class="pointer simple-suboption flex align-center thread-status-button">
                                                <div class="size18 sprite sprite-2-size public18-icon mr4"></div>
                                                <div class="fs13">{{ __('Public') }}</div>
                                                <input type="hidden" class="thread-add-status-slug" value="live">
                                                <input type="hidden" class="icon-when-selected" value="public14-icon">
                                                <div class="loading-dots-anim ml4 none">•</div>
                                            </div>
                                            <div class="pointer simple-suboption flex align-center thread-status-button">
                                                <div class="size18 sprite sprite-2-size followers18-icon mr4"></div>
                                                <div class="fs13">{{ __('Followers Only') }}</div>
                                                <input type="hidden" class="thread-add-status-slug" value="followers-only">
                                                <input type="hidden" class="icon-when-selected" value="followers14-icon">
                                                <div class="loading-dots-anim ml4 none">•</div>
                                            </div>
                                            <div class="pointer simple-suboption flex align-center thread-status-button">
                                                <div class="size18 sprite sprite-2-size private18-icon mr4"></div>
                                                <div class="fs13">{{ __('Only Me') }}</div>
                                                <input type="hidden" class="thread-add-status-slug" value="only-me">
                                                <input type="hidden" class="icon-when-selected" value="private14-icon">
                                                <div class="loading-dots-anim ml4 none">•</div>
                                            </div>
                                            <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex align-center">
                    <div class="thread-views mr8 flex align-center">
                        <div class="small-image-2 sprite sprite-2-size eye17-icon mr4"></div>
                        <p class="no-margin fs12 unselectable">{{ $views }}</p>
                    </div>
                    <div class="relative">
                        <div class="pointer button-with-suboptions size20 sprite sprite-2-size menu20-icon mr4"></div>
                        <div class="suboptions-container suboptions-container-right-style">
                            @can('save', $thread)
                            <div class="pointer simple-suboption save-thread flex align-center">
                                <div class="small-image-2 sprite sprite-2-size icon @if($thread->is_saved) xbookmark17-icon @else bookmark17-icon @endif mr4"></div>
                                <div class="button-text">
                                    @if($thread->is_saved)
                                        {{ __('Unsave thread') }}
                                    @else
                                        {{ __('Save thread') }}
                                    @endif
                                </div>
                                <div style="width: 12px">
                                    <div class="loading-dots-anim ml4 none">•</div>
                                </div>
                                <input type="hidden" class="status" value="@if($thread->is_saved) unsave @else save @endif">
                                <input type="hidden" class="button-text-save" value="{{ __('Save thread') }}">
                                <input type="hidden" class="button-text-unsave" value="{{ __('Unsave thread') }}">
                                <input type="hidden" class="saved-message" value="{{ __('Thread saved successfully.') }}">
                                <input type="hidden" class="unsaved-message" value="{{ __('Thread unsaved successfully.') }}">
                            </div>
                            @endcan
                            @can('update', $thread)
                            <a href="{{ $edit_link }}" target="_blank" class="no-underline simple-suboption flex align-center">
                                <div class="small-image-2 sprite sprite-2-size pen17-icon mr4"></div>
                                <div class="black">{{ __('Edit thread') }}</div>
                            </a>
                            <div class="pointer simple-suboption flex align-center action-verification">
                                <div class="small-image-2 sprite sprite-2-size delete17b-icon mr4"></div>
                                <div class="no-underline black">{{ __('Delete thread') }}</div>
                                <input type="hidden" value="thread.destroy" class="verification-action-type">
                            </div>
                            <div class="simple-suboption flex align-center action-verification">
                                <div class="pointer action-verification small-image-2 sprite sprite-2-size @if($posts_switch == 'off') repliesoff17-icon @else reply17-icon @endif mr4"></div>
                                <div>{{ __('Turn ' . $posts_switch .  ' replies') }}</div>
                                <input type="hidden" value="turn.off.posts" class="verification-action-type">
                            </div>
                            @endcan
                            <div class="pointer simple-suboption thread-display-button flex align-center">
                                <div class="small-image-2 sprite sprite-2-size eyecrossed17-icon mr4"></div>
                                <div>{{ __('Hide thread') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- thread main content -->
            <div class="thread-content-section">
                <!-- thread content: header FORUM->category -->
                <div class="flex align-center">
                    <img src="{{ asset('assets/images/icons/' . $forum->icon) }}" class="small-image-size mr4" alt="" loading="lazy">
                    <div class="flex align-center">
                        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                        <span class="mx4 fs13 gray">▸</span>
                        <a href="{{ $category_threads_link }}" class="fs11 black-link">{{ $category->category }}</a>
                    </div>
                </div>
                <div class="my8 expand-box">
                    <span><a href="{{ $thread->link }}" class="expandable-text bold fs18 blue no-underline">{{ $thread->mediumslice }}</a></span>
                    @if($thread->mediumslice != $thread->subject)
                    <input type="hidden" class="expand-slice-text" value="{{ $thread->mediumslice }}">
                    <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
                    <input type="hidden" class="expand-text-state" value="0">
                    <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
                    <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                    @endif
                </div>
                <div class="my4 expand-box">
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
                @if($thread->has_media)
                <!-- thread media -->
                <div class="thread-medias-container">
                    <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                    @php
                        $media_count = 0;
                    @endphp
                    @foreach($medias as $media)
                        @if($media['type'] == 'image')
                        <div class="thread-media-container open-thread-image relative pointer has-fade">
                            <div class="thread-image-options">
                                <p class="white"></p>
                            </div>
                            <div class="thread-image-zoomer-container">

                            </div>
                            <div class="fade-loading"></div>
                            <img src="{{ asset($media['frame']) }}" alt="" class="thread-media image-that-fade-wait">
                            <div class="full-shadow-stretched none">
                                <p class="fs26 bold white unselectable">+<span class="thread-media-more-counter"></span></p>
                            </div>
                            <input type="hidden" class="media-type" value="{{ $media['type'] }}">
                            <input type="hidden" class="media-count" value="{{ $media_count }}">
                        </div>
                        @elseif($media['type'] == 'video')
                        <div class="thread-media-container relative" style="background-color: #0f0f0f">
                            <div class="thread-media-options full-center">
                                @if($thread->has_media)
                                <svg class="size17 pointer open-thread-image" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0,180V56A23.94,23.94,0,0,1,24,32H148a12,12,0,0,1,12,12V84a12,12,0,0,1-12,12H64v84a12,12,0,0,1-12,12H12A12,12,0,0,1,0,180ZM288,44V84a12,12,0,0,0,12,12h84v84a12,12,0,0,0,12,12h40a12,12,0,0,0,12-12V56a23.94,23.94,0,0,0-24-24H300A12,12,0,0,0,288,44ZM436,320H396a12,12,0,0,0-12,12v84H300a12,12,0,0,0-12,12v40a12,12,0,0,0,12,12H424a23.94,23.94,0,0,0,24-24V332A12,12,0,0,0,436,320ZM160,468V428a12,12,0,0,0-12-12H64V332a12,12,0,0,0-12-12H12A12,12,0,0,0,0,332V456a23.94,23.94,0,0,0,24,24H148A12,12,0,0,0,160,468Z"/></svg>
                                @endif
                            </div>
                            <video class="full-width full-height" controls>
                                <source src="{{ asset($media['frame']) }}" type="video/mp4">
                                <source src="{{ asset($media['frame']) }}" type="video/ogg">
                                <source src="{{ asset($media['frame']) }}" type="video/mp4">
                                <source src="{{ asset($media['frame']) }}" type="video/avi">
                                <source src="{{ asset($media['frame']) }}" type="video/ogg">
                                <source src="{{ asset($media['frame']) }}" type="video/webm">
                                <source src="{{ asset($media['frame']) }}" type="video/mp">
                                <source src="{{ asset($media['frame']) }}" type="video/mp2">
                                <source src="{{ asset($media['frame']) }}" type="video/mpeg">
                                <source src="{{ asset($media['frame']) }}" type="video/mpv">
                                <source src="{{ asset($media['frame']) }}" type="video/m4p">
                                Your browser does not support HTML video.
                            </video>
                            <div class="full-shadow-stretched none">
                                <p class="fs26 bold white unselectable">+<span class="thread-media-more-counter"></span></p>
                            </div>
                            <input type="hidden" class="media-type" value="{{ $media['type'] }}">
                            <input type="hidden" class="media-count" value="{{ $media_count }}">
                        </div>
                        @endif
                        @php
                            $media_count++;
                        @endphp
                    @endforeach
                </div>
                @endif
            </div>
            <div class="thread-bottom-section space-between">
                <div class="flex align-center">
                    <div class="thread-react-hover @auth like-resource like-resource-from-outside-viewer @endauth @guest login-signin-button @endguest">
                        <input type="hidden" class="likable-id" value="{{ $thread->id }}">
                        <input type="hidden" class="likable-type" value="thread">
                        <div class="small-image-2 sprite sprite-2-size like-icon @if($thread->liked) resource17-like-ricon @else resource17-like-gicon @endif"></div>
                        <p class="gray no-margin fs12 resource-likes-counter unselectable ml4">{{ $thread->likes->count() }}</p>
                    </div>
                    <div class="thread-react-hover move-to-thread-replies flex align-center no-underline">
                        <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                        <div class="small-image-2 sprite sprite-2-size replyfilled17-icon mr4"></div>
                        <p class="no-margin unselectable fs12"><span class="thread-replies-counter">{{ $replies }}</span> {{__('replies')}}</p>
                    </div>
                </div>
                <div class="flex align-center">
                    <div class="relative mr8">
                        <a href="" class="link-without-underline-style button-with-suboptions copy-container-button" class="block" style="margin: 4px; font-size: 12px">Link ▾</a>
                        <div class="absolute button-simple-container suboptions-container" style="z-index: 1;right: 0;">
                            <div class="flex">
                                <input type="text" value="{{ $thread->link }}" class="simple-input" style="width: 240px; padding: 3px; ">
                                <a href="" class="input-button-style flex align-center copy-button">
                                    <div>copy</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex align-center">
                        <div class="none open-thread-report @guest login-signin-button @endguest thread-react-hover">
                            <div class="small-image-2 sprite sprite-2-size report17filled-icon mr4"></div>
                            <div class="fs13">report</div>
                            <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                        </div>
                        <script>
                            // Here we need to only report thread from thread show page
                            if($('.page').first().val() == 'thread-show') {
                                $('.open-thread-report').removeClass('none');
                                @guest
                                $('.open-thread-report').removeClass('open-thread-report');
                                @endguest
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>