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
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'search'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div class="flex">
                <div>
                    <h1 id="page-title" class="my8 fs28 forum-color">{{ __('Explore threads, users..') }}</h1>
                </div>
            </div>
            <div>
                <form action="{{ route('search') }}" method='get' class="flex align-end full-width">
                    <div class="full-width">
                        <div class="flex align-end space-between">
                            <label for='main-srch' class="fs12 no-margin mt8" style="margin-bottom: 2px">{{ __('Search for everything (threads, users ..)') }}</label>
                            <a href="{{ route('advanced.search') }}" class="link-path">Advanced search</a>
                        </div>    
    
                        <input type="text" id="main-srch" name="k" class="input-style-1 full-width" value="{{ request()->input('k') }}" placeholder="Search everything .." required>
                    </div>
                    <input type="submit" class="ml8 button-style-1" style="padding: 9px 12px" value="{{ __('Search') }}">
                </form>
            </div>
            <div class="simple-line-separator my8"></div>
            @if($search_query != "")
            <h2 class="fs20 flex align-center gray">Search results for: "<span class="black">{{ $search_query }}</span>"</h2>
            @endif
            <div>
                @if($users->count())
                    <div class="flex space-between align-center">
                        <a href="{{ route('users.search') . '?k=' . request()->input('k') }}" class="fs20 blue bold no-underline my4 flex align-center">{{ __('Users') }}<span class="gray fs14 ml4 @if($search_query == '') none @endif">({{$users->total()}} {{__('found')}})</span></a>
                        @if($users->count() > 4)
                        <a href="" class="link-path mr4">see all</a>
                        @endif
                    </div>
                    <div class="flex flex-wrap space-between">
                        @foreach($users as $user)
                            <x-search.user :user="$user" class="half-width" style="width: calc(100% / 2 - 7.5px);"/>
                            <div class="simple-line-separator"></div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="simple-line-separator my8"></div>
            <div class="flex my8">
                <a href="{{ route('threads.search') . '?k=' . request()->input('k') }}" class="fs20 blue bold no-underline my4 flex align-center">{{ __('Threads') }}<span class="gray fs14 ml4">@isset($search_query) ({{$threads->total() . ' ' . __('found')}}) @endisset</span></a>
                <div class="move-to-right">
                    {{ $threads->appends(request()->query())->links() }}
                </div>
            </div>
            <div>
                <table class="forums-table">
                    <tr>
                        <th class="table-col-header">
                            <div class="flex align-center">
                                {{ __('THREADS') }}
                                <div class="inline-block move-to-right mr4">
                                    <div class="flex align-center">
                                        <div class="flex align-center mr8">
                                            <p class="gray fs11 no-margin mr4">Forum: </p>
                                            <div class="relative">
                                                <a href="{{ route('forum.all.threads', ['forum'=>'general']) }}" class="mr4 button-right-icon more-icon button-with-suboptions">{{ __('All') }}</a>
                                                <div class="suboptions-container suboptions-buttons-b-style" style="top: 16px">
                                                    @foreach($forums as $forum)
                                                        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="suboption-b-style">{{ $forum->forum }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex align-center">
                                            <span>rows: </span>
                                            <select name="" class="small-dropdown row-num-changer">
                                                <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                                <option value="20" @if($pagesize == 20) selected @endif>20</option>
                                                <option value="50" @if($pagesize == 50) selected @endif>50</option>
                                            </select>
                                        </div>
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
                @if(!$threads->count())
                    <div class="full-center">
                        <div>
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("No threads matched your search !") }}</p>
                            <p class="my4 text-center">{{ __("Try to create a new ") }} <a href="{{ route('thread.add', ['forum'=>$forums->first()->slug, 'category'=>$forums->first()->categories->first()->slug]) }}" class="link-path">{{__('thread')}}</a></p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forums-list')
        @include('partials.right-panels.recent-forum-threads')
    </div>
@endsection