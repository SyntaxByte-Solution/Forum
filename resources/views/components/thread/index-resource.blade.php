<div class="resource-container thread-container-box relative shadow-contained-box">
    <input type="hidden" class="votable-id" value="{{ $thread->id }}">
    <input type="hidden" class="votable-type" value="thread">
    <input type="hidden" class="likable-id" value="{{ $thread->id }}">
    <input type="hidden" class="likable-type" value="thread">
    <div class="hidden-thread-section none px8 py8">
        <p class="my4 fs12">Thread hidden. If you want to show it again <span class="pointer blue thread-display-button">click here</span></p>
    </div>
    <div class="absolute full-shadowed br6 turn-off-viewer" style="z-index: 1">
        <div class="full-center full-width full-height">
            <div>
                @php
                    $posts_switch = ($thread->replies_off) ? 'on' : 'off';
                    // Here we flip it back because the switch will be used to set the replies_off value
                    // and not an indicator of the state of replies
                    $switch = ($thread->replies_off) ? 0 : 1;
                @endphp
                
                @if($thread->replies_off)
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
    <div class="flex thread-component">
        <div class="thread-vote-section">
            <div class="informer-message-container absolute left100 zi1">
                <div class="left-middle-triangle"></div>
                <div class="flex align-center">
                    <p class="informer-message">{{__("you can't up vote your thread")}}</p>
                    <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                </div>
            </div>
            <div class="pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/up-filled.png') }}" class="small-image vote-up-filled-image @upvoted($thread, 'App\Models\Thread') @else none @endupvoted" alt="">
                <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image vote-up-image @upvoted($thread, 'App\Models\Thread') none @endupvoted" alt="">
            </div>
            <p class="bold fs15 no-margin text-center votable-count">{{ $thread->votevalue }}</p>
            <div class="pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest">
                <img src="{{ asset('assets/images/icons/down-filled.png') }}" class="small-image vote-down-filled-image @downvoted($thread, 'App\Models\Thread') @else none @enddownvoted" alt="">
                <img src="{{ asset('assets/images/icons/down-arrow.png') }}" class="small-image vote-down-image @downvoted($thread, 'App\Models\Thread') none @enddownvoted" alt="">
            </div>
            @if($thread->tickedPost())
            <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="small-image mt8" title="{{ __('This thread has a ticked reply') }}" alt="">
            @endif
        </div>
        <div class="thread-main-section">
            <div class="thread-header-section space-between">
                <div class="flex">
                    <div class="flex">
                        <img src="{{ $thread->user->avatar }}" class="flex size28 rounded mr4" alt="">
                        <div>
                            <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}" class="blue no-underline bold fs13">{{ $thread->user->firstname }} {{ $thread->user->lastname }} - {{ $thread->user->username }}</a>
                            <div class="flex align-center">
                                <div class="relative height-max-content">
                                    <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ $at_hummans }}</p>
                                    <div class="tooltip tooltip-style-1">
                                        {{ $at }}
                                    </div>
                                </div>
                                <div class="gray height-max-content mx4 fs10">•</div>
                                <div class="relative ">
                                    <div class="flex align-center @can('update', $thread) pointer button-with-suboptions thread-status-changer @endcan">
                                        <div class="size12 sprite sprite-2-size public12-icon" title="public"></div>
                                        @can('update', $thread)
                                        <span class="gray fs12" style="margin-top: 1px">▾</span>

                                        @endcan
                                    </div>
                                    @can('update', $thread)
                                    <div class="suboptions-container suboptions-container-right-style" style="left: 0">
                                        <div class="pointer simple-suboption flex align-center thread-status-button">
                                            <div class="size18 sprite sprite-2-size public18-icon mr4"></div>
                                            <div class="fs13">{{ __('Public') }}</div>
                                            <input type="hidden" class="thread-status" value="live">
                                            <div class="loading-dots-anim fs16 bold ml4 none">.</div>
                                        </div>
                                        <div class="pointer simple-suboption flex align-center thread-status-button">
                                            <div class="size18 sprite sprite-2-size followers18-icon mr4"></div>
                                            <div class="fs13">{{ __('Followers Only') }}</div>
                                            <input type="hidden" class="thread-status" value="followers-only">
                                            <div class="loading-dots-anim fs16 bold ml4 none">.</div>
                                        </div>
                                        <div class="pointer simple-suboption flex align-center thread-status-button">
                                            <div class="size18 sprite sprite-2-size private18-icon mr4"></div>
                                            <div class="fs13">{{ __('Only Me') }}</div>
                                            <input type="hidden" class="thread-status" value="only-me">
                                            <div class="loading-dots-anim fs16 bold ml4 none">.</div>
                                        </div>
                                    </div>
                                    @endcan
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
                            @can('update', $thread)
                            <div class="pointer simple-suboption flex align-center">
                                <div class="small-image-2 sprite sprite-2-size pen17-icon mr4"></div>
                                <a href="{{ $edit_link }}" target="_blank" class="no-underline black">{{ __('Edit thread') }}</a>
                            </div>
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
            <div class="thread-content-section">
                <div class="flex align-center">
                    <img src="{{ asset('assets/images/icons/' . $forum->icon) }}" class="small-image-size mr4" alt="">
                    <div class="flex align-center">
                        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                        <span class="mx4 fs13 gray">▸</span>
                        <a href="{{ $category_threads_link }}" class="fs11 black-link">{{ $category->category }}</a>
                    </div>
                </div>
                <div class="my8 expand-box">
                    <span><a href="{{ $thread->link }}" class="expandable-text bold fs18 blue no-underline">{{ $thread->slice }}</a></span>
                    @if($thread->slice != $thread->subject)
                    <input type="hidden" class="expand-slice-text" value="{{ $thread->slice }}">
                    <input type="hidden" class="expand-whole-text" value="{{ $thread->subject }}">
                    <input type="hidden" class="expand-text-state" value="0">
                    <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
                    <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                    @endif
                </div>
                <div class="my4">
                    <span class="expandable-text fs15 no-underline">{{ $thread->contentslice }}</span>
                    @if($thread->content != $thread->contentslice)
                    <input type="hidden" class="expand-slice-text" value="{{ $thread->contentslice }}">
                    <input type="hidden" class="expand-whole-text" value="{{ $thread->content }}">
                    <input type="hidden" class="expand-text-state" value="0">
                    <span class="pointer expand-button fs12 inline-block">{{ __('see all') }}</span>
                    <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                    <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                    @endif
                </div>
            </div>
            <div class="thread-bottom-section space-between">
                <div class="flex align-center">
                    <div class="thread-likes @auth like-resource @endauth @guest login-signin-button @endguest">
                        <div class="small-image-2 sprite sprite-2-size resource17-like-gicon gray-love @if($thread->liked) none @endif"></div>
                        <div class="small-image-2 sprite sprite-2-size resource17-like-ricon red-love @if(!$thread->liked) none @endif"></div>
                        <p class="gray no-margin fs12 resource-likes-counter unselectable ml4">{{ $thread->likes->count() }}</p>
                    </div>
                    <div class="flex align-center">
                        <div class="small-image-2 sprite sprite-2-size replyfilled17-icon mr4"></div>
                        <p class="no-margin unselectable fs12">{{ $replies }} {{__('replies')}}</p>
                    </div>
                </div>
                <div class="flex align-center">
                    <div class="relative mr8">
                        <a href="" class="link-without-underline-style button-with-suboptions copy-container-button" class="block" style="margin: 4px; font-size: 12px">Link ▾</a>
                        <div class="absolute button-simple-container suboptions-container" style="z-index: 1; right: 0">
                            <div class="flex">
                                <input type="text" value="{{ $thread->link }}" class="simple-input" style="width: 240px; padding: 3px; ">
                                <a href="" class="input-button-style flex align-center copy-button">
                                    <div>copy</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex align-center">
                        <div class="@auth thread-report @endauth @guest login-signin-button @endguest pointer small-image-2 sprite sprite-2-size report17-icon mr8"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        
    </div>
</div>