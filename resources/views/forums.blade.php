@extends('layouts.app')

@section('title', 'MG Forums')

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
    @include('partials.left-panel', ['page' => 'forums'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div>
            <div class="flex align-center space-between full-width border-box">
                <div>
                    <a href="/" class="link-path">{{ __('Board index') }} > </a>
                    <a href="/forums" class="link-path">{{ __('Forums') }}</a>
                    <!--<span class="current-link-path">The side effects of using glutamin</span>-->
                </div>
                @auth
                    <div class="flex align-center">
                        <p class="mr8 fs13 gray">Add: </p>
                        <a href="{{ route('discussion.add', ['forum'=>'general']) }}" class="button-style-1 flex">{{ __('Discussion') }}</a>
                        <div class="mx4 fs11">or</div>
                        <a href="{{ route('question.add', ['forum'=>'general']) }}" class="button-style-1 flex">{{ __('Question') }}</a>
                    </div>
                @endauth
            </div>
            <div class="half-width my8">
                <img src="{{ asset('assets/images/img/forums.png') }}" class="full-width br6" alt="">
            </div>
            <div id="forums-section" style='padding-top: 0'>
                <div>
                    @if(Session::has('message'))
                        <div class="green-message-container">
                            <p class="green-message">{{ Session::get('message') }}</p>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="error-message-container">
                            <p class="error-message">{{ Session::get('error') }}</p>
                        </div>
                    @endif
                </div>
                <div class="flex align-center">
                    <img src="" class="" alt="">
                    <h1 id="page-title">Forums</h1>
                </div>
                <table class="forums-table">
                    <tr>
                        <th class="table-col-header">{{ __('ALL FORUMS') }}</th>
                        <th class="table-col-header table-numbered-column">{{ __('THREADS') }}</th>
                        <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                        <th class="table-col-header table-last-post">{{ __('LAST THREAD') }}</th>
                    </tr>
                    @foreach($forums as $forum)
                        <x-forum-table-row :forum="$forum"/>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="index-right-panel-container border-box">
            <div class="index-right-panel">
                <div class="flex align-center mx8">
                    <img src="{{ asset('assets/images/icons/clock.svg') }}" class="small-image mr4" alt="">
                    <p class="bold my8">{{ __('Recent threads') }}</p>
                </div>
                <div class="simple-line-separator my8"></div>
                @foreach($recent_threads as $thread)
                <div class="my8">
                    <div>
                        <div class="flex align-center">
                            <a href="{{ route('forum.misc', ['forum'=>$thread->forum()->slug]) }}" class="blue no-underline fs11">{{ $thread->forum()->forum }}</a>
                            <span class="mx4 bold fs12">▸</span>
                            <a href="{{ route('category.misc', ['forum'=>$thread->forum()->slug, 'category'=>$thread->category->slug]) }}" class="blue no-underline fs11">{{ $thread->category->category }}</a>
                        </div>
                        <div class="flex">
                            <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}">
                                <img src="{{ $thread->user->avatar }}" class="small-image-3 rounded mr4" alt="">
                            </a>
                            <div class="full-width">
                                <a href="{{ route('thread.show', ['forum'=>$thread->forum()->slug, 'category'=>$thread->category->slug, 'thread'=>$thread->id]) }}" class="no-margin bold no-underline forum-color fs13">{{ $thread->subject }}</a>
                                <div class="flex align-center mt4">
                                    <div class="flex align-center">
                                        <img src="{{ asset('assets/images/icons/eye.png') }}" class="small-image-size mr4" alt="">
                                        <p class="fs11 no-margin">{{ $thread->view_count }}</p>
                                    </div>

                                    <div class="flex align-center ml8">
                                        <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-size mr4" alt="">
                                        <p class="fs11 no-margin">{{ $thread->posts->count() }}</p>
                                    </div>

                                    <div class="move-to-right flex">
                                        <div class="flex align-center mr8">
                                            <p class="fs11 no-margin" style="margin-right: 2px">{{ $thread->upvotes }}</p>
                                            <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image-size" alt="">
                                        </div>

                                        <div class="flex align-center">
                                            <p class="fs11 no-margin" style="margin-right: 2px">{{ $thread->downvotes }}</p>
                                            <img src="{{ asset('assets/images/icons/down-arrow.png') }}" class="small-image-size" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                @if(!$loop->last)
                    <div class="simple-half-line-separator my8"></div>
                @endif
                @endforeach
            </div>
            <div class="index-right-panel mt8">
                <div class="flex align-center mx8">
                    <img src="{{ asset('assets/images/icons/statistics.svg') }}" class="small-image mr4" style="margin-top: -3px" alt="">
                    <p class="bold my8">{{ __('Statistics') }}</p>
                </div>
                <div class="simple-line-separator my4"></div>
                <div class="flex">
                    <img src="{{ asset('assets/images/icons/thread.svg') }}" class="small-image-2 mr4" alt="">
                    <p class="my4 fs13">Total forums threads: {{ \App\Models\Thread::count() }}</p>
                </div>
                <div class="flex align-center my4">
                    <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-2 mr4" alt="">
                    <p class="my4 fs13">Total replies: {{ \App\Models\Post::count() }}</p>
                </div>
                <div class="mt8 my4">
                    <div class="flex">
                        <img src="{{ asset('assets/images/icons/user.svg') }}" class="small-image-2 mr4" alt="" style="margin-top:1px">
                        <div>
                            <p class="no-margin mt4 fs13">Total members: {{ \App\Models\User::count() }}</p>
                            @php
                                $last_user_username = \App\Models\User::orderBy('created_at')->first()->username;
                            @endphp
                            <p class="fs11 no-margin">Our newest member: <a href="{{ route('user.profile', ['user'=>$last_user_username]) }}" class="link-style inline-block fs12 bold">{{$last_user_username}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        
    </div>
@endsection