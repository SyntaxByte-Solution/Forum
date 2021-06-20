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
                    <form action="{{ route('thread.delete', ['thread'=>$thread->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" class="button-style mr8" value='DELETE'>
                    </form>
                    <p class="fs12">{{ __('This will throw the thread to the trash. However It will not be deleted completely, you can restore it later if you want by going to your archive and select the thread to restore it !') }}</p>
                </div>
                <div class="half-width my8 mx4">
                    <form action="{{ route('thread.destroy', ['thread'=>$thread->id]) }}" method="post">
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
    
    @include('partials.left-panel', ['page' => 'threads'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex">
            <div class="full-width">
                <div class="flex space-between full-width align-end">
                    <div>
                        <a href="/" class="link-path">{{ __('Board index') }} > </a>
                        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path">{{ $forum->forum }} > </a>
                        <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="link-path">{{ $category->category }}</a>
                    </div>
                    <div>
                        <a href="{{ route('thread.add', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="button-style-1 @guest login-signin-button @endguest">{{ __('Create a thread') }}</a>
                    </div>
                </div>
                <x-thread-component :thread="request()->thread"/>

                @if($thread->status->slug == 'posts-turn-off')
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
                                    max-height: 150px;
                                    min-height: 150px;
                                }
                            </style>
                        </div>
                        <input type="hidden" name="thread_id" class="thread_id" value="{{ request()->thread->id }}">
                        <input type='button' class="inline-block button-style @auth share-post @endauth @guest login-signin-button @endguest" value="Post your reply">
                    </div>
                </div>
                @endif
                
                <div class="flex space-between align-end replies_header_after_thread @if($posts->count() == 0) none @endif">
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
                    <div class="flex">
                        <div class="move-to-right">
                            {{ $posts->onEachSide(0)->links() }}
                        </div>
                    </div>
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
            @include('partials.thread.right-panel', ['thread_type'=>'threads'])
        </div>
    </div>
@endsection