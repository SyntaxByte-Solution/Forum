@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
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
    <div id="middle-container" class="middle-padding-1" style="width: 75%; margin: 0 auto;">
        <div class="flex">
            <div class="full-width">
                <div class="flex space-between full-width align-end" style="margin-bottom: 20px">
                    <div>
                        <a href="/" class="link-path">{{ __('Board index') }} > </a>
                        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path">{{ $forum->forum }} > </a>
                        <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="link-path">{{ $category->category }}</a>
                    </div>
                    <div>
                        <a href="{{ route('thread.add') }}" class="button-style-1 @guest login-signin-button @endguest">{{ __('Create a thread') }}</a>
                    </div>
                </div>

                <x-index-resource :thread="request()->thread"/>

                @if($thread->replies_off)
                    <p class="fs13 text-center">{{ __('The owner of this thread turned off replies') }}</p>
                @else
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
                            <p class="error frt-error reply-content-error" id="global-error" role="alert"></p>
                            <textarea name="subject" class="reply-content" id="post-reply"></textarea>
                            <style>
                                .CodeMirror,
                                .CodeMirror-scroll {
                                    max-height: 160px;
                                    min-height: 160px;
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

                                    display: flex;
                                    align-items: center;
                                }
                                .editor-toolbar .fa-arrows-alt {
                                    margin-left: auto;
                                }
                                .editor-statusbar {
                                    border-radius: 0px;
                                }

                                .fa-question-circle, .fa-link, .fa-picture-o, .fa-link {
                                    display: none !important;
                                }

                                .share-post-form .separator:nth-of-type(2) {
                                    display: none !important;
                                }
                            </style>
                        </div>
                        <input type="hidden" name="thread_id" class="thread_id" value="{{ request()->thread->id }}">
                        <input type='button' class="inline-block button-style @auth share-post @endauth @guest login-signin-button @endguest" value="Post your reply">
                    </div>
                </div>
                @endif
                
                <div class="flex space-between align-end replies_header_after_thread @if($posts->count() == 0) none @endif" id="thread-show-replies-section">
                    <p class="bold fs20" style="margin-top: 30px"><span class="thread-replies-number">@if($tickedPost) {{ $posts->total() + 1 }} @else {{ $posts->total() }} @endif</span> Replies</p>
                    <div>
                        {{ $posts->onEachSide(0)->links() }}
                    </div>
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
                <script>
                    $('textarea').each(function() {
                        var simplemde = new SimpleMDE({
                            element: this,
                            placeholder: "{{ __('Your reply here') }}"
                        });
                        simplemde.render();
                    });
                </script>
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.thread.right-panel', ['thread_type'=>'threads'])
    </div>
@endsection