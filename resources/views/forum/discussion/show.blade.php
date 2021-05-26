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
    @include('partials.hidden-login-viewer')
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex space-between full-width">
            <div>
                <a href="/" class="link-path">{{ __('Board index') }} > </a>
                <a href="" class="link-path">{{ $forum_name }} > </a>
                <span class="current-link-path">{{ $thread_subject }}</span>
            </div>
            @auth
            <div>
                <a href="{{ route('discussion.add', ['forum'=>'general']) }}" class="button-style">{{ __('Start Discussion') }}</a>
            </div>
            @endauth
        </div>
        <x-thread/>
        <!-- listing related posts -->
        <div>
            <p class="fs17">Your reply</p>
            <form action="" method="POST">
                @csrf
                <textarea name="" id=""></textarea>
                <input type="submit" value="Post your reply">
            </form>
        </div>
    </div>
@endsection