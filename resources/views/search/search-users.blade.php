@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'users-search'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div>
                <a href="/" class="link-path">{{ __('Board index') }} > </a>
                <a href="/search" class="link-path">{{ __('Search') }} > </a>
                <span class="current-link-path">{{ __('Users search') }}</span>
            </div>
            <div class="flex">
                <div>
                    <h1 id="page-title" class="my8 fs28 forum-color">{{ __('Users Search') }}</h1>
                </div>
            </div>
            <div>
                <form action="{{ route('users.search') }}" method='get' class="flex align-end full-width">
                    <div class="full-width">
                        <label for='main-srch' class="fs12 no-margin mt8" style="margin-bottom: 2px">{{ __('Search For Users (name or username)') }}</label>
    
                        <input type="text" id="main-srch" name="k" class="input-style-1 full-width" value="{{ request()->input('k') }}" placeholder="Search everything .." required>
                    </div>
                    <input type="submit" class="ml8 button-style-1" style="padding: 9px 12px" value="{{ __('Search') }}">
                </form>
            </div>
            <div class="simple-line-separator my8"></div>
            @if($search_query != "")
            <h2 class="fs20 flex align-center gray">Search results for: "<span class="black">{{ $search_query }}</span>"</h2>
            @endif
            <div>
                @if($users->count())
                    <div class="flex space-between align-center my8">
                        <a href="{{ route('users.search') }}" class="fs20 blue bold no-underline my4 flex align-center">{{ __('Users') }}<span class="gray fs14 ml4 @if($search_query == '') none @endif">({{$users->total()}} {{__('found')}})</span></a>
                        <div class="move-to-right">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>
                    <div class="flex flex-wrap space-between">
                        @foreach($users as $user)
                            <x-search.user :user="$user" class="full-width"/>
                            <div class="simple-line-separator"></div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="simple-line-separator my8"></div>
            @if(!$users->count())
                <div class="full-center">
                    <div class="full-center flex-column">
                        <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("No Users found with your search keywords !") }}</p>
                        <p class="my4 text-center">{{ __("Search for users based on their username, firstname or lastname.") }} </p>
                        <p class="my4 text-center">{{ __("If you already have a thread that belong to that user you could go to that thread and reach his profile from there.") }} </p>
                    </div>
                </div>
            @endif
        </div>
        <div class="index-right-panel-container border-box">
            @include('partials.right-panels.forums-list')
            @include('partials.right-panels.recent-forum-threads')
        </div>
    </div>
@endsection