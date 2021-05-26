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
            <div class="share-post-form">
                @csrf
                <div class="input-container">
                    <p class="fs17" style="margin: 4px 0">
                        <label for="reply-content" class="flex">Your reply 
                            <span class="error frt-error reply-content-error">  *</span>
                        </label>
                    </p>
                    @error('subject')
                        <p class="error frt-error" role="alert">{{ $message }}</p>
                    @enderror
                    <p class="error frt-error reply-content-error" role="alert">Reply field is required</p>
                    <textarea name="subject" class="reply-content"></textarea>
                </div>
                <input type="hidden" name="thread_id" class="thread_id" value="{{ request()->thread->id }}">
                <a class="inline-block button-style share-post" href="">Post your reply</a>
            </div>
        </div>
    </div>
@endsection