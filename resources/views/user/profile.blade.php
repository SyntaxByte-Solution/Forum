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
                <div class="fs18 unselectable">{{__('Followers')}}</div>
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
                        <input type='hidden' class="button-text-ing" value="{{ __('loading') }}..">
                    @endif
                @else
                    <div class="flex flex-column align-center">
                        <div class="size36 sprite sprite-2-size nofollow36-icon" style="margin-top: 16px"></div>
                        @if(auth()->user() && $user->id == auth()->user()->id)
                        <p class="bold fs17 gray mb8 unselectable">{{ __("You don't have any followers at that time") }}</h2>
                        <p class="no-margin forum-color unselectable text-center">{{ __("Try to follow people and react to others's discussions to get more followers") }}.</p>
                        @else
                        <p class="bold fs17 gray my8 unselectable">{{ $user->username . ' ' . __("has no followers") }}</h2>
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
                        <input type='hidden' class="button-text-ing" value="{{ __('loading') }}..">
                    @endif
                @else
                    <div class="flex flex-column align-center">
                        <div class="size36 sprite sprite-2-size nofollow36-icon" style="margin-top: 16px"></div>
                        @if(auth()->user() && $user->id == auth()->user()->id)
                        <p class="bold fs17 gray mb8 unselectable">{{ __("You don't follow any one at the moment") }}</h2>
                        <p class="no-margin forum-color unselectable text-center">{{ __("tip: Try to follow people in order to get notifications about their activities and see their posts") }}.</p>
                        @else
                        <p class="bold fs17 gray my8 unselectable">{{ $user->username . ' ' . __("doesn't follow anyone") }}</h2>
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
                                    <p class="fs17 white">{{ __('Add a cover image') }}</p>
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
                                        <div class="forum-color">{{ __('Followers') }}:<span class="bold followers-counter black" style="margin-left: 1px">{{ $user->followers->count() }}</span></div>
                                    </div>
                                    <div class="gray height-max-content mx4 fs10 unselectable">•</div>
                                    <div class="flex align-center px8 py4 pointer br4 follows-display light-grey-hover mr8">
                                        <div class="forum-color">{{ __('Follows') }}:<span class="bold follows-counter black" style="margin-left: 1px">{{ $user->followed_users->count() }}</span></div>
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
                                    <input type="hidden" autocomplete="off" class="following-text" value="{{ __('Following') }}..">
                                    <input type="hidden" autocomplete="off" class="followed-text" value="{{ __('Followed') }}">
                                    <input type="hidden" autocomplete="off" class="unfollowing-text" value="{{ __('Unfollowing') }}..">
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
                    <h2 class="text-center">{{__('DEACTIVATED ACCOUNT')}}</h2>
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
                                <p class="fs20 bold" style="margin: 2px 0">{{ __("You don't have any discussion for the moment !") }}</p>
                                <div class="flex align-center">
                                    <p class="my4 text-center">{{ __("If you want to start a new discussion or question, click on the button above") }}</p>
                                </div>
                                @else
                                <p class="fs20 bold" style="margin: 2px 0">{{ __("This user has no discussions for the moment !") }}</p>
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
                @include('partials.user-space.user-personal-infos', ['user'=>$user])
            </div>
        </section>
    </div>
@endsection