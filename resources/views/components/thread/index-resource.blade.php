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
    <div class="absolute full-shadowed zi12 thread-deletion-viewer br6">
        <a href="" class="close-shadowed-view close-shadowed-view-button" style="top: 6px; right: 6px; width: 30px; height: 30px"></a>
        <div class="white px8 py8 full-height flex flex-column justify-center border-box">
            <h2 class="no-margin fs18">{{ __('Please make sure you want to delete the thread !') }}</h2>
            <div class="my8 mx4 flex space-between">
                <form action="{{ route('thread.delete', ['thread'=>$thread->id]) }}" class="trash-form" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="simple-white-button move-to-trash mr8" value='{{ __("Move to trash") }}'>
                </form>
                <p class="fs12 no-margin" style="width: 75%">{{ __('This will throw the thread to the trash. However you can restore it later by going to your archive to restore it !') }}</p>
            </div>
            <div class="my8 mx4 flex space-between">
                <form action="{{ route('thread.destroy', ['thread'=>$thread->id]) }}" class="delete-permanent-form" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="simple-white-button mr8" value='{{ __("Delete permanently") }}'>
                </form>
                <p class="fs12 no-margin" style="width: 75%">{{ __('This will remove the thread permanently. By removing the thread, everything related to it will be deleted (replies, votes ..)') }}</p>
            </div>
            <div>
                <a href="" class="simple-white-button close-shadowed-view-button move-to-right" style="display: block; text-align: center; width: 60px">Exit</a>
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
                        <div style="width: 32px; height: 32px" class="relative rounded mr4 hidden-overflow has-fade">
                            <div class="fade-loading"></div>
                            <img src="{{ $thread->user->avatar }}" class="thread-owner-avatar flex handle-image-center-positioning" alt="">
                        </div>
                        <div>
                            <div class="flex align-center follow-box">
                                <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}" class="forum-color no-underline bold fs13"><span class="thread-owner-name">{{ $thread->user->fullname }}</span> - <span class="thread-owner-username">{{ $thread->user->username }}</span></a>
                                @if(auth()->user() && $thread->user->id != auth()->user()->id)
                                    <span class="fs10 gray" style="margin: 0 4px 2px 4px">•</span>
                                    <div class="pointer @guest login-signin-button @endguest">

                                        <div class="relative follow-notif-container @if(!$followed) none @endif">
                                            <svg class="button-with-suboptions" style="fill: #1e1e1e; height: 15px; width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                                            <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:max-content">
                                                <div class="pointer follow-resource follow-from-index-resource simple-suboption flex align-center">
                                                    <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M151.17,177.29c50.51,0,91.61-39.76,91.61-88.64S201.68,0,151.17,0,59.55,39.77,59.55,88.65,100.65,177.29,151.17,177.29Zm0-141.83c30.31,0,55,23.86,55,53.19s-24.65,53.18-55,53.18-55-23.86-55-53.18S120.85,35.46,151.17,35.46ZM353.9,206a160.45,160.45,0,0,0-106.62,40.12,155,155,0,0,0-96.11-33.41C67.81,212.75,0,278.37,0,359v17.73H196.86C206,452.78,272.92,512,353.9,512,441.08,512,512,443.37,512,359S441.08,206,353.9,206ZM151.17,248.21a115.66,115.66,0,0,1,72.11,24.71,149,149,0,0,0-26.42,68.37H38.11C46.91,288.59,94.26,248.21,151.17,248.21ZM353.9,476.54c-67,0-121.46-52.72-121.46-117.52S286.92,241.5,353.9,241.5,475.35,294.22,475.35,359,420.87,476.54,353.9,476.54ZM408.66,269,353.9,323.78,299.14,269,263.9,304.26,318.66,359,263.9,413.78,299.14,449l54.76-54.76L408.66,449l35.24-35.24L389.14,359l54.76-54.76Z"/></svg>
                                                    <div class="fs13 btn-txt">{{ __('Unfollow') }}</div>
                                                    <input type="hidden" class="unfollow-text" value="{{ __('Unfollow') }}">
                                                    <input type="hidden" class="unfollowing-text" value="{{ __('Unfollowing') }}..">
                                                    <input type="hidden" class="thread-add-status-slug" value="live">
                                                    <input type="hidden" class="icon-path-when-selected" value="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="@if($followed) none @endif @auth follow-text-button follow-resource follow-from-index-resource @endauth">
                                            <p class="no-margin fs12 bold btn-txt blue unselectable">{{ __('Follow') }}</p>
                                            <input type="hidden" class="follow-text" value="{{ __('Follow') }}">
                                            <input type="hidden" class="following-text" value="{{ __('Following') }}..">
                                            <input type="hidden" class="follow-success-text" value="{{ __('Follow success !') }}">
                                        </div>
                                        <input type="hidden" class="followable-id" value="{{ $thread->user->id }}">
                                        <input type="hidden" class="followable-type" value="user">
                                        @php
                                            $state = ($followed) ? 1 : -1;
                                        @endphp
                                        <input type="hidden" class="status" value="{{ $state }}">
                                    </div>
                                @endif
                            </div>
                            <div class="flex align-center" style="margin-top: 1px">
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
                                            <svg class="size14 thread-resource-status-icon" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                {!! $thread->status->icon !!}
                                            </svg>
                                            @can('update', $thread)
                                            <span class="gray fs12" style="margin-top: 1px">▾</span>
                                            @endcan
                                        </div>
                                        @can('update', $thread)
                                        <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:156px">
                                            <div class="pointer simple-suboption flex align-center thread-status-button">
                                                <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z"/></svg>
                                                <div class="fs13">{{ __('Public') }}</div>
                                                <input type="hidden" class="thread-add-status-slug" value="live">
                                                <input type="hidden" class="icon-path-when-selected" value="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z">
                                                <div class="loading-dots-anim ml4 none">•</div>
                                            </div>
                                            <div class="pointer simple-suboption flex align-center thread-status-button">
                                                <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z"/></svg>
                                                <div class="fs13">{{ __('Followers Only') }}</div>
                                                <input type="hidden" class="thread-add-status-slug" value="followers-only">
                                                <input type="hidden" class="icon-path-when-selected" value="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z">
                                                <div class="loading-dots-anim ml4 none">•</div>
                                            </div>
                                            <div class="pointer simple-suboption flex align-center thread-status-button">
                                                <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z"/></svg>
                                                <div class="fs13">{{ __('Only Me') }}</div>
                                                <input type="hidden" class="thread-add-status-slug" value="only-me">
                                                <input type="hidden" class="icon-path-when-selected" value="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z">
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
                        <svg class="mr4 size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><path class="cls-1" d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                        <p class="no-margin fs12 unselectable" style="margin-top: 1px">{{ $views }}</p>
                    </div>
                    <div class="relative">
                        <svg class="pointer button-with-suboptions size20 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
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
                    <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        {!! $forum->icon !!}
                    </svg>
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
                        <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448,0H64A64.06,64.06,0,0,0,0,64V352a64.06,64.06,0,0,0,64,64h96v84a12,12,0,0,0,12,12,11.48,11.48,0,0,0,7.1-2.4L304,416H448a64.06,64.06,0,0,0,64-64V64A64.06,64.06,0,0,0,448,0Zm16,352a16,16,0,0,1-16,16H288l-12.8,9.6L208,428V368H64a16,16,0,0,1-16-16V64A16,16,0,0,1,64,48H448a16,16,0,0,1,16,16Z"/></svg>
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
                            <svg class="size17 mr4" style="fill: #1d1d1d" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
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