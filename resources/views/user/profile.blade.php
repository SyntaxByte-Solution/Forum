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
                            @if($user->id == auth()->user()->id)
                            <a href="{{ route('user.settings', ['user'=>$user->username]) }}" class="no-underline change-cover full-center full-width full-height">
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
                    <a href="{{ route('user.settings', ['user'=>$user->username]) }}" class="bold fs13 move-to-right link-without-underline-style">Edit profile</a>
                </div>
                @endcan
                <div class="flex">
                    <div class="half-width mr4 us-user-info-container relative">
                        @can('update', $user)
                            <a href="{{ route('user.settings', ['user'=>$user->username]) }}" class="absolute" style="top: 8px; right: 8px">
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


            <div>
                <div class="ms-right-panel">
                    <div class="flex px8 py8">
                        <div>
                            <img src="{{ $user->avatar }}" class="small-image-1 br6 mr8" alt="">
                        </div>
                        <div class="mr8">
                            <h2 class="no-margin">{{ $user->firstname . ' ' . $user->lastname }}</h2>
                            <p class="fs12 no-margin gray">Join Date: {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <p class="bold fs12 gray my8" style="margin-bottom: 0">{{ __('IMPACT') }}</p>
                            <div class="relative">
                                <p class="fs17 bold inline-block my4 tooltip-section">~ {{ $user->reach }}</p>
                                <div class="tooltip tooltip-style-2 left0">
                                    Estimated number of times people viewed your helpful posts
                                    (based on page views of your questions
                                    and questions where you wrote highly-ranked answers)
                                </div>
                                <p class="fs12 gray no-margin">People reached</p>
                            </div>
                        </div>
                        <div class="simple-line-separator my8"></div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/disc.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Discussions: </p><span class="fs15 bold ml8">{{ $discussions_count }}</span>
                                </div>
                                @if($discussions_count)
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                                @endif
                            </div>
                        </div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/bqst.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Questions: </p><span class="fs15 bold ml8">{{ $questions_count }}</span>
                                </div>
                                @if($questions_count)
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                                @endif
                            </div>
                        </div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Replies: </p><span class="fs15 bold ml8">{{ $posts_count }}</span>
                                </div>
                                @if($posts_count)
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                                @endif
                            </div>
                        </div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/eye.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Profile views: </p><span class="fs15 bold ml8">{{ $user->profile_views }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Votes casts: </p><span class="fs15 bold ml8">20K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ms-right-panel my8">
                    <p class="bold forum-color" style="margin-bottom: 12px; margin-top: 0">Personal informations</p>
                    <div class="ml4">
                        <p class="fs13 my4"><span class="bold fs13 gray">Join date: </span> {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
                    </div>
                </div>
            </div>
        </section>
        @if($recent_threads->count())
        <div style="margin-top: 20px">
            <h2>Recent Threads</h2>
            <table class="forums-table">
                <tr>
                    <th class="table-col-header">{{ __('THREADS') }}</th>
                    <th class="table-col-header">{{ __('CATEGORY') }}</th>
                    <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                    <th class="table-col-header table-numbered-column">{{ __('VIEWS') }}</th>
                    <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
                </tr>
                @foreach($recent_threads as $thread)
                    <x-resource-table-row :thread="$thread"/>
                @endforeach
            </table>
        </div>
        @endif
    </div>
@endsection