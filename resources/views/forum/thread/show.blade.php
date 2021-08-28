@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/simplemde.js') }}"></script>
<script src="{{ asset('js/thread/show.js') }}" defer></script>
<script src="{{ asset('js/post.js') }}" defer></script>
@endpush


@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    @include('partials.header')
@endsection
@section('content')
    @include('partials.thread.viewer')
    @include('partials.left-panel', ['page' => 'threads'])
    @if(auth()->user() && auth()->user()->id != $thread->user->id)
        @include('partials.thread.report.thread-report')
    @endif
    @include('partials.thread.report.post-report')
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path">{{ $forum->forum . ' ' . __('Forum') }}</a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="link-path">{{ $category->category }}</a>
    </div>
    <div id="middle-container" class="index-middle-width" style="margin-bottom: 50px">
        <input type="hidden" class="page" value="thread-show">
        <div class="flex">
            <div class="full-width">

                <x-index-resource :thread="request()->thread"/>

                @if($thread->replies_off)
                    <p class="fs13 text-center">{{ __('The owner of this thread turned off replies') }}</p>
                @else
                <div>
                    <div class="share-post-form">
                        <div class="input-container">
                            <div class="fs14" style="margin: 20px 0 8px 0">
                                <div class="relative">
                                    <span class="absolute" id="reply-site" style="margin-top: -70px"></span>
                                </div>
                                <label for="reply-content" class="flex bblack bold fs16">
                                    {{__('Your reply')}} 
                                    <span class="error frt-error reply-content-error">  *</span>
                                </label>
                            </div>
                            <p class="error frt-error reply-content-error" id="global-error" role="alert"></p>
                            <textarea name="subject" class="reply-content" id="post-reply" placeholder="{{ __('Your reply here') }}.."></textarea>
                        </div>
                        <input type="hidden" name="thread_id" class="thread_id" value="{{ request()->thread->id }}">
                        <button class="inline-block button-style @auth share-post @endauth @guest login-signin-button @endguest">
                            <span class="btn-text">{{__('Post your reply')}}</span>
                            <input type="hidden" class="btn-text-no-ing" autocomplete="off" value="{{ __('Post your reply') }}">
                            <input type="hidden" class="btn-text-ing" autocomplete="off" value="{{ __('Posting your reply') }}..">
                        </button>

                    </div>
                </div>
                @endif
                
                <div class="flex space-between align-end replies_header_after_thread @if(!$tickedPost && $posts->count() == 0) none @endif" id="thread-show-replies-section">
                    <p class="bold forum-color fs18" style="margin: 30px 0 0 0"><span class="thread-replies-number thread-replies-counter">@if($tickedPost) {{ $posts->total() + 1 }} @else {{ $posts->total() }} @endif</span> Replies</p>
                    {{ $posts->onEachSide(0)->links() }}
                </div>
                <div id="replies-container" style="margin-bottom: 30px">
                    @if($tickedPost)
                    <x-post-component :post="$tickedPost->id"/>
                    @endif
                    @foreach($posts as $post)
                        <x-post-component :post="$post->id"/>
                    @endforeach
                    @if($posts->count() > 5)
                    <div class="flex">
                        <div class="move-to-right">
                            {{ $posts->onEachSide(0)->links() }}
                        </div>
                    </div>
                    @endif
                </div>
                <style>
                    .CodeMirror,
                    .CodeMirror-scroll {
                        max-height: 120px;
                        min-height: 120px;
                        border-color: #dbdbdb;
                    }
                    .CodeMirror-scroll:focus {
                        border-color: #64ceff;
                        box-shadow: 0 0 0px 3px #def2ff;
                    }
                    .editor-toolbar {
                        padding: 0 4px;
                        opacity: 0.8;
                        height: 38px;
                        border-top-color: #dbdbdb;
                        background-color: #f2f2f2;
                        display: flex;
                        align-items: center;
                    }
                    .editor-toolbar .fa-arrows-alt, .editor-toolbar .fa-columns, 
                    .fa-question-circle, .fa-link, .fa-picture-o, .fa-link,
                    .share-post-form .separator:nth-of-type(2), .editor-statusbar {
                        display: none !important;
                    }
                </style>
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.thread.right-panel', ['thread_type'=>'threads'])
    </div>
@endsection