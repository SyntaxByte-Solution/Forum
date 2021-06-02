@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpush


@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection
@section('content')
    @include('partials.hidden-login-viewer')
    @include('partials.left-panel', ['page' => 'questions'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex space-between full-width">
            <div>
                <a href="/" class="link-path">{{ __('Board index') }} > </a>
                <a href="{{ route('get.all.forum.discussions', ['forum'=>$forum_slug]) }}" class="link-path">{{ $forum_name }} > </a>
                <span class="current-link-path">{{ $thread_subject }}</span>
            </div>
            @auth
            <div>
                <a href="{{ route('question.add', ['forum'=>'general']) }}" class="button-style">{{ __('Ask Question') }}</a>
            </div>
            @endauth
        </div>
        <x-thread-component :thread="request()->thread"/>
        <div>
            <div class="share-post-form">
                @csrf
                <div class="input-container">
                    <div class="fs14" style="margin: 20px 0 8px 0">
                        <div class="relative">
                            <span class="absolute" id="reply-site" style="margin-top: -70px"></span>
                        </div>
                        <label for="reply-content" class="flex bold">Your reply 
                            <span class="error frt-error reply-content-error">  *</span>
                        </label>
                    </div>
                    <p class="error frt-error reply-content-error" role="alert">Reply field is required</p>
                    <textarea name="subject" class="reply-content" id="post-reply"></textarea>
                    <script>
                        var simplemde = new SimpleMDE();
                    </script>
                    <style>
                        .CodeMirror,
                        .CodeMirror-scroll {
                            max-height: 150px;
                            min-height: 150px;
                        }
                    </style>
                </div>
                <input type="hidden" name="thread_id" class="thread_id" value="{{ request()->thread->id }}">
                <a class="inline-block button-style share-post" href="">Post your reply</a>
            </div>
        </div>
        
        <p class="bold fs20" style="margin-top: 30px">{{ $posts->count() }} Replies</p>
        <div id="replies-container">
            @foreach($posts as $post)
                <x-discussion-post :post="$post->id"/>
            @endforeach
        </div>
    </div>
@endsection