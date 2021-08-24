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
                    <div class="follow-box thread-component-follow-box flex align-center">
                        <!-- buttons labels -->
                        <input type="hidden" class="follow-text" autocomplete="off" value="{{ __('Follow') }}">
                        <input type="hidden" class="following-text" autocomplete="off" value="{{ __('Following') }}..">
                        <input type="hidden" class="unfollow-text" autocomplete="off" value="{{ __('Unfollow') }}">
                        <input type="hidden" class="unfollowing-text" autocomplete="off" value="{{ __('Unfollowing') }}..">
                        <input type="hidden" class="follow-success-text" autocomplete="off" value="{{ __('Follow success !') }}">

                        <div class="pointer @guest login-signin-button @endguest">
                            <div class="relative follow-notif-container @if(!$followed) none @endif">
                                <svg class="size14 button-with-suboptions" style="fill: #1e1e1e;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,512a64,64,0,0,0,64-64H192A64,64,0,0,0,256,512ZM471.39,362.29c-19.32-20.76-55.47-52-55.47-154.29,0-77.7-54.48-139.9-127.94-155.16V32a32,32,0,1,0-64,0V52.84C150.56,68.1,96.08,130.3,96.08,208c0,102.3-36.15,133.53-55.47,154.29A31.24,31.24,0,0,0,32,384c.11,16.4,13,32,32.1,32H447.9c19.12,0,32-15.6,32.1-32A31.23,31.23,0,0,0,471.39,362.29Z"/></svg>
                                <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:max-content">
                                    <div class="pointer follow-resource follow-button-toggle-with-bell simple-suboption flex align-center">
                                        <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M234,147.1h0a87.1,87.1,0,1,0,87.1,87.11A87.12,87.12,0,0,0,234,147.1Zm0,130.65a43.55,43.55,0,1,1,0-87.1h0a43.55,43.55,0,0,1,0,87.1Zm224.55-7.07a9.77,9.77,0,0,0-6.3-8.52,156.94,156.94,0,0,0-26.41-7.34,9.79,9.79,0,0,0-11.36,7.94,9.46,9.46,0,0,0-.09,2.81,180.26,180.26,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.17,180.17,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.22-9.36,9.94,9.94,0,0,0-.09-1.81A157.76,157.76,0,0,0,246.4,66.9a9.83,9.83,0,0,0-9.16-6.9h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.37,221.37,0,0,0,168-167.67A235,235,0,0,0,458.56,270.68ZM234,466.45a180.41,180.41,0,0,1-118-43.91,78.14,78.14,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.38,78.38,0,0,1,352,422.54,180.41,180.41,0,0,1,234,466.45ZM444.34,98,510.8,31.53a4.07,4.07,0,0,0,0-5.77L486.25,1.2a4.08,4.08,0,0,0-5.78,0L414,67.66,347.54,1.2a4.19,4.19,0,0,0-5.78,0L317.2,25.76a4.09,4.09,0,0,0,0,5.77L383.67,98,317.2,164.46a4.1,4.1,0,0,0,0,5.78l24.56,24.56a4.08,4.08,0,0,0,5.78,0L414,128.33l66.47,66.47a4.08,4.08,0,0,0,5.78,0l24.55-24.56a4.08,4.08,0,0,0,0-5.78Z"/>
                                        </svg>
                                        <div class="fs13 btn-txt">{{ __('Unfollow') }}</div>
                                        <input type="hidden" class="icon-path-when-selected" autocomplete="off" value="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z">
                                    </div>
                                </div>
                            </div>
                            @php
                                $state = $followed == true ? 1 : -1;
                            @endphp
                            <div class="@if($followed) none @endif @auth follow-text-button follow-resource follow-button-toggle-with-bell @endauth">
                                <p class="no-margin fs12 bold btn-txt blue unselectable">{{ __('Follow') }}</p>
                            </div>
                            <input type="hidden" class="followable-id" autocomplete="off" value="{{ $thread->user->id }}">
                            <input type="hidden" class="followable-type" autocomplete="off" value="user">
                            <input type="hidden" class="status" autocomplete="off" value="{{ $state }}">
                        </div>
                    </div>
                    @endif
                </div>
                <p class="no-margin gray fs13">{{ $owner_username }}</p>
            </div>
        </div>
        <div class="relative">
            <svg class="pointer button-with-suboptions size20 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
            <div class="suboptions-container suboptions-container-right-style" style="width:max-content">
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
            </div>
        </div>
    </div>
    <div class="thread-media-viewer-infos-content">
        <div class="px8 py8">
            <div class="flex align-center mb8">
                <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    {!! $thread->forum()->icon !!}
                </svg>
                <div class="flex align-center">
                    <a href="{{ route('forum.all.threads', ['forum'=>$thread->forum()->slug]) }}" class="fs11 black-link">{{ $thread->forum()->forum }}</a>
                    <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                    <a href="{{ route('category.threads', ['forum'=>$thread->forum()->slug,'category'=>$thread->category->slug]) }}" class="fs11 black-link">{{ $thread->category->category }}</a>
                </div>
            </div>
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
                        <div class="remove-informer-message-container rounded pointer">
                            <span style="margin-top: -1px">✖</span>
                        </div>
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
                    hideIcons: ["guide", "heading", "link", "image"],
                    spellChecker: false,
                    showMarkdownLineBreaks: true,
                });
            </script>
            <style>
                .thread-media-viewer-infos-content .editor-toolbar {
                    background-color: #f4f4f4;
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
                    display: none !important;
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
        <div id="viewer-replies-site" class="forum-color bold mt8 ml8 viewer-thread-replies-number-container @if(!$thread->posts->count()) none @endif">Replies (<span class="viewer-thread-replies-number">{{ $thread->posts->count() }}</span>)</div>
        <div class="mx8" style="margin-bottom: 12px">
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
</div>