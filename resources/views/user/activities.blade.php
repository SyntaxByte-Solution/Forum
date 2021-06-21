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
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.activities'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page'=>'activities'])
                <div class="flex space-between">
                    @if($is_current)
                    <h2 class="my8 fs26">My Activities</h2>
                    @else
                    <h2 class="my8 fs26">{{ $user->username }} activities</h2>
                    @endif
                </div>
                <div class="simple-line-separator my8"></div>
                <div>
                    <div class="flex flex-end space-between">
                        <p class="no-margin my8 fs17 bold forum-color">Threads ({{$threads->total()}})</p>
                        <div class="mr8">
                            @unless($all)
                                {{ $threads->onEachSide(0)->links() }}
                            @endunless
                        </div>
                    </div>
                    @foreach($threads as $thread)
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
                @if(!$threads->total())
                    <div class="full-center">
                        <div>
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any discussions or question for the moment !") }}</p>
                            @php
                                $forum = \App\Models\Forum::first();
                                $forum_slug = $forum->slug;
                                $category_slug = $forum->categories->first()->slug;
                            @endphp
                            <p class="my4 text-center">{{ __("Try to create a new ") }} <a href="{{ route('thread.add', ['forum'=>$forum_slug, 'category'=>$category_slug]) }}" class="link-path">{{__('thread')}}</a></p>
                        </div>
                    </div>
                @endif
                <div class="flex">
                    <div class="half-width">
                        <p class="no-margin my8 fs17 bold forum-color">Voted Threads ({{$voted_threads->count()}})</p>
                        @foreach($voted_threads as $voted)
                            @php
                                $forum_slug = $voted[0]->forum()->slug;
                                $category_slug = $voted[0]->category->slug;
                            @endphp
                            <div class="flex align-center my8">
                                @if($voted[1] == 1)
                                <img src="{{ asset('assets/images/icons/up-filled.png') }}" class="small-image-2" alt="">
                                <span class="fs13 mr4">{{ $voted[0]->votes->where('vote', '1')->count() }}</span>
                                @else
                                <img src="{{ asset('assets/images/icons/down-filled-red.png') }}" class="small-image-2" alt="">
                                <span class="fs13">{{ $voted[0]->votes->where('vote', '-1')->count() }}</span>
                                @endif
                                <a href="{{ route('thread.show', ['forum'=> $forum_slug, 'category'=> $category_slug, 'thread'=>$voted[0]->id]) }}" class="link-path flex ml8">{{ $voted[0]->subject }}</a>
                            </div>
                            <div class="simple-line-separator"></div>
                        @endforeach
                    </div>
                    <div class="half-width ml8">
                        <p class="no-margin my8 fs17 bold forum-color">Liked Threads ({{$liked_threads->count()}})</p>
                        @foreach($liked_threads as $liked)
                            <div class="flex align-center my8">
                                <img src="{{ asset('assets/images/icons/love.png') }}" class="small-image-2" alt="">
                                <a href="" class="link-path flex ml8">{{ $liked->subject }}</a>
                            </div>
                            <div class="simple-line-separator"></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div>
                @include('partials.user-space.user-card')
            </div>
        </div>
    </div>
@endsection