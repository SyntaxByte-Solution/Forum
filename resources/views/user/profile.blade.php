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
                    @if($user->followers->count() > 8)
                        <input type='button' class="see-all-full-style followers-load" value="{{__('load more')}}">
                    @endif
                @else
                    <div class="flex flex-column align-center">
                        <div class="size36 sprite sprite-2-size nofollow36-icon" style="margin-top: 16px"></div>
                        @if(auth()->user() && $user->id == auth()->user()->id)
                        <p class="bold fs17 gray mb8 unselectable">{{ __("You don't have any followers at that time") }}</h2>
                        <p class="no-margin forum-color unselectable text-center">{{ __("tip: Try to follow people and react to others's discussions to get more followers attention.") }}</p>
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
        <section class="flex">  
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'profile'])
                <div class="relative us-user-media-container mx8">
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
                                    <img src="{{ $user->sizedavatar(160) }}" class="us-profile-picture handle-image-center-positioning" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="ms-profile-infos-container flex full-width">
                            <div style="max-width: 220px">
                                <h2 class="no-margin forum-color flex align-center">{{ $user->firstname . ' ' . $user->lastname }}</h2>
                                <p class="bold no-margin"><span style="margin-right: 2px">@</span>{{ $user->username }}</p>
                                <p class="fs12 gray no-margin" style="margin: 2px 0">Join Date: {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
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
                                <div class="button-wraper-style @auth follow-resource follow-from-profile @endauth @guest login-signin-button @endguest">
                                    <div class="size14 sprite sprite-2-size follow-button-icon mr4 @if($followed) followed14-icon @else follow14-icon @endif"></div>
                                    @if($followed)
                                    <p class="no-margin btn-txt unselectable">{{ __('Followed') }}</p>
                                    <input type="hidden" class="status" value="1">
                                    @else
                                    <p class="no-margin btn-txt unselectable">{{ __('Follow') }}</p>
                                    <input type="hidden" class="status" value="-1">
                                    @endif
                                    <input type="hidden" class="follow-text" value="{{ __('Follow') }}">
                                    <input type="hidden" class="following-text" value="{{ __('Following ..') }}">
                                    <input type="hidden" class="followed-text" value="{{ __('Followed') }}">
                                    <input type="hidden" class="unfollowing-text" value="{{ __('Unfollowing ..') }}">
                                    <input type="hidden" class="followable-id" value="{{ $user->id }}">
                                    <input type="hidden" class="followable-type" value="user">

                                    <input type="hidden" class="followed-icon" value="followed14-icon">
                                    <input type="hidden" class="unfollowed-icon" value="follow14-icon">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px" class="index-middle-width">
                    @if(auth()->user() && $user->id == auth()->user()->id)
                    <div style="margin-top: 20px">
                        <a href="{{ route('thread.add') }}" class="no-underline" target="_blank">
                            <div class="button-style width-max-content">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#fff" d="M512,0C460.22,3.56,96.44,38.2,71,287.61c-3.09,26.66-4.84,53.44-6,80.24L243.89,189.16a16,16,0,0,1,22.65,22.63L7,471A24,24,0,0,0,41,505L98.15,447.9a1130.36,1130.36,0,0,0,126-7.36c53.48-5.44,97-26.47,132.58-56.54H255.74l146.79-48.88A396.77,396.77,0,0,0,433,288H351.84l106.54-53.21C500.29,132.86,510.19,26.26,512,0Z"/></svg>
                                {{ __('Start a discussion') }}
                            </div>
                        </a>
                        <div class="none">
                            @include('partials.thread.thread-add', ['editor_height'=>100])
                        </div>
                    </div>
                    @endif
                    @if($threads->count())
                        <div class="flex align-center space-between">
                            @if(auth()->user() && $user->id == auth()->user()->id)
                            <h2>{{ __('Your Threads') }}</h2>
                            @else
                            <h2>{{ __('Threads') }}</h2>
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
                            <div>
                                <div class="size28 move-to-middle sprite sprite-2-size binbox28-icon" style="margin: 16px auto 10px auto"></div>
                                @if(auth()->user() && $user->id == auth()->user()->id)
                                <p class="fs20 bold" style="margin: 2px 0">{{ __("You don't have any thread for the moment !") }}</p>
                                <p class="my4 text-center">{{ __("Try to start a discussion or question using the form above") }}</p>
                                @else
                                <p class="fs20 bold" style="margin: 2px 0">{{ __("This user has no thread for the moment !") }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div style="position: fixed; top: 60px; right: 8px">
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
                    <div class="ml4">
                        <p class="fs13 my4"><span class="bold fs13 gray">Join date: </span> {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
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
    </div>
@endsection