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
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div class="full-center">
                <img src="{{ asset('assets/images/logos/mg.png') }}" class="half-width" alt="">
            </div>
            <div>
                <div class="flex space-between align-end">
                    <div>
                        <h2 class="my8 fs20 forum-color">TOP Questions & Discussions</h2>
                        <p class="fs12 no-margin mt8" style="margin-bottom: 2px">{{ __('Search for everything (users, threads, posts ..)') }}</p>
                        <div class="flex align-center">
                            <div>
                                <form action="" method='get'>
                                    <input type="text" name="k" class="input-style-2" placeholder="Search this forum .." required>
                                    <input type="submit" value="" class="search-forum-button" style="margin-left: -8px">
                                </form>
                            </div>
                            <a href="" class="ml4">
                                <img src="{{ asset('assets/images/icons/bsettings.png') }}" class="adv-search-button" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="mr8">
                        {{ $threads->onEachSide(0)->links() }}
                        <div class="simple-half-line-separator my4"></div>
                        <div class="flex align-center">
                            <a href="" class="pagination-item pag-active pagination-item-selected bold">ALL</a>
                            <a href="" class="pagination-item pag-active bold">TODAY</a>
                            <a href="" class="pagination-item pag-active bold">INTERESTING  </a>
                        </div>
                    </div>
                </div>
                <table class="forums-table">
                    <tr>
                        <th class="table-col-header">
                            <div class="flex align-center">
                                {{ __('THREADS') }} ({{\App\Models\Thread::count()}} {{__('in total')}})
                                <div class="mx4 inline-block move-to-right">
                                    <div class="flex align-center">
                                        <span>rows: </span>
                                        <select name="" class="small-dropdown row-num-changer">
                                            <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                            <option value="20" @if($pagesize == 20) selected @endif>20</option>
                                            <option value="50" @if($pagesize == 50) selected @endif>50</option>
                                            <option value="100" @if($pagesize == 100) selected @endif>50</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th class="table-col-header table-numbered-column">{{ __('REPLIES/VIEWS') }}</th>
                        <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
                    </tr>
                    @foreach($threads as $thread)
                        <x-index-resource :thread="$thread"/>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="index-right-panel-container border-box">
            <div class="index-right-panel">
                <div class="flex align-center mx8">
                    <div class="flex align-center">
                        <img src="{{ asset('assets/images/icons/community.svg') }}" class="small-image mr4" alt="">
                        <p class="bold my8">{{ __('Forums') }}</p>
                    </div>
                    <div class="move-to-right">
                        <a href="" class="link-style">see all</a>
                    </div>
                </div>
                <div class="simple-line-separator mb8"></div>
                <div class="ml8">
                    @foreach($forums as $forum)
                    <div class="my8">
                        <a href="" class="black bold toggle-container-button no-underline">{{ $forum->forum }}<span class="toggle-arrow">▸</span></a>
                        <div class="toggle-container ml8">
                            @foreach($forum->categories as $category)
                            <div class="my8">
                                <a href="{{ route('category.misc', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="blue fs13 no-underline">{{ $category->category }}</a>
                            </div>
                            @endforeach
                        </div>
                    </div>    
                    @endforeach
                </div>
            </div>
            <div class="index-right-panel mt8">
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
                                            <p class="fs11 no-margin" style="margin-right: 2px">0</p>
                                            <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image-size" alt="">
                                        </div>

                                        <div class="flex align-center">
                                            <p class="fs11 no-margin" style="margin-right: 2px">0</p>
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
@endsection