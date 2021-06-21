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
                        <div style="padding: 7px; background-color: white" class="rounded">
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}">
                                <div class="us-profile-picture-container full-center rounded">
                                    <img src="{{ $user->avatar }}" class="us-profile-picture handle-image-center-positioning" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="ms-profile-infos-container">
                            <h2 class="no-margin forum-color flex align-center">{{ $user->firstname . ' ' . $user->lastname }}</h2>
                            <p class="bold no-margin"><span style="margin-right: 2px">@</span>{{ $user->username }}</p>
                            <p class="fs12 gray no-margin">Join Date: {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
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
                        <h3 class="m4 forum-color light-border-bottom" style="padding-bottom: 8px; margin-bottom: 14px">Public Informations</h3>

                        <div class="flex my8">
                            <p class="fs14 no-margin flex align-center"><span class="bold">Status: </span>
                                @php
                                    $ustatus = Cache::has('user-is-online-' . $user->id) ? 'active' : 'inactive';
                                @endphp
                                <img src='{{ asset("assets/images/icons/$ustatus.png") }}' class="small-image-size ml8" alt="">
                                <span class="forum-color ml4">@if(Cache::has('user-is-online-' . $user->id)) Online @else Offline @endif</span>
                            </p>
                        </div>

                        <div class="flex my8">
                            <p class="fs14 no-margin"><span class="bold">About: </span>
                                    @if($user->about)
                                    <span class="forum-color ml8">
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
                            <p class="fs14 no-margin"><span class="bold">Username: </span><span class="forum-color ml8">{{ $user->username }}</span></p>
                        </div>
                        <div class="flex my8">
                            <p class="fs14 no-margin">Member since: : <span class="bold forum-color ml8">{{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</span></p>
                        </div>
                    </div>
                    <div class="half-width ml4 us-user-info-container full">
                        <h3 class="m4 forum-color" style="margin-bottom: 14px">Followers</h3>
                        <div class="full-center">

                            @if(auth()->user() && $user->id == auth()->user()->id)
                                <p class="forum-color text-center">You don't have friends for the moments ! search for people and send friend requests</p>
                            @else
                                <p class="forum-color text-center">This user has no friends for the moments !</p>
                            @endif
                        </div>
                        <h3 class="m4 forum-color" style="margin-bottom: 14px">Following</h3>
                        <div class="full-center">
                            @if(auth()->user() && $user->id == auth()->user()->id)
                                <p class="forum-color text-center">You don't have any followers for the moments ! search for people to follow them !</p>
                            @else
                                <p class="forum-color text-center">This user has no followers for the moments !</p>
                            @endif
                        </div>
                    </div>
                </div>
                @if($recent_threads->count())
                <div style="margin-top: 20px">
                    <div class="flex align-center">
                        <h2>Recent Threads</h2>
                        <a href="{{ route('user.activities', ['user'=>$user->username]) }}" class="link-path move-to-right">see all</a>
                    </div>
                    @foreach($recent_threads as $thread)
                        @php
                            $is_ticked = $thread->posts->where('ticked', 1)->count();

                            $forum = $thread->forum();
                            $category = $thread->category;

                            $forum_slug = $thread->forum()->slug;
                            $category_slug = $thread->category->slug;
                        @endphp
                        <div class="my8 p4 br4" style="@if($is_ticked) background-color: #cfffcf3d; border: 1px solid #89c489bd; @endif">
                            <div class="flex align-center">
                                <img src="{{ asset('assets/images/icons/' . $forum->icon) }}" class="small-image-size mr4" alt="">
                                <div class="flex align-center">
                                    <a href="{{ route('forum.all.threads', ['forum'=>$forum_slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                                    <span class="mx4 fs13 gray">▸</span>
                                    <a href="{{ route('category.threads', ['forum'=>$forum_slug, 'category'=>$category_slug]) }}" class="fs11 black-link">{{ $category->category }}</a>
                                </div>
                                @if($is_ticked)
                                <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="ml8 small-image" alt="">
                                @endif
                            </div>
                            <div class="flex align-center">
                                <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image-2" alt="">
                                <span class="fs13 mr4">{{ $thread->votes->where('vote', '1')->count() }}</span>
                                <img src="{{ asset('assets/images/icons/down-arrow.png') }}" class="small-image-2" alt="">
                                <span class="fs13">{{ $thread->downvotes }}</span>
                                <a href="{{ route('thread.show', ['forum'=> $forum_slug, 'category'=> $category_slug, 'thread'=>$thread->id]) }}" class="link-path flex ml8">{{ $thread->subject }}</a>

                                <div class="move-to-right flex align-center">
                                    @if($lc = $thread->likes->count())
                                    <div class="flex align-center mx8">
                                        <img src="{{ asset('assets/images/icons/love-gray.png') }}" class="small-image-2 mr4" alt="">
                                        <p class="fs12 no-margin">{{ $lc }} likes</p>
                                    </div>
                                    @endif
                                    @if($pc = $thread->posts->count())
                                    <div class="flex align-center mx8">
                                        <img src="{{ asset('assets/images/icons/disc.png') }}" class="small-image-2 mr4" alt="">
                                        <p class="fs12 no-margin">{{ $pc }} replies</p>
                                    </div>
                                    @endif
                                    <div class="flex align-center mx8">
                                        <img src="{{ asset('assets/images/icons/gray-eye.png') }}" class="small-image-2 mr4" alt="">
                                        <p class="fs12 no-margin">{{ $thread->view_count }} {{ __('views') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="simple-line-separator my4"></div>
                        </div>
                    @endforeach
                </div>
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