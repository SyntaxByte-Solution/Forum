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
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.settings'])
    <div id="middle-container" class="middle-padding-1">
        @include('partials.user-space.basic-header', ['page' => 'settings'])
        <section class="flex" style="width: 70%">  
            <div class="full-width">
                <h1 class="">Update Profile & Settings</h1>
                <div class="relative us-user-media-container">
                    <div class="us-cover-container full-center">
                        @if(!$user->cover)
                            <a href="" class="no-underline change-cover full-center full-width full-height">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/image.png') }}" class="small-image mr4" alt="">
                                    <p class="fs17 white">Upload a cover</p>
                                </div>
                            </a>
                        @else
                            <img src="{{ $user->cover }}"  class="us-cover" alt="">
                        @endif
                    </div>
                    <div class="us-after-cover-section flex">
                        <div>
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}">
                                <div class="us-profile-picture-container full-center">
                                    <img src="{{ $user->avatar }}" class="us-profile-picture" alt="">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @can('update', $user)
                <div class="flex">
                    <a href="" class="bold move-to-right link-without-underline-style">EDIT PROFILE</a>
                </div>
                @endcan
                <div class="flex">
                    <div class="half-width mx4 us-user-info-container relative">
                        @can('update', $user)
                            <a href="" class="absolute" style="top: 8px; right: 8px">
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
                    <div class="half-width mx4 us-user-info-container full">
                        <h3 class="m4 forum-color" style="margin-bottom: 14px">Friends</h3>
                        <div class="full-center">
                            @if($user->id == auth()->user()->id)
                                <p class="forum-color text-center">You don't have friends for the moments ! search for people and send friend requests</p>
                            @else
                                <p class="forum-color text-center">This user has no friends for the moments !</p>
                            @endif
                        </div>
                        <h3 class="m4 forum-color" style="margin-bottom: 14px">Followers</h3>
                        <div class="full-center">
                            @if($user->id == auth()->user()->id)
                                <p class="forum-color text-center">You don't have any followers for the moments ! search for people to follow them !</p>
                            @else
                                <p class="forum-color text-center">This user has no followers for the moments !</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection