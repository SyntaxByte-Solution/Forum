@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="{{ asset('js/profile.js') }}" defer></script>
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
                    @foreach($followers as $follower)
                        <x-user.follower :user="$follower"/>
                    @endforeach
                    @if($user->followers->count() > 2)
                        <input type='button' class="see-all-full-style followers-load" value="{{__('load more')}}">
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
                    @foreach($followed_users as $followed_user)
                        <x-user.follows :user="$followed_user"/>
                    @endforeach
                    @if($user->followed_users->count() > 8)
                        <div>
                            <input type='button' class="see-all-full-style follows-load" value="{{__('load more')}}">
                            <input type='hidden' class="button-text-no-ing" value="{{ __('load more') }}">
                            <input type='hidden' class="button-text-ing" value="{{ __('loading..') }}">
                        </div>
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
                        <div style="padding: 7px; background-color: white" class="rounded">
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
                                    <div class="flex align-center px8 py4 pointer followers-display light-border" style="margin: 0 14px">
                                        <div class="forum-color">{{ _('Followers') }}:<span class="bold followers-counter black" style="margin-left: 1px">{{ $user->followers->count() }}</span></div>
                                    </div>
                                    <div class="flex align-center px8 py4 pointer follows-display light-border mr8">
                                        <div class="forum-color">{{ _('Follows') }}:<span class="bold follows-counter black" style="margin-left: 1px">{{ $user->followed_users->count() }}</span></div>
                                    </div>
                                </div>
                                @if(auth()->user() && $user->id != auth()->user()->id)
                                <div class="button-wraper-style-2 @auth follow-resource follow-button-with-icon @endauth @guest login-signin-button @endguest">
                                    <svg class="size18 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path class="followed @unless($followed) none @endunless" d="M446.26,288.77l-115.32,129a11.26,11.26,0,0,1-15.9.87l-.28-.26L266,371.62a11.23,11.23,0,0,0-15.89.31h0l-28,29.13a11.26,11.26,0,0,0,.33,15.91l95.72,91.89a11.26,11.26,0,0,0,15.91-.33l.27-.29L493.14,330.68a11.26,11.26,0,0,0-.89-15.89l-30.11-26.91A11.25,11.25,0,0,0,446.26,288.77ZM225,149.1a87.1,87.1,0,1,0,87.1,87.09A87.12,87.12,0,0,0,225,149.1Zm0,130.64a43.55,43.55,0,1,1,43.55-43.55A43.56,43.56,0,0,1,225,279.74ZM208.43,470l24,25.28a9.89,9.89,0,0,1-7.18,16.7H225C100.87,512,.27,411.57,0,287.5S101,62,225,62c100.49,0,185.55,65.82,214.45,156.72a11.55,11.55,0,0,1-2.38,11.17L421,248a11.62,11.62,0,0,1-20-5C381.38,164.17,309.93,105.55,225,105.55,124.93,105.55,43.55,186.93,43.55,287A180.16,180.16,0,0,0,77.39,392.15c22.23-28.49,56.43-47.09,95.35-47.09h.06a6.35,6.35,0,0,1,6.2,6.4v31.31a6.4,6.4,0,0,1-8.23,6.14l-.66-.21A78.15,78.15,0,0,0,107,424.54,180.6,180.6,0,0,0,202.48,467,9.88,9.88,0,0,1,208.43,470Z"/>
                                        <g class="follow @if($followed) none @endif">
                                            <path d="M146.9,234.19A87.1,87.1,0,1,0,234,147.1,87.12,87.12,0,0,0,146.9,234.19Zm130.65,0A43.55,43.55,0,1,1,234,190.65,43.56,43.56,0,0,1,277.55,234.19Z"/>
                                            <path d="M329.48,70.28A21.37,21.37,0,0,0,305,91.47h0c0,10.09,8.16,19.61,18.13,21.16a90.1,90.1,0,0,1,75,75c1.55,10,11.07,18.13,21.16,18.13h0a21.37,21.37,0,0,0,21.19-24.48A133.06,133.06,0,0,0,329.48,70.28Z"/>
                                            <path d="M425.85,254.82a9.8,9.8,0,0,0-11.45,10.75,180.29,180.29,0,0,1-32.79,124.58c-22.14-28.49-56.34-47.09-95.35-47.09-9.26,0-23.59,8.71-52.26,8.71s-43-8.71-52.26-8.71c-38.92,0-73.12,18.6-95.35,47.09A180.14,180.14,0,0,1,52.62,279.91c2.66-96,80.45-173.7,176.4-176.29q6.63-.18,13.16.11a9.8,9.8,0,0,0,10.13-11.17A158.17,158.17,0,0,0,246.4,66.9,9.83,9.83,0,0,0,237.24,60h-.06C112.7,58.3,9,160.44,9,284.93,9,426,138.59,536.67,285.24,504.35a221.36,221.36,0,0,0,168-167.67,234.77,234.77,0,0,0,5.32-66,9.77,9.77,0,0,0-6.3-8.52A156.61,156.61,0,0,0,425.85,254.82ZM234,466.45a180.39,180.39,0,0,1-118-43.91,78.15,78.15,0,0,1,63.14-35.84C198,392.51,216,395.41,234,395.41a181.65,181.65,0,0,0,54.89-8.71A78.37,78.37,0,0,1,352,422.54,180.39,180.39,0,0,1,234,466.45Z"/><path d="M329.87,4.77A21.05,21.05,0,0,0,306.5,26.09h0A21.46,21.46,0,0,0,326,47.41,158.69,158.69,0,0,1,468.46,189.86a21.46,21.46,0,0,0,21.32,19.51h0A21,21,0,0,0,511.1,186C502.05,90.26,425.62,13.82,329.87,4.77Z"/>
                                        </g>
                                    </svg>
                                    <p class="no-margin btn-txt unselectable" style="padding-top: 1px">@if($followed){{ __('Followed') }}@else{{ __('Follow') }}@endif</p>
                                    @if($followed)
                                    <input type="hidden" class="status" value="1">
                                    @else
                                    <input type="hidden" class="status" value="-1">
                                    @endif
                                    <input type="hidden" class="follow-text" value="{{ __('Follow') }}">
                                    <input type="hidden" class="following-text" value="{{ __('Following ..') }}">
                                    <input type="hidden" class="followed-text" value="{{ __('Followed') }}">
                                    <input type="hidden" class="unfollowing-text" value="{{ __('Unfollowing ..') }}">
                                    <input type="hidden" class="followable-id" value="{{ $user->id }}">
                                    <input type="hidden" class="followable-type" value="user">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px" class="index-middle-width">
                    @if(auth()->user() && $user->id == auth()->user()->id)
                        <a href="{{ route('thread.add') }}" class="thread-add-button width-max-content @if($threads->count()) full-width border-box @else move-to-middle @endif" style="margin-bottom: 12px" target="_blank">
                            <svg class="small-image mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 397.15 397.15"><path d="M390.88,12.37c-4.14-4.15-10.13-6.25-17.78-6.25-26.78,0-70.16,26-93.64,41.55l-1.91,1.27-5.28,41.68-14-28.34-4.81,3.52a763.05,763.05,0,0,0-85.75,73.26c-4.62,4.62-9.16,9.31-13.5,13.94l-.93,1-18.7,82.35-9.86-49.17L118,196.36c-3.84,5.26-7.46,10.53-10.78,15.65l-.62,1-8,62.92L86.17,250.56,82.63,263.1c-4.3,15.28-4.5,28.32-.67,38.5l-80,80a5.52,5.52,0,0,0-1.55,6.22A5.21,5.21,0,0,0,5.24,391a6.85,6.85,0,0,0,2.46-.49l36.94-14a15.23,15.23,0,0,0,5.11-3.41l49.61-52.77A44.27,44.27,0,0,0,118,324h0a82.94,82.94,0,0,0,22.18-3.4l12.54-3.54-25.33-12.49,62.92-8,.95-.62c5.12-3.31,10.39-6.94,15.66-10.79l9.19-6.7-49.17-9.86,82.34-18.71,1-.92c4.64-4.35,9.33-8.89,13.94-13.5,35.17-35.17,70.11-78.39,95.85-118.59l3-4.7L338.24,100,373,95.59l1.23-2.2C397.46,51.81,403.07,24.56,390.88,12.37Z"/></svg>
                            {{ __('CREATE NEW THREAD') }}
                        </a>
                    @endif
                
                    @if($user->account_status->slug == 'deactivated')
                    <h2 class="text-center">DEACTIVATED ACCOUNT</h2>
                    @endif
                    @if($threads->count())
                        <div class="flex align-center space-between forum-color">
                            @if(auth()->user() && $user->id == auth()->user()->id)
                            <h2 class="no-margin" style="margin-bottom: 10px">{{ __('Your Threads') }}</h2>
                            @else
                            <h2 class="no-margin" style="margin-bottom: 10px">{{ __('Threads') }}</h2>
                            @endif

                            {{ $threads->onEachSide(0)->links() }}
                        </div>
                        @foreach($threads as $thread)
                            <x-index-resource :thread="$thread"/>
                        @endforeach
                        <div class="flex">
                            <div class="move-to-right">
                                {{ $threads->onEachSide(0)->links() }}
                            </div>
                        </div>
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
            <div id="right-panel" style="padding-top: 8px">
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
                        <div class="flex flex-column toggle-box">
                            <a href="" class="move-to-right link-style toggle-container-button">Social media</a>
                            <div class="toggle-container">
                            @isset($user->personal->facebook)
                            <div class="flex my8">
                                <img src="{{ asset('assets/images/icons/facebook.svg') }}" class="small-image-2 mr4" alt="">
                                <a href="{{ $user->personal->facebook }}" target="_blank"  class="fs13 link-style">{{ $user->personal->facebook }}</a>
                            </div>
                            @endisset
                            @isset($user->personal->instagram)
                            <div class="flex my8">
                                <img src="{{ asset('assets/images/icons/instagram.svg') }}" class="small-image-2 mr4" alt="">
                                <a href="https://www.instagram.com/{{ $user->personal->instagram }}/" target="_blank" class="fs13 link-style">{{ '@'.$user->personal->instagram }}</a>
                            </div>
                            @endisset
                            @isset($user->personal->twitter)
                            <div class="flex my8">
                                <img src="{{ asset('assets/images/icons/twitter.svg') }}" class="small-image-2 mr4" alt="">
                                <p class="fs13 mr4 my4"><a href="{{ $user->personal->twitter }}" target="_blank"  class="fs13 link-style">{{ $user->personal->twitter }}</a></p>
                            </div>
                            @endisset
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </section>
        <script defer>    
            $('.thread-component-follow-box').remove();
        </script>
    </div>
@endsection