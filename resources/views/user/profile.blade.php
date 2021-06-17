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
                <div class="relative us-user-media-container">
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
                        <div>
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}">
                                <div class="us-profile-picture-container full-center rounded">
                                    <img src="{{ $user->avatar }}" class="us-profile-picture rounded" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="ms-profile-infos-container">
                            <h2 class="no-margin forum-color flex align-center">
                                {{ $user->firstname . ' ' . $user->lastname }}
                                <p class="fs14 bold m4">[{{ $user->username }}]</p>
                            </h2>
                            <p class="fs13 gray no-margin">Join Date: {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
                        </div>
                    </div>
                </div>
                @can('update', $user)
                <div class="flex">
                    <a href="{{ route('user.settings') }}" class="bold fs13 move-to-right link-without-underline-style">Edit profile</a>
                </div>
                @endcan
                <div class="flex">
                    <div class="half-width mr4 us-user-info-container relative">
                        @can('update', $user)
                            <a href="{{ route('user.settings') }}" class="absolute" style="top: 8px; right: 8px">
                                <img src="{{ asset('assets/images/icons/bedit.png') }}" class="small-image-size" alt="">
                            </a>
                        @endcan
                        <h3 class="m4 forum-color light-border-bottom" style="padding-bottom: 8px; margin-bottom: 14px">Puplic Informations</h3>

                        <div class="flex my8">
                            <p class="fs14 no-margin flex align-center">Status: 
                                <img src="{{ asset('assets/images/icons/active.png') }}" class="small-image-size ml8" alt="">
                                <span class="bold forum-color ml4">Online</span>
                            </p>
                        </div>

                        <div class="flex my8">
                            <p class="fs14 no-margin">About me: 
                                    @if($user->about)
                                    <span class="bold forum-color ml8">
                                        {{ $user->about }}
                                    </span>
                                    @else
                                    <span class="italic gray ml8">
                                        EMPTY
                                    </span>
                                    @endif
                            </p>
                        </div>
                        <div class="flex my8">
                            <p class="fs14 no-margin">Username: <span class="bold forum-color ml8">{{ $user->username }}</span></p>
                        </div>
                        <div class="flex my8">
                            <p class="fs14 no-margin">Member since: : <span class="bold forum-color ml8">{{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</span></p>
                        </div>
                    </div>
                    <div class="half-width ml4 us-user-info-container full">
                        <h3 class="m4 forum-color" style="margin-bottom: 14px">Friends</h3>
                        <div class="full-center">

                            @if(auth()->user() && $user->id == auth()->user()->id)
                                <p class="forum-color text-center">You don't have friends for the moments ! search for people and send friend requests</p>
                            @else
                                <p class="forum-color text-center">This user has no friends for the moments !</p>
                            @endif
                        </div>
                        <h3 class="m4 forum-color" style="margin-bottom: 14px">Followers</h3>
                        <div class="full-center">
                            @if(auth()->user() && $user->id == auth()->user()->id)
                                <p class="forum-color text-center">You don't have any followers for the moments ! search for people to follow them !</p>
                            @else
                                <p class="forum-color text-center">This user has no followers for the moments !</p>
                            @endif
                        </div>
                    </div>
                </div>
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
                    @isset($user->personal->phone)
                    <div class="flex align-center my8">
                        <img src="{{ asset('assets/images/icons/call.svg') }}" class="small-image-2 mr4" alt="">
                        <p class="fs13 mr4 my4"><span class="bold fs13 gray">Phone number: {{ $user->personal->phone }}</span></p>
                    </div>
                    @endisset
                    @if(@isset($user->personal->facebook) || @isset($user->personal->instagram) || @isset($user->personal->twitter))
                        <div class="flex flex-column toggle-box">
                            <a href="" class="move-to-right link-style toggle-container-button">Social media</a>
                            <div class="toggle-container">
                            @isset($user->personal->facebook)
                            <div class="flex my8">
                                <img src="{{ asset('assets/images/icons/facebook.svg') }}" class="small-image-2 mr4" alt="">
                                <a href="{{ $user->personal->facebook }}" class="fs13 link-style">{{ $user->personal->facebook }}</a>
                            </div>
                            @endisset
                            @isset($user->personal->instagram)
                            <div class="flex my8">
                                <img src="{{ asset('assets/images/icons/instagram.svg') }}" class="small-image-2 mr4" alt="">
                                <a href="" class="bold fs13 link-style">@{{ $user->personal->instagram }}</a>
                            </div>
                            @endisset
                            @isset($user->personal->twitter)
                            <div class="flex my8">
                                <img src="{{ asset('assets/images/icons/twitter.svg') }}" class="small-image-2 mr4" alt="">
                                <p class="fs13 mr4 my4"><a href="{{ $user->personal->twitter }}" class="fs13 link-style">{{ $user->personal->twitter }}</a></p>
                            </div>
                            @endisset
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </section>
        @if($recent_threads->count())
        <div style="margin-top: 20px">
            <h2>Recent Threads</h2>
            <table class="forums-table">
                <tr>
                    <th class="table-col-header">{{ __('THREADS') }}</th>
                    <th class="table-col-header table-numbered-column">{{ __('REPLIES/VIEWS') }}</th>
                    <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
                </tr>
                @foreach($recent_threads as $thread)
                    <x-index-resource :thread="$thread"/>
                @endforeach
            </table>
        </div>
        @endif
    </div>
@endsection