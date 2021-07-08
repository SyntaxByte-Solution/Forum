@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.profile'])
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
                        <div class="ms-profile-infos-container full-width">
                            <div>
                                <h2 class="no-margin forum-color flex align-center">{{ $user->firstname . ' ' . $user->lastname }}</h2>
                                <p class="bold no-margin"><span style="margin-right: 2px">@</span>{{ $user->username }}</p>
                                <p class="fs12 gray no-margin" style="margin: 2px 0">Join Date: {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
                            </div>
                            <div class="move-to-right flex align-center height-max-content">
                                <div class="flex align-center">
                                    <div class="flex align-center">
                                        <div class="forum-color">{{ _('followers') }}:<span class="bold" style="margin-left: 1px">12</span></div>
                                    </div>
                                    <div class="flex align-center" style="margin: 0 14px">
                                        <div class="forum-color">{{ _('following') }}:<span class="bold" style="margin-left: 1px">12</span></div>
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
                <div class="my8">
                    @auth
                        @include('partials.thread.thread-add', ['editor_height'=>60])
                    @endauth
                </div>
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
                            <p class="my4 text-center">{{ __("Try to start a discussion or question using the forum above") }}</p>
                        </div>
                    </div>
                    @else

                    @endif
                @endif
            </div>
            <div>
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