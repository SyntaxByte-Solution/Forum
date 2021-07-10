@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
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
                <h1 class="">User Profile</h1>
                <div class="relative us-user-media-container mx8">
                    <div class="us-cover-container full-center">
                        @if(!$user->cover)
                            @if(auth()->user() && $user->id == auth()->user()->id)
                            <a href="{{ route('user.settings') }}" class="no-underline change-cover full-center full-width full-height">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/image.png') }}" class="small-image mr4" alt="">
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
                                    <img src="{{ $user->avatar }}" class="us-profile-picture handle-image-center-positioning" alt="">
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
                                        <div class="gray">{{ _('Followers') }}:<span class="bold followers-counter black" style="margin-left: 1px">{{ $user->followers->count() }}</span></div>
                                    </div>
                                    <div class="flex align-center px8 py4 pointer follows-display light-border mr8">
                                        <div class="gray">{{ _('Follows') }}:<span class="bold follows-counter black" style="margin-left: 1px">{{ $user->followed_users->count() }}</span></div>
                                    </div>
                                </div>
                                @if(auth()->user() && $user->id != auth()->user()->id)
                                <div class="button-wraper-style @auth follow-resource @endauth @guest login-signin-button @endguest">
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
                @if(auth()->user() && $user->id == auth()->user()->id)
                <div class="my8">
                    @auth
                        @include('partials.thread.thread-add', ['editor_height'=>100])
                    @endauth
                </div>
                @endif
                @if($threads->count())
                <div style="margin-top: 20px">
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
                </div>
                @else
                    @if(auth()->user() && $user->id == auth()->user()->id)
                    <div class="full-center">
                        <div>
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any thread for the moment !") }}</p>
                            <p class="my4 text-center">{{ __("Try to start a discussion or question using the form above") }}</p>
                        </div>
                    </div>
                    @else

                    @endif
                @endif
            </div>
            <div style="position: fixed; top: 55px; right: 8px">
                @include('partials.user-space.user-card')
                <div class="ms-right-panel my8">
                    <div class="relative">
                        @can('update', $user)
                        <a href="{{ route('change.user.settings.personal') }}" class="absolute" style="top: 0; right: 0">
                            <img src="{{ asset('assets/images/icons/bedit.png') }}" class="small-image-size" alt="">
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
                        <img src="{{ asset('assets/images/icons/birth.svg') }}" class="small-image-2 mr4" alt="">
                        <p class="fs13 mr4 my4"><span class="bold fs13 gray">Birth: {{ (new \Carbon\Carbon($user->personal->birth))->format('l jS \\of F Y') }}</span></p>
                    </div>
                    @endisset
                    @isset($user->personal->country)
                    <div class="flex align-center my8">
                        <img src="{{ asset('assets/images/icons/pin.svg') }}" class="small-image-2 mr4" alt="">
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