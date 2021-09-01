@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="{{ asset('js/profile.js') }}" defer></script>
    <script src="{{ asset('js/fetch/profile-threads-fetch.js') }}" defer></script>
@endpush

@section('title', $user->username)

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.thread.viewer')
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.profile'])
    <div class="fixed full-shadowed followers-viewer zi12">
        <div class="follow-container">
            <div class="follow-box-header relative">
                <div class="fs18 unselectable">Followers</div>
                <div class="close-shadowed-view-button close-button-style">
                    <span style="margin-top: -1px">✖</span>
                </div>
            </div>
            <div class="follow-box-body">
                <input type="hidden" class="profile_owner_id" value="{{ $user->id }}">
                @if($user->followers->count())
                    <div id="followers-box">
                        @foreach($followers as $follower)
                            <x-user.follower :user="$follower"/>
                        @endforeach
                    </div>
                    @if($user->followers->count() > 8)
                        <button class="see-all-full-style followers-load relative">
                            <div class="relative flex align-center">
                                <span class="button-text">{{__('load more')}}</span>
                                <div class="relative absolute" style="left: 100%">
                                    <div class="spinner size17 ml4 opacity0">
                                        <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <input type='hidden' class="button-text-no-ing" value="{{ __('load more') }}">
                        <input type='hidden' class="button-text-ing" value="{{ __('loading..') }}">
                    @endif
                @else
                    <div class="flex flex-column align-center">
                        <div class="size36 sprite sprite-2-size nofollow36-icon" style="margin-top: 16px"></div>
                        @if(auth()->user() && $user->id == auth()->user()->id)
                        <p class="bold fs17 gray mb8 unselectable">{{ __("You don't have any followers at that time") }}</h2>
                        <p class="no-margin forum-color unselectable text-center">{{ __("Try to follow people and react to others's discussions to get more followers.") }}</p>
                        @else
                        <p class="bold fs17 gray my8 unselectable">{{ $user->username . __(" has no followers") }}</h2>
                        <p class="no-margin forum-color unselectable text-center">{{ __("Be his first follower :)") }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="fixed full-shadowed follows-viewer zi12">
        <div class="follow-container">
            <div class="follow-box-header relative">
                <div class="fs18 unselectable">{{__('Follows')}}</div>
                <div class="close-shadowed-view-button close-button-style">
                    <span style="margin-top: -1px">✖</span>
                </div>
            </div>
            <div class="follow-box-body">
                <input type="hidden" class="profile_owner_id" value="{{ $user->id }}">
                @if($user->followed_users->count())
                    <div id="follows-box">
                        @foreach($followed_users as $followed_user)
                            <x-user.follows :user="$followed_user"/>
                        @endforeach
                    </div>
                    @if($user->followed_users->count() > 8)
                        <button class="see-all-full-style follows-load relative">
                            <div class="relative flex align-center">
                                <span class="button-text">{{__('load more')}}</span>
                                <div class="relative absolute" style="left: 100%">
                                    <div class="spinner size17 ml4 opacity0">
                                        <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <input type='hidden' class="button-text-no-ing" value="{{ __('load more') }}">
                        <input type='hidden' class="button-text-ing" value="{{ __('loading..') }}">
                    @endif
                @else
                    <div class="flex flex-column align-center">
                        <div class="size36 sprite sprite-2-size nofollow36-icon" style="margin-top: 16px"></div>
                        @if(auth()->user() && $user->id == auth()->user()->id)
                        <p class="bold fs17 gray mb8 unselectable">{{ __("You don't follow any one at the moment") }}</h2>
                        <p class="no-margin forum-color unselectable text-center">{{ __("tip: Try to follow people in order to get notifications about their activities and see their posts.") }}</p>
                        @else
                        <p class="bold fs17 gray my8 unselectable">{{ $user->username . __(" doesn't follow anyone") }}</h2>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div id="middle-container" class="middle-padding-1">
        <input type="hidden" id="page" value="userprofile">
        <section class="flex">  
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'profile'])
                <div class="relative us-user-media-container">
                    <div class="us-cover-container full-center">
                        @if(!$user->cover)
                            @if(auth()->user() && $user->id == auth()->user()->id)
                            <a href="{{ route('user.settings') }}" class="no-underline change-cover full-center full-width full-height">
                                <div class="flex align-center">
                                    <svg class="size20 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V112A48,48,0,0,0,464,64Zm-6,336H54a6,6,0,0,1-6-6V118a6,6,0,0,1,6-6H458a6,6,0,0,1,6,6V394A6,6,0,0,1,458,400ZM128,152a40,40,0,1,0,40,40A40,40,0,0,0,128,152ZM96,352H416V272l-87.52-87.51a12,12,0,0,0-17,0L192,304l-39.51-39.52a12,12,0,0,0-17,0L96,304Z" style="fill:#fff"/></svg>
                                    <p class="fs17 white">Add a cover image</p>
                                </div>
                            </a>
                            @endif
                        @else
                            <img src="{{ $user->cover }}"  class="us-cover" alt="">
                        @endif
                    </div>
                    <div class="us-after-cover-section flex">
                        <div style="padding: 7px; background-color: #F0F2F559" class="rounded">
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}">
                                <div class="us-profile-picture-container full-center rounded">
                                    <img src="{{ $user->sizedavatar(160, '-h') }}" class="us-profile-picture handle-image-center-positioning" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="ms-profile-infos-container flex full-width">
                            <div style="max-width: 220px">
                                <h2 class="no-margin flex align-center">{{ $user->firstname . ' ' . $user->lastname }}</h2>
                                <p class="bold forum-color no-margin"><span style="margin-right: 2px">@</span>{{ $user->username }}</p>
                            </div>
                            <div class="move-to-right flex align-center height-max-content follow-box">
                                <div class="flex align-center">
                                    <div class="flex align-center px8 py4 pointer br4 followers-display light-grey-hover">
                                        <div class="forum-color">{{ _('Followers') }}:<span class="bold followers-counter black" style="margin-left: 1px">{{ $user->followers->count() }}</span></div>
                                    </div>
                                    <div class="gray height-max-content mx4 fs10 unselectable">•</div>
                                    <div class="flex align-center px8 py4 pointer br4 follows-display light-grey-hover mr8">
                                        <div class="forum-color">{{ _('Follows') }}:<span class="bold follows-counter black" style="margin-left: 1px">{{ $user->followed_users->count() }}</span></div>
                                    </div>
                                </div>
                                @if(auth()->user() && $user->id != auth()->user()->id)
                                <div class="button-wraper-style-2 @auth follow-resource follow-button-with-icon followers-follows-follow-inline @endauth @guest login-signin-button @endguest">
                                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path class="followed @unless($followed) none @endunless" d="M446.26,288.77l-115.32,129a11.26,11.26,0,0,1-15.9.87l-.28-.26L266,371.62a11.23,11.23,0,0,0-15.89.31h0l-28,29.13a11.26,11.26,0,0,0,.33,15.91l95.72,91.89a11.26,11.26,0,0,0,15.91-.33l.27-.29L493.14,330.68a11.26,11.26,0,0,0-.89-15.89l-30.11-26.91A11.25,11.25,0,0,0,446.26,288.77ZM225,149.1a87.1,87.1,0,1,0,87.1,87.09A87.12,87.12,0,0,0,225,149.1Zm0,130.64a43.55,43.55,0,1,1,43.55-43.55A43.56,43.56,0,0,1,225,279.74ZM208.43,470l24,25.28a9.89,9.89,0,0,1-7.18,16.7H225C100.87,512,.27,411.57,0,287.5S101,62,225,62c100.49,0,185.55,65.82,214.45,156.72a11.55,11.55,0,0,1-2.38,11.17L421,248a11.62,11.62,0,0,1-20-5C381.38,164.17,309.93,105.55,225,105.55,124.93,105.55,43.55,186.93,43.55,287A180.16,180.16,0,0,0,77.39,392.15c22.23-28.49,56.43-47.09,95.35-47.09h.06a6.35,6.35,0,0,1,6.2,6.4v31.31a6.4,6.4,0,0,1-8.23,6.14l-.66-.21A78.15,78.15,0,0,0,107,424.54,180.6,180.6,0,0,0,202.48,467,9.88,9.88,0,0,1,208.43,470Z"/>
                                        <g class="follow @if($followed) none @endif">
                                            <path d="M146.9,234.19A87.1,87.1,0,1,0,234,147.1,87.12,87.12,0,0,0,146.9,234.19Zm130.65,0A43.55,43.55,0,1,1,234,190.65,43.56,43.56,0,0,1,277.55,234.19Z"/>
                                            <path d="M329.48,70.28A21.37,21.37,0,0,0,305,91.47h0c0,10.09,8.16,19.61,18.13,21.16a90.1,90.1,0,0,1,75,75c1.55,10,11.07,18.13,21.16,18.13h0a21.37,21.37,0,0,0,21.19-24.48A133.06,133.06,0,0,0,329.48,70.28Z"/>
                                            <path d="M425.85,254.82a9.8,9.8,0,0,0-11.45,10.75,180.29,180.29,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.14,180.14,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.13-11.17A158.17,158.17,0,0,0,246.4,66.9,9.83,9.83,0,0,0,237.24,60h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.36,221.36,0,0,0,168-167.67,234.77,234.77,0,0,0,5.32-66,9.77,9.77,0,0,0-6.3-8.52A156.61,156.61,0,0,0,425.85,254.82ZM234,466.45a180.39,180.39,0,0,1-118-43.91,78.15,78.15,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.37,78.37,0,0,1,352,422.54,180.39,180.39,0,0,1,234,466.45Z"/><path d="M329.87,4.77A21.05,21.05,0,0,0,306.5,26.09h0A21.46,21.46,0,0,0,326,47.41,158.69,158.69,0,0,1,468.46,189.86a21.46,21.46,0,0,0,21.32,19.51h0A21,21,0,0,0,511.1,186C502.05,90.26,425.62,13.82,329.87,4.77Z"/>
                                        </g>
                                    </svg>
                                    <p class="no-margin btn-txt unselectable" style="padding-top: 1px">@if($followed){{ __('Followed') }}@else{{ __('Follow') }}@endif</p>
                                    @if($followed)
                                    <input type="hidden" autocomplete="off" class="status" value="1">
                                    @else
                                    <input type="hidden" autocomplete="off" class="status" value="-1">
                                    @endif
                                    <input type="hidden" autocomplete="off" class="follow-text" value="{{ __('Follow') }}">
                                    <input type="hidden" autocomplete="off" class="following-text" value="{{ __('Following ..') }}">
                                    <input type="hidden" autocomplete="off" class="followed-text" value="{{ __('Followed') }}">
                                    <input type="hidden" autocomplete="off" class="unfollowing-text" value="{{ __('Unfollowing ..') }}">
                                    <input type="hidden" autocomplete="off" class="followable-id" value="{{ $user->id }}">
                                    <input type="hidden" autocomplete="off" class="followable-type" value="user">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px" class="index-middle-width">
                    @if($user->account_status->slug == 'deactivated')
                    <h2 class="text-center">DEACTIVATED ACCOUNT</h2>
                    @endif
                    @if($threads->count())
                        <div class="forum-color mb8">
                            @if(auth()->user() && $user->id == auth()->user()->id)
                            <div class="flex align-end space-between">
                                <h2 class="no-margin">{{ __('Your Discussions') }}</h2>
                                <a href="{{ route('thread.add') }}" class="flex button-style-2 black no-underline">
                                    <svg class="size14" style="margin-right: 6px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M402.29,237.71v36.58A13.76,13.76,0,0,1,388.57,288H288V388.57a13.76,13.76,0,0,1-13.71,13.72H237.71A13.76,13.76,0,0,1,224,388.57V288H123.43a13.76,13.76,0,0,1-13.72-13.71V237.71A13.76,13.76,0,0,1,123.43,224H224V123.43a13.76,13.76,0,0,1,13.71-13.72h36.58A13.76,13.76,0,0,1,288,123.43V224H388.57A13.76,13.76,0,0,1,402.29,237.71ZM512,54.86V457.14A54.87,54.87,0,0,1,457.14,512H54.86A54.87,54.87,0,0,1,0,457.14V54.86A54.87,54.87,0,0,1,54.86,0H457.14A54.87,54.87,0,0,1,512,54.86ZM457.14,450.29V61.71a6.87,6.87,0,0,0-6.85-6.85H61.71a6.87,6.87,0,0,0-6.85,6.85V450.29a6.87,6.87,0,0,0,6.85,6.85H450.29A6.87,6.87,0,0,0,457.14,450.29Z"/></svg>
                                    <span class="unselectable">{{ __('Add a discussion') }}</span>
                                </a>
                            </div>
                            @else
                            <h2 class="no-margin">{{ __('Discussions') }}</h2>
                            @endif
                        </div>
                        <input type="hidden" class="current-threads-count" autocomplete="off" value="{{ $threads->count() }}">
                        <div id="threads-global-container">
                            @foreach($threads as $thread)
                                <x-index-resource :thread="$thread"/>
                            @endforeach
                        </div>

                        @if($user->threads->count() > $pagesize)
                            @include('partials.thread.faded-thread', ['classes'=>'profile-fetch-more'])
                        @endif
                    @else
                        <div class="full-center" style="margin-bottom: 36px">
                            <div class="flex flex-column align-center">
                                <svg class="size48 my4" viewBox="0 0 442 442"><path d="M442,268.47V109.08a11.43,11.43,0,0,0-.1-1.42,2.51,2.51,0,0,0,0-.27,10.11,10.11,0,0,0-.29-1.3v0c-.1-.31-.21-.62-.34-.92l-.12-.26-.15-.32c-.17-.34-.36-.67-.56-1a.57.57,0,0,1-.08-.13,10.33,10.33,0,0,0-.81-1l-.17-.18a8,8,0,0,0-.84-.81l-.14-.12a9.65,9.65,0,0,0-1.05-.76l-.26-.15a8.61,8.61,0,0,0-1.05-.53.67.67,0,0,0-.12-.06l-236-99-.06,0-.28-.1a10,10,0,0,0-4.4-.61h-.08a10.59,10.59,0,0,0-1.94.39l-.12,0c-.27.09-.55.18-.82.29l0,0-69.22,29a10,10,0,0,0,0,18.44L186,74.73v88.16L6.13,238.37l-.36.17-.36.17c-.28.15-.55.31-.82.48l-.13.07s0,0,0,0a9.86,9.86,0,0,0-1,.72l-.09.08c-.25.23-.49.46-.72.71l-.2.22a8.19,8.19,0,0,0-.53.67c-.07.08-.13.17-.19.25-.18.27-.34.54-.5.81l-.09.15c-.17.33-.32.67-.46,1,0,.09-.07.19-.1.28-.09.26-.18.53-.25.79l-.09.35c-.06.28-.12.55-.16.83,0,.1,0,.19,0,.28A11.87,11.87,0,0,0,0,247.62V333a10,10,0,0,0,6.13,9.22l235.92,99a9.8,9.8,0,0,0,1.95.6l.19,0c.26.05.52.09.79.12s.66.05,1,.05.67,0,1-.05.53-.07.79-.12l.19,0a9.8,9.8,0,0,0,2-.6l186-78A10,10,0,0,0,442,354V268.47ZM330.23,300.4l-63.15-26.49a10,10,0,0,0-7.74,18.44l45,18.9L246,335.75,137.62,290.29l58.4-24.5,35.53,14.9a10,10,0,1,0,7.74-18.44l-33.27-14V184.58l200.13,84ZM186,248.29l-74.25,31.16L35.85,247.59l150.17-63v63.71ZM196,20.84,406.15,109l-43.37,18.2L200,58.89l-.09,0L152.65,39Zm162.82,126.4a10,10,0,0,0,7.81,0L422,124.05V253.51L206,162.89V83.13ZM20,262.63l216,90.62V417L20,326.34ZM422,347.3,256,417V353.25l166-69.66Z"/></svg>
                                @if(auth()->user() && $user->id == auth()->user()->id)
                                <p class="fs20 bold" style="margin: 2px 0">{{ __("You don't have any thread for the moment !") }}</p>
                                <div class="flex align-center">
                                    <p class="my4 text-center">{{ __("If you want to start a new discussion or question, click on the button above") }}</p>
                                </div>
                                @else
                                <p class="fs20 bold" style="margin: 2px 0">{{ __("This user has no thread for the moment !") }}</p>
                                <div class="flex align-center">
                                    <p class="my4 text-center">{{ __("Check out his") }} <a href="{{ route('user.activities', ['user'=>$user->username]) }}" class="link-path">{{ _('activities') }}</a></p>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div id="right-panel">
                @include('partials.user-space.user-card')
                <div class="ms-right-panel my8">
                    <div class="relative">
                        @can('update', $user)
                        <a href="{{ route('change.user.settings.personal') }}" class="absolute" style="top: 0; right: 0">
                            <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.87,93.92,438,178.5a9.52,9.52,0,0,1,0,12.94L243.91,396.23l-82.49,9.66c-11,1.31-20.35-8.53-19.11-20.16l9.16-87L345.6,93.92a8.38,8.38,0,0,1,12.27,0Zm144-21.47L458.49,26.69a33.51,33.51,0,0,0-49.07,0L378,59.88a9.52,9.52,0,0,0,0,12.94l80.17,84.58a8.37,8.37,0,0,0,12.27,0l31.47-33.19C515.38,109.86,515.38,86.7,501.87,72.45ZM341.33,340.53V436H56.89V135.93H261.16a10.64,10.64,0,0,0,7.55-3.28l35.56-37.51c6.75-7.13,2-19.22-7.56-19.22h-254C19.11,75.92,0,96.08,0,120.93V451c0,24.85,19.11,45,42.67,45H355.56c23.55,0,42.66-20.16,42.66-45V303c0-10-11.46-15-18.22-8l-35.56,37.51A11.9,11.9,0,0,0,341.33,340.53Z"/></svg>
                        </a>
                        @endcan
                        <p class="bold forum-color" style="margin-bottom: 12px; margin-top: 0">Personal informations</p>
                    </div>
                    <div class="ml4 my8">
                        <p class="fs13 my4"><span class="bold fs13 gray">Join date: </span> {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
                    </div>
                    <div class="ml4">
                        <p class="fs13 my4"><span class="bold fs13 gray">About: </span> @isset($user->about) {{ $user->about }} @else <i>{{ __('NOT SET') }}</i> @endisset</p>
                    </div>
                    <div class="simple-line-separator my8"></div>
                    @isset($user->personal->birth)
                    <div class="flex align-center">
                        <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M480,384c-28,0-31.26-32-74.5-32-43.43,0-46.83,32-74.75,32-27.7,0-31.45-32-74.75-32-42.84,0-47.22,32-74.5,32-28.15,0-31.2-32-74.75-32S60.1,384,32,384V304a48,48,0,0,1,48-48H96V112h64V256h64V112h64V256h64V112h64V256h16a48,48,0,0,1,48,48Zm0,128H32V416c43.36,0,46.77-32,74.75-32S138,416,181.5,416c42.84,0,47.22-32,74.5-32,28.15,0,31.2,32,74.75,32,43.36,0,46.77-32,74.75-32,27.49,0,31.25,32,74.5,32ZM128,96A31.9,31.9,0,0,1,96,64c0-31,32-23,32-64,12,0,32,29.5,32,56S145.75,96,128,96Zm128,0a31.9,31.9,0,0,1-32-32c0-31,32-23,32-64,12,0,32,29.5,32,56S273.75,96,256,96Zm128,0a31.9,31.9,0,0,1-32-32c0-31,32-23,32-64,12,0,32,29.5,32,56S401.75,96,384,96Z"/></svg>
                        <p class="fs13 mr4 my4"><span class="bold fs13 gray">Birth: {{ (new \Carbon\Carbon($user->personal->birth))->format('l jS \\of F Y') }}</span></p>
                    </div>
                    @endisset
                    @isset($user->personal->country)
                    <div class="flex align-center my8">
                        <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M236.27,501.67C91,291,64,269.41,64,192,64,86,150,0,256,0S448,86,448,192c0,77.41-27,99-172.27,309.67a24,24,0,0,1-39.46,0ZM256,272a80,80,0,1,0-80-80A80,80,0,0,0,256,272Z"/></svg>
                        <p class="fs13 mr4 my4"><span class="bold fs13 gray">From: {{ $user->personal->country }}@isset($user->personal->city), {{ $user->personal->city }}  @endisset</span></p>
                    </div>
                    @endisset
                    @if(@isset($user->personal->facebook) || @isset($user->personal->instagram) || @isset($user->personal->twitter))
                        <div class="simple-line-separator my8"></div>
                        <div>
                            @isset($user->personal->facebook)
                            <div class="flex my8">
                                <svg class="small-image-2 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M483.74,0H28.24A28.26,28.26,0,0,0,0,28.26v455.5A28.26,28.26,0,0,0,28.26,512H273.5V314H207V236.5h66.5v-57c0-66.14,40.38-102.14,99.38-102.14,28.26,0,52.54,2.11,59.62,3.05V149.5H391.82c-32.11,0-38.32,15.25-38.32,37.64V236.5h76.75l-10,77.5H353.5V512H483.74A28.25,28.25,0,0,0,512,483.75V28.24A28.26,28.26,0,0,0,483.74,0Z" style="fill:#4267b2"/><path d="M353.5,187.14V236.5h76.75l-10,77.5H353.5V512h-80V314H207V236.5h66.5v-57c0-66.14,40.38-102.14,99.38-102.14,28.26,0,52.54,2.11,59.62,3.05V149.5H391.82C359.71,149.5,353.5,164.75,353.5,187.14Z" style="fill:#fff"/></svg>
                                <a href="{{ $user->personal->facebook }}" target="_blank"  class="fs13 link-style">{{ $user->personal->facebook }}</a>
                            </div>
                            @endisset
                            @isset($user->personal->instagram)
                            <div class="flex my8">
                                <svg class="small-image-2 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><defs><linearGradient id="linear-gradient" x1="42.97" y1="42.97" x2="469.03" y2="469.04" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffd600"/><stop offset="0.5" stop-color="#ff0100"/><stop offset="1" stop-color="#d800b9"/></linearGradient><linearGradient id="linear-gradient-2" x1="163.04" y1="163.05" x2="348.95" y2="348.96" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ff6400"/><stop offset="0.5" stop-color="#ff0100"/><stop offset="1" stop-color="#fd0056"/></linearGradient><linearGradient id="linear-gradient-3" x1="370.93" y1="370.93" x2="414.37" y2="414.38" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f30072"/><stop offset="1" stop-color="#e50097"/></linearGradient></defs><path d="M510.46,150.45c-1.25-27.25-5.57-45.86-11.9-62.14A125.58,125.58,0,0,0,469,43a125.52,125.52,0,0,0-45.34-29.54C407.4,7.11,388.8,2.79,361.55,1.55S325.52,0,256,0,177.75.3,150.45,1.54,104.6,7.11,88.31,13.44A125.58,125.58,0,0,0,43,43,125.52,125.52,0,0,0,13.43,88.31C7.11,104.59,2.79,123.2,1.55,150.45S0,186.47,0,256s.3,78.25,1.55,105.55,5.57,45.85,11.9,62.14A125.43,125.43,0,0,0,43,469a125.38,125.38,0,0,0,45.35,29.52c16.28,6.34,34.89,10.66,62.14,11.91S186.48,512,256,512s78.25-.3,105.55-1.54,45.86-5.57,62.14-11.91a130.87,130.87,0,0,0,74.87-74.86c6.33-16.29,10.65-34.9,11.9-62.14S512,325.52,512,256,511.7,177.75,510.46,150.45Zm-46.08,209c-1.14,25-5.31,38.51-8.81,47.53A84.79,84.79,0,0,1,407,455.57c-9,3.5-22.57,7.68-47.53,8.81-27,1.24-35.09,1.5-103.45,1.5s-76.46-.26-103.45-1.5c-25-1.13-38.51-5.31-47.53-8.81a79.45,79.45,0,0,1-29.44-19.15A79.37,79.37,0,0,1,56.43,407c-3.5-9-7.68-22.57-8.81-47.53-1.23-27-1.49-35.09-1.49-103.45s.26-76.45,1.49-103.45c1.14-25,5.31-38.51,8.81-47.53A79.45,79.45,0,0,1,75.58,75.58,79.45,79.45,0,0,1,105,56.43c9-3.5,22.57-7.67,47.53-8.81,27-1.23,35.09-1.49,103.45-1.49h0c68.35,0,76.45.26,103.45,1.49,25,1.14,38.51,5.31,47.53,8.81a79.34,79.34,0,0,1,29.43,19.15A79.21,79.21,0,0,1,455.56,105c3.51,9,7.68,22.57,8.82,47.53,1.23,27,1.49,35.09,1.49,103.45S465.61,332.45,464.38,359.45Z" style="fill:url(#linear-gradient)"/><path d="M256,124.54A131.46,131.46,0,1,0,387.46,256,131.46,131.46,0,0,0,256,124.54Zm0,216.79A85.34,85.34,0,1,1,341.33,256,85.32,85.32,0,0,1,256,341.33Z" style="fill:url(#linear-gradient-2)"/><path d="M423.37,119.35a30.72,30.72,0,1,1-30.72-30.72A30.72,30.72,0,0,1,423.37,119.35Z" style="fill:url(#linear-gradient-3)"/></svg>
                                <a href="https://www.instagram.com/{{ $user->personal->instagram }}/" target="_blank" class="fs13 link-style">{{ '@'.$user->personal->instagram }}</a>
                            </div>
                            @endisset
                            @isset($user->personal->twitter)
                            <div class="flex my8">
                                <svg class="small-image-2 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512,97.25a218.64,218.64,0,0,1-60.48,16.57,104.36,104.36,0,0,0,46.18-58,210,210,0,0,1-66.56,25.41A105,105,0,0,0,249.57,153,108,108,0,0,0,252,176.93C164.74,172.67,87.52,130.85,35.65,67.14A105,105,0,0,0,67.9,207.42,103.69,103.69,0,0,1,20.48,194.5v1.15a105.43,105.43,0,0,0,84.1,103.13,104.65,104.65,0,0,1-27.52,3.46,92.77,92.77,0,0,1-19.88-1.79c13.6,41.57,52.2,72.13,98.08,73.12A210.93,210.93,0,0,1,25.12,418.34,197.72,197.72,0,0,1,0,416.9,295.54,295.54,0,0,0,161,464c193.16,0,298.76-160,298.76-298.69,0-4.64-.16-9.12-.39-13.57A209.29,209.29,0,0,0,512,97.25Z" style="fill:#03a9f4"/></svg>
                                <p class="fs13 mr4 my4"><a href="{{ $user->personal->twitter }}" target="_blank"  class="fs13 link-style">{{ $user->personal->twitter }}</a></p>
                            </div>
                            @endisset
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection