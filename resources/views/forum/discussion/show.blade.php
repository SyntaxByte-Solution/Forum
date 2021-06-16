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
    <div class="fixed full-shadowed zi12 thread-deletion-viewer">
        <a href="" class="close-shadowed-view close-shadowed-view-button"></a>
        <div class="shadowed-view-section-style">
            <h2>{{ __('Please make sure you want to delete the thread !') }}</h2>
            <div class="flex">
                <div class="half-width my8 mx4">
                    <form action="{{ route('thread.delete', ['thread'=>request()->thread->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="button-style mr8" value='DELETE'>
                    </form>
                    <p class="fs12">{{ __('This will throw the thread to the trash. However It will not be deleted completely, you can restore it later if you want by going to your archive and select the thread to restore it !') }}</p>
                </div>
                <div class="half-width my8 mx4">
                    <form action="{{ route('thread.destroy', ['thread'=>request()->thread->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="button-style mr8" value='FORCE DELETE'>
                    </form>
                    <p class="fs12">{{ __('This will remove the thread completely from our system. If you choose this option the thread will be removed permanently as well as all related replies') }}</p>
                </div>
            </div>
            <div>
                <a href="" class="button-style close-shadowed-view-button move-to-right" style="display: block; text-align: center; width: 60px">Exit</a>
            </div>
        </div>
    </div>
    @include('partials.header')
@endsection
@section('content')
    
    @include('partials.left-panel', ['page' => 'discussions'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex">
            <div>
                <div class="flex space-between full-width">
                    <div>
                        <a href="/" class="link-path">{{ __('Board index') }} > </a>
                        <a href="{{ route('get.all.forum.discussions', ['forum'=>$forum_slug]) }}" class="link-path">{{ $forum_name }} > </a>
                        <span class="current-link-path">{{ $thread_subject }}</span>
                    </div>
                    @auth
                    <div>
                        <a href="{{ route('discussion.add', ['forum'=>'general']) }}" class="button-style">{{ __('Start Discussion') }}</a>
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
                            <p class="error frt-error reply-content-error" id="global-error" role="alert"></p>
                            <textarea name="subject" class="reply-content" id="post-reply"></textarea>
                            <style>
                                .CodeMirror,
                                .CodeMirror-scroll {
                                    max-height: 150px;
                                    min-height: 150px;
                                }
                            </style>
                        </div>
                        <input type="hidden" name="thread_id" class="thread_id" value="{{ request()->thread->id }}">
                        <input type='button' class="inline-block button-style share-post" value="Post your reply">
                    </div>
                </div>
                
                <p class="bold fs20" style="margin-top: 30px"><span class="thread-replies-number">{{ $posts->count() }}</span> Replies</p>
                <div id="replies-container" style="margin-bottom: 30px">
                    @foreach($posts as $post)
                        <x-discussion-post :post="$post->id"/>
                    @endforeach
                </div>
                <script>
                    $('textarea').each(function() {
                        var simplemde = new SimpleMDE({
                            element: this,
                        });
                        simplemde.render();
                    });
                </script>
            </div>
            <div class="index-right-panel-container border-box">
                <div class="index-right-panel">
                    
                </div>
            </div>
        </div>
    </div>
@endsection