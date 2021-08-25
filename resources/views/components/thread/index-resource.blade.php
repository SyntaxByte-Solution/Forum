<div class="resource-container thread-container-box relative shadow-contained-box">
    <div class="hidden-thread-section none px8 py8">
        <p class="my4 fs12">Thread hidden. If you want to show it again <span class="pointer blue thread-display-button">click here</span></p>
    </div>
    @can('update', $thread)
    <div class="absolute full-shadowed br6 turn-off-posts-viewer" style="z-index: 1">
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
                <p class="white fs15 mt4 mb8">{{ __('However if there are already some replies, they will not disappeared') }}.</p>
                @else
                <p class="white bold fs15 my8">{{ __('Turn on replies on this thread') }}.</p>
                @endif
                <div class="full-center">
                    <input type="button" class="simple-white-button pointer turn-off-posts fs13" value="Turn {{ $posts_switch }} replies">
                    <div class="pointer white close-shadowed-view-button fs14" style="text-decoration: none; margin-left: 6px;">{{ __('cancel') }}</div>
                    <input type="hidden" class="id" value="{{ $thread->id }}">
                    <input type="hidden" class="switch" value="{{ $switch }}">
                    <input type="hidden" class="button-text-ing" value="{{ __('Please wait') }}..">
                </div>
            </div>
        </div>
    </div>
    <div class="absolute full-shadowed zi12 thread-deletion-viewer br6">
        <svg class="size14 simple-button-style rounded hide-parent" style="position: absolute; top: 6px; right: 6px" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"/></svg>
        <div class="white px8 py8 full-height flex flex-column justify-center border-box">
            <h2 class="no-margin fs18 text-center">{{ __('Please make sure you want to delete the thread !') }}</h2>
            <p class="fs12 no-margin text-center">{{ __('This will throw the thread to the archive in case you decide to restore It. You can either restore it or delete it permanently later by going to your activities -> archive !') }}</p>
            
            <div class="full-center mt8">
                <div class="simple-white-button move-to-trash-button align-center" style="display: flex">
                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                    <div class="btn-text">{{ __('Move to trash') }}</div>
                    <input type="hidden" class="trash-move-link" value="{{ route('thread.delete', ['thread'=>$thread->id]) }}">
                    <input type="hidden" class="btn-text-no-ing" value="{{ __('Move to trash') }}">
                    <input type="hidden" class="btn-text-ing" value="{{ __('Moving to trash') }}..">
                </div>
                <div class="spinner size17 ml4 opacity0">
                    <svg class="size17" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                </div>
            </div>
            
        </div>
    </div>
    @endcan
    <div class="flex thread-component">
        <div class="thread-vote-section">
            <div class="vote-box full-center flex-column relative">
                <input type="hidden" class="votable-type" value="thread">
                <input type="hidden" class="votable-id" value="{{ $thread->id }}">
                <div class="informer-message-container absolute zi1">
                    <div class="absolute full-height full-center left0 top0">
                        <div class="left-middle-triangle"></div>
                    </div>
                    <div class="flex align-center">
                        <p class="informer-message"></p>
                        <div class="remove-informer-message-container rounded pointer">
                            <span style="margin-top: -1px">✖</span>
                        </div>
                    </div>
                </div>

                <svg class="size15 pointer @auth votable-up-vote outside-viewer @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <title>{{ __('UP') }}</title>
                    <path class="up-vote-filled @unlessupvoted($thread, 'App\Models\Thread') none @endupvoted" d="M63.89,55.78v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58H68.21a7.56,7.56,0,0,0,7.53-7.58V55.78ZM97.8,53.5,57.85,7.29A10.28,10.28,0,0,0,50,3.92a10.25,10.25,0,0,0-7.87,3.37L2.23,53.52A6.9,6.9,0,0,0,1,61.14c1.46,3.19,5,5.25,9.09,5.25h14V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53a1.61,1.61,0,0,1,.26,1.75,1.83,1.83,0,0,1-1.67,1H75.74v10.6H89.88c4.05,0,7.61-2.06,9.08-5.24A6.92,6.92,0,0,0,97.8,53.5Zm-16,1.24a1.83,1.83,0,0,1-1.67,1H63.89v28.3h-28V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53A1.61,1.61,0,0,1,81.83,54.74Z" style="fill:#28b1e7"/>
                    <path class="up-vote @upvoted($thread, 'App\Models\Thread') none @endupvoted" d="M10.11,66.39c-4.06,0-7.63-2.06-9.09-5.25a6.9,6.9,0,0,1,1.21-7.62L42.11,7.29A10.25,10.25,0,0,1,50,3.92a10.28,10.28,0,0,1,7.87,3.37L97.8,53.5A6.92,6.92,0,0,1,99,61.13c-1.47,3.18-5,5.24-9.08,5.24H75.74V55.77h4.42a1.83,1.83,0,0,0,1.67-1A1.61,1.61,0,0,0,81.57,53L51.39,18A1.9,1.9,0,0,0,48.61,18L18.42,53a1.61,1.61,0,0,0-.26,1.75,1.83,1.83,0,0,0,1.67,1h4.26V66.39Zm58.1,29.69a7.56,7.56,0,0,0,7.53-7.58V55.78H63.89v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58Z" style="fill:#010202"/>
                </svg>

                <p class="bold fs15 text-center votable-count" style="margin: 1px 0 2px 0">{{ $thread->votevalue }}</p>

                <svg class="size15 pointer @auth votable-down-vote outside-viewer @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                    <title>{{ __('DOWN') }}</title>
                    <path class="down-vote-filled @unlessdownvoted($thread, 'App\Models\Thread') none @enddownvoted" d="M63.89,44.22V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58H68.21a7.56,7.56,0,0,1,7.53,7.58V44.22ZM97.8,46.5,57.85,92.71A10.28,10.28,0,0,1,50,96.08a10.25,10.25,0,0,1-7.87-3.37L2.23,46.48A6.9,6.9,0,0,1,1,38.86c1.46-3.19,5-5.25,9.09-5.25h14V44.22H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47a1.61,1.61,0,0,0,.26-1.75,1.83,1.83,0,0,0-1.67-1H75.74V33.63H89.88c4.05,0,7.61,2.06,9.08,5.24A6.92,6.92,0,0,1,97.8,46.5Zm-16-1.24a1.83,1.83,0,0,0-1.67-1H63.89V15.92h-28v28.3H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47A1.61,1.61,0,0,0,81.83,45.26Z" style="fill:#28b1e7"/>
                    <path class="down-vote @downvoted($thread, 'App\Models\Thread') none @enddownvoted" d="M10.11,33.61c-4.06,0-7.63,2.06-9.09,5.25a6.9,6.9,0,0,0,1.21,7.62L42.11,92.71A10.25,10.25,0,0,0,50,96.08a10.28,10.28,0,0,0,7.87-3.37L97.8,46.5A6.92,6.92,0,0,0,99,38.87c-1.47-3.18-5-5.24-9.08-5.24H75.74v10.6h4.42a1.83,1.83,0,0,1,1.67,1A1.61,1.61,0,0,1,81.57,47L51.39,82a1.9,1.9,0,0,1-2.78,0L18.42,47a1.61,1.61,0,0,1-.26-1.75,1.83,1.83,0,0,1,1.67-1h4.26V33.61ZM68.21,3.92a7.56,7.56,0,0,1,7.53,7.58V44.22H63.89V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58Z" style="fill:#010202"/>
                </svg>

            </div>
            <div class="@if(!$thread->tickedPost()) none @endif thread-component-tick" title="{{ __('This thread has a ticked reply') }}">
                <svg class="size20 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
            </div>
        </div>
        <div class="thread-main-section">
            <!-- thread header section -->
            <div class="thread-header-section space-between">
                <div class="flex">
                    <div class="flex">
                        <div class="size36 relative rounded mr4 hidden-overflow has-lazy">
                            <div class="fade-loading"></div>
                            <img data-src="{{ $thread->user->sizedavatar(36, '-l') }}" class="thread-owner-avatar size36 flex lazy-image image-with-fade" alt="">
                        </div>
                        <div>
                            <div class="flex align-center" style="height: 18px">
                                <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}" class="forum-color no-underline bold fs13"><span class="thread-owner-name">{{ $thread->user->fullname }}</span> - <span class="thread-owner-username">{{ $thread->user->username }}</span></a>
                                @if(auth()->user() && $thread->user->id != auth()->user()->id)
                                <div class="follow-box thread-component-follow-box flex align-center">
                                    <!-- buttons labels -->
                                    <input type="hidden" class="follow-text" autocomplete="off" value="{{ __('Follow') }}">
                                    <input type="hidden" class="following-text" autocomplete="off" value="{{ __('Following') }}..">
                                    <input type="hidden" class="unfollow-text" autocomplete="off" value="{{ __('Unfollow') }}">
                                    <input type="hidden" class="unfollowing-text" autocomplete="off" value="{{ __('Unfollowing') }}..">
                                    <input type="hidden" class="follow-success-text" autocomplete="off" value="{{ __('Follow success !') }}">
                                    <span class="fs10 gray" style="margin: 0 4px 2px 4px">•</span>
                                    <div class="pointer @guest login-signin-button @endguest">
                                        <div class="size14 relative follow-notif-container @if(!$followed) none @endif">
                                            <svg class="size14 button-with-suboptions" style="fill: #1e1e1e;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                                            <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:max-content">
                                                <div class="pointer follow-resource follow-button-toggle-with-bell simple-suboption flex align-center">
                                                    <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path d="M234,147.1h0a87.1,87.1,0,1,0,87.1,87.11A87.12,87.12,0,0,0,234,147.1Zm0,130.65a43.55,43.55,0,1,1,0-87.1h0a43.55,43.55,0,0,1,0,87.1Zm224.55-7.07a9.77,9.77,0,0,0-6.3-8.52,156.94,156.94,0,0,0-26.41-7.34,9.79,9.79,0,0,0-11.36,7.94,9.46,9.46,0,0,0-.09,2.81,180.26,180.26,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.17,180.17,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.22-9.36,9.94,9.94,0,0,0-.09-1.81A157.76,157.76,0,0,0,246.4,66.9a9.83,9.83,0,0,0-9.16-6.9h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.37,221.37,0,0,0,168-167.67A235,235,0,0,0,458.56,270.68ZM234,466.45a180.41,180.41,0,0,1-118-43.91,78.14,78.14,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.38,78.38,0,0,1,352,422.54,180.41,180.41,0,0,1,234,466.45ZM444.34,98,510.8,31.53a4.07,4.07,0,0,0,0-5.77L486.25,1.2a4.08,4.08,0,0,0-5.78,0L414,67.66,347.54,1.2a4.19,4.19,0,0,0-5.78,0L317.2,25.76a4.09,4.09,0,0,0,0,5.77L383.67,98,317.2,164.46a4.1,4.1,0,0,0,0,5.78l24.56,24.56a4.08,4.08,0,0,0,5.78,0L414,128.33l66.47,66.47a4.08,4.08,0,0,0,5.78,0l24.55-24.56a4.08,4.08,0,0,0,0-5.78Z"/>
                                                    </svg>
                                                        
                                                    <div class="fs13 btn-txt">{{ __('Unfollow') }}</div>
                                                    <input type="hidden" class="icon-path-when-selected" value="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z">
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $state = $followed == true ? 1 : -1;
                                        @endphp
                                        <div class="@if($followed) none @endif @auth follow-text-button follow-resource follow-button-toggle-with-bell @endauth">
                                            <p class="no-margin fs12 bold btn-txt blue unselectable">{{ __('Follow') }}</p>
                                        </div>
                                        <input type="hidden" class="thread-add-visibility-slug" value="public">
                                        <input type="hidden" class="followable-id" value="{{ $thread->user->id }}">
                                        <input type="hidden" class="followable-type" value="user">
                                        <input type="hidden" class="status" autocomplete="off" value="{{ $state }}">
                                    </div>
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
                                <div class="visibility-box" title="{{ $thread->visibility->visibility }}">
                                    <div class="relative">
                                        <div class="flex align-center @can('update', $thread) pointer button-with-suboptions thread-visibility-changer @endcan">
                                            <svg class="size14 thread-resource-visibility-icon" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                {!! $thread->visibility->icon !!}
                                            </svg>
                                            @can('update', $thread)
                                            <span class="gray fs12" style="margin-top: 1px">▾</span>
                                            <input type="hidden" class="message-after-change" value="{{ __('Your discussion visibility has been changed successfully') }}.">
                                            @endcan
                                        </div>
                                        @can('update', $thread)
                                        <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:156px">
                                            <div class="pointer simple-suboption flex align-center thread-visibility-button">
                                                <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z"/></svg>
                                                <div class="fs13">{{ __('Public') }}</div>
                                                <input type="hidden" class="thread-add-visibility-slug" value="public">
                                                <input type="hidden" class="icon-path-when-selected" value="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z">
                                                <div class="loading-dots-anim ml4 none">•</div>
                                            </div>
                                            <div class="pointer simple-suboption flex align-center thread-visibility-button">
                                                <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z"/></svg>
                                                <div class="fs13">{{ __('Followers Only') }}</div>
                                                <input type="hidden" class="thread-add-visibility-slug" value="followers-only">
                                                <input type="hidden" class="icon-path-when-selected" value="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z">
                                                <div class="loading-dots-anim ml4 none">•</div>
                                            </div>
                                            <div class="pointer simple-suboption flex align-center thread-visibility-button">
                                                <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z"/></svg>
                                                <div class="fs13">{{ __('Only Me') }}</div>
                                                <input type="hidden" class="thread-add-visibility-slug" value="private">
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
                    <div class="simple-border-container mr8 flex align-center" title="{{ __('views') }}">
                        <svg class="mr4 size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="fill:none; stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                        <p class="no-margin fs12 unselectable" style="margin-top: 1px">{{ $views }}</p>
                    </div>
                    <div class="relative">
                        <svg class="pointer button-with-suboptions size20 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                        <div class="suboptions-container suboptions-container-right-style">
                            @can('save', $thread)
                            <div class="pointer simple-suboption save-thread flex align-center">
                                <input type="hidden" class="save-icon" value="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z">
                                <input type="hidden" class="unsave-icon" value="M424.5,230.48V480.67L256,382.38,87.5,480.67V73.46a42.13,42.13,0,0,1,42.13-42.13H324.42a55.81,55.81,0,0,0-9.88,7.46c-6.09,5.74-11,13-15.4,20.08a25.43,25.43,0,0,0-3.92,14.59H134.89a5.26,5.26,0,0,0-5.26,5.26V407.33L256,333.61l126.38,73.72V238.2a26.69,26.69,0,0,0,14.2-.22,52.38,52.38,0,0,0,5.45-1.91c7.38.45,14.78-1.75,21.32-5ZM507.06,127A121.06,121.06,0,1,1,386,5.94,121,121,0,0,1,507.06,127Zm-23.43,0A97.63,97.63,0,1,0,386,224.63,97.6,97.6,0,0,0,483.63,127ZM435.69,96.64a5.85,5.85,0,0,0,0-8.3l-11-11a5.85,5.85,0,0,0-8.3,0L386,107.67,355.64,77.31a5.85,5.85,0,0,0-8.3,0l-11,11a5.85,5.85,0,0,0,0,8.3L366.67,127l-30.36,30.36a5.85,5.85,0,0,0,0,8.3l11,11a5.85,5.85,0,0,0,8.3,0L386,146.33l30.36,30.36a5.85,5.85,0,0,0,8.3,0l11-11a5.85,5.85,0,0,0,0-8.3L405.33,127l30.36-30.36Z">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    @if($thread->is_saved)
                                    <path class="icon" d="M424.5,230.48V480.67L256,382.38,87.5,480.67V73.46a42.13,42.13,0,0,1,42.13-42.13H324.42a55.81,55.81,0,0,0-9.88,7.46c-6.09,5.74-11,13-15.4,20.08a25.43,25.43,0,0,0-3.92,14.59H134.89a5.26,5.26,0,0,0-5.26,5.26V407.33L256,333.61l126.38,73.72V238.2a26.69,26.69,0,0,0,14.2-.22,52.38,52.38,0,0,0,5.45-1.91c7.38.45,14.78-1.75,21.32-5ZM507.06,127A121.06,121.06,0,1,1,386,5.94,121,121,0,0,1,507.06,127Zm-23.43,0A97.63,97.63,0,1,0,386,224.63,97.6,97.6,0,0,0,483.63,127ZM435.69,96.64a5.85,5.85,0,0,0,0-8.3l-11-11a5.85,5.85,0,0,0-8.3,0L386,107.67,355.64,77.31a5.85,5.85,0,0,0-8.3,0l-11,11a5.85,5.85,0,0,0,0,8.3L366.67,127l-30.36,30.36a5.85,5.85,0,0,0,0,8.3l11,11a5.85,5.85,0,0,0,8.3,0L386,146.33l30.36,30.36a5.85,5.85,0,0,0,8.3,0l11-11a5.85,5.85,0,0,0,0-8.3L405.33,127l30.36-30.36Z"/>
                                    @else
                                    <path class="icon" d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/>
                                    @endif
                                </svg>
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
                                <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                                <input type="hidden" class="status" value="@if($thread->is_saved) unsave @else save @endif">
                                <input type="hidden" class="button-text-save" value="{{ __('Save thread') }}">
                                <input type="hidden" class="button-text-unsave" value="{{ __('Unsave thread') }}">
                                <input type="hidden" class="saved-message" value="{{ __('Thread saved successfully.') }}">
                                <input type="hidden" class="unsaved-message" value="{{ __('Thread unsaved successfully.') }}">
                            </div>
                            @endcan
                            @can('update', $thread)
                            <a href="{{ $edit_link }}" target="_blank" class="no-underline simple-suboption flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"/></svg>
                                <div class="black">{{ __('Edit thread') }}</div>
                            </a>
                            <div class="pointer simple-suboption flex align-center open-thread-shadowed-viewer">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                <div class="no-underline black">{{ __('Delete thread') }}</div>
                                <input type="hidden" value=".thread-deletion-viewer" class="viewer">
                            </div>
                            <div class="simple-suboption flex align-center open-thread-shadowed-viewer">
                                <div class="pointer action-verification small-image-2 sprite sprite-2-size @if($posts_switch == 'off') turnoffreplies17-icon @else turnonreplies17-icon @endif mr4"></div>
                                <div>{{ __('Turn ' . $posts_switch .  ' replies') }}</div>
                                <input type="hidden" value=".turn-off-posts-viewer" class="viewer">
                            </div>
                            @endcan
                            <div class="pointer simple-suboption thread-display-button flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.03 490.03"><path d="M435.67,54.31a18,18,0,0,0-25.5,0l-64,64c-79.3-36-163.9-27.2-244.6,25.5C41.47,183,5,232.31,3.47,234.41a18.16,18.16,0,0,0,.5,22c34.2,42,70,74.7,106.6,97.5l-56.3,56.3a18,18,0,1,0,25.4,25.5l356-355.9A18.11,18.11,0,0,0,435.67,54.31ZM200.47,264a46.82,46.82,0,0,1-3.9-19,48.47,48.47,0,0,1,67.5-44.6Zm90.2-90.1a84.37,84.37,0,0,0-116.6,116.6L137,327.61c-32.5-18.8-64.5-46.6-95.6-82.9,13.3-15.6,41.4-45.7,79.9-70.8,66.6-43.4,132.9-52.8,197.5-28.1Zm195.4,59.7c-24.7-30.4-50.3-56-76.3-76.3a18.05,18.05,0,1,0-22.3,28.4c20.6,16.1,41.2,36.1,61.2,59.5a394.59,394.59,0,0,1-66,61.3c-60.1,43.7-120.8,59.5-180.3,46.9a18,18,0,0,0-7.4,35.2,224.08,224.08,0,0,0,46.8,4.9,237.92,237.92,0,0,0,71.1-11.1c31.1-9.7,62-25.7,91.9-47.5,50.4-36.9,80.5-77.6,81.8-79.3A18.16,18.16,0,0,0,486.07,233.61Z"/></svg>
                                <div>{{ __('Hide thread') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- thread main content -->
            <div class="thread-content-section">
                <!-- textual content -->
                <div style="padding: 10px 10px 4px 10px">
                    <div class="flex align-center path-blue-when-hover">
                        <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            {!! $forum->icon !!}
                        </svg>
                        <div class="flex align-center">
                            <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                            <a href="{{ $category_threads_link }}" class="fs11 black-link">{{ $category->category }}</a>
                        </div>
                    </div>
                    <div class="mt8 mb4 expand-box">
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
                    <div>
                        <div class="thread-content-box thread-content-box-max-height">
                            <div class="thread-content">{!! $content !!}</div>
                            <input type="hidden" class="expand-state" autocomplete="off" value="0">
                            <input type="hidden" class="expand-button-text" autocomplete="off" value="{{ __('see all') }}">
                            <input type="hidden" class="expand-button-collapse-text" autocomplete="off" value="{{ __('see less') }}">
                        </div>    
                    </div>
                </div>
                <div class="pointer fs12 bold blue py4 full-center none expend-thread-content-button">
                    <span class="btn-text">{{ __('see all') }}</span>
                    <svg class="size7 expand-arrow" style="margin-left: 5px; fill: #2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36">
                        <path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/>
                    </svg>
                    <input type="hidden" class="down-arr" value="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z">
                    <input type="hidden" class="up-arr" value="M286.93,223.05a17.5,17.5,0,0,1-12.84,5.38H18.27a17.58,17.58,0,0,1-12.85-5.38,18,18,0,0,1-.34-25.36l.34-.33L133.33,69.43a17.92,17.92,0,0,1,25.34-.36l.36.36,127.9,127.93a17.9,17.9,0,0,1,.36,25.32Z">
                </div>
                <!-- media content -->
                @if($thread->has_media)
                <div class="thread-medias-container">
                    <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                    @php
                        $media_count = 0;
                    @endphp
                    @foreach($medias as $media)
                        @if($media['type'] == 'image')
                        <div class="thread-media-container open-media-viewer relative pointer">
                            <div class="thread-image-options">
                                <p class="white"></p>
                            </div>
                            <div class="thread-image-zoomer-container">

                            </div>
                            <div class="fade-loading"></div>
                            <img data-src="{{ asset($media['frame']) }}" alt="" class="thread-media lazy-image image-with-fade">
                            <div class="full-shadow-stretched none">
                                <p class="fs26 bold white unselectable">+<span class="thread-media-more-counter"></span></p>
                            </div>
                            <input type="hidden" class="media-type" value="{{ $media['type'] }}">
                            <input type="hidden" class="media-count" value="{{ $media_count }}">
                        </div>
                        @elseif($media['type'] == 'video')
                        <div class="thread-media-box thread-media-container relative" style="background-color: #0f0f0f">
                            <div class="thread-media-options full-center">
                                @if($thread->has_media)
                                <svg class="size17 pointer open-media-viewer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M0,180V56A23.94,23.94,0,0,1,24,32H148a12,12,0,0,1,12,12V84a12,12,0,0,1-12,12H64v84a12,12,0,0,1-12,12H12A12,12,0,0,1,0,180ZM288,44V84a12,12,0,0,0,12,12h84v84a12,12,0,0,0,12,12h40a12,12,0,0,0,12-12V56a23.94,23.94,0,0,0-24-24H300A12,12,0,0,0,288,44ZM436,320H396a12,12,0,0,0-12,12v84H300a12,12,0,0,0-12,12v40a12,12,0,0,0,12,12H424a23.94,23.94,0,0,0,24-24V332A12,12,0,0,0,436,320ZM160,468V428a12,12,0,0,0-12-12H64V332a12,12,0,0,0-12-12H12A12,12,0,0,0,0,332V456a23.94,23.94,0,0,0,24,24H148A12,12,0,0,0,160,468Z"/></svg>
                                @endif
                            </div>
                            <video class="thread-media full-height full-width" controls preload="none">
                                <source src="{{ asset($media['frame']) }}" type="{{ $media['mime'] }}">
                                {{ __('Your browser does not support HTML video') }}
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
            <!-- thread bottom section -->
            <div class="thread-bottom-section space-between">
                <div class="flex align-center">
                    <div class="thread-react-hover @auth like-resource like-resource-from-outside-viewer @endauth @guest login-signin-button @endguest">
                        <input type="hidden" class="likable-id" value="{{ $thread->id }}">
                        <input type="hidden" class="likable-type" value="thread">
                        <svg class="size17 like-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                            <path class="red-like @if(!$thread->liked) none @endif" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                            <path class="grey-like @if($thread->liked) none @endif" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                        </svg>
                        <p class="no-margin fs12 resource-likes-counter unselectable ml4">{{ $thread->likes->count() }}</p>
                        <p class="no-margin fs12 unselectable ml4">{{ __('like') . (($thread->likes->count()>1) ? 's' : '' ) }}</p>
                    </div>
                    <div class="thread-react-hover move-to-thread-replies flex align-center no-underline">
                        <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                        <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" fill="#1c1c1c" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                        <p class="no-margin unselectable fs12"><span class="thread-replies-counter">{{ $replies }}</span> {{__('replies')}}</p>
                    </div>
                </div>
                <div class="flex align-center">
                    <div class="relative">
                        <div class="flex align-center unselectable pointer link-without-underline-style button-with-suboptions copy-container-button" class="block" style="margin: 4px; font-size: 12px">
                            <svg class="mr4 size14" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M326.61,185.39A151.92,151.92,0,0,1,327,400l-.36.37-67.2,67.2c-59.27,59.27-155.7,59.26-215,0s-59.27-155.7,0-215l37.11-37.1c9.84-9.84,26.78-3.3,27.29,10.6a184.45,184.45,0,0,0,9.69,52.72,16.08,16.08,0,0,1-3.78,16.61l-13.09,13.09c-28,28-28.9,73.66-1.15,102a72.07,72.07,0,0,0,102.32.51L270,343.79A72,72,0,0,0,270,242a75.64,75.64,0,0,0-10.34-8.57,16,16,0,0,1-6.95-12.6A39.86,39.86,0,0,1,264.45,191l21.06-21a16.06,16.06,0,0,1,20.58-1.74,152.65,152.65,0,0,1,20.52,17.2ZM467.55,44.45c-59.26-59.26-155.69-59.27-215,0l-67.2,67.2L185,112A152,152,0,0,0,205.91,343.8a16.06,16.06,0,0,0,20.58-1.73L247.55,321a39.81,39.81,0,0,0,11.69-29.81,16,16,0,0,0-6.94-12.6A75,75,0,0,1,242,270a72,72,0,0,1,0-101.83L309.16,101a72.07,72.07,0,0,1,102.32.51c27.75,28.3,26.87,73.93-1.15,102l-13.09,13.09a16.08,16.08,0,0,0-3.78,16.61,184.45,184.45,0,0,1,9.69,52.72c.5,13.9,17.45,20.44,27.29,10.6l37.11-37.1c59.27-59.26,59.27-155.7,0-215Z"/></svg>
                            {{__('link')}}
                        </div>
                        <div class="absolute button-simple-container suboptions-container" style="z-index: 1;right: 0;">
                            <div class="flex">
                                <input type="text" value="{{ $thread->link }}" autocomplete="off" class="simple-input" style="width: 240px; padding: 3px; ">
                                <div class="pointer input-button-style flex align-center copy-thread-link">
                                    {{ __('copy') }}
                                    <input type="hidden" class="copied" value="link copied to your clipboard">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex align-center ml4 report-thread-button-container">
                        <div class="@auth @if(auth()->user()->id != $thread->user->id) open-thread-report @endif @endauth @guest login-signin-button @endguest thread-react-hover" style="margin-right: 0px">
                            <svg class="size14 mr4" style="fill: #242424" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M349.57,98.78C296,98.78,251.72,64,184.35,64a194.36,194.36,0,0,0-68,12A56,56,0,1,0,32,101.94V488a24,24,0,0,0,24,24H72a24,24,0,0,0,24-24V393.6c28.31-12.06,63.58-22.12,114.43-22.12,53.59,0,97.85,34.78,165.22,34.78,48.17,0,86.67-16.29,122.51-40.86A31.94,31.94,0,0,0,512,339.05V96a32,32,0,0,0-45.48-29C432.18,82.88,390.06,98.78,349.57,98.78Z"/></svg>
                            <div class="fs13">report</div>
                            <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                        </div>
                        <script>
                            // Here we need to only report thread from thread show page
                            if($('.page').first().val() != 'thread-show') {
                                $('.report-thread-button-container').remove();
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>