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
                        @if($users->total() > 4)
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
            </div>
            <div>
                <div class="flex space-between align-end my8">
                    <div>
                        <div class="flex align-center my8">
                            <div class="flex align-center mr8">
                                <p class="no-margin mr4">{{__('Forums')}}: </p>
                                <div class="relative">
                                    <a href="{{ route('forum.all.threads', ['forum'=>'general']) }}" class="flex mr4 button-right-icon more-icon button-with-suboptions" style="padding: 6px 26px 6px 10px; font-size: 12px">{{ __('All') }}</a>
                                    <div class="suboptions-container suboptions-buttons-b-style">
                                        @foreach($forums as $forum)
                                            <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="suboption-b-style">{{ $forum->forum }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex align-center move-to-right">
                            <a href="/" class="pagination-item pag-active @if(!request()->has('tab')) pagination-item-selected @endif bold">Interesting</a>
                            <a href="?tab=today" class="pagination-item pag-active bold @if($t = request()->has('tab')) @if(request()->get('tab') == 'today') pagination-item-selected @endif @endif">Today</a>
                            <a href="?tab=thisweek" class="pagination-item pag-active bold @if($t = request()->has('tab')) @if(request()->get('tab') == 'thisweek') pagination-item-selected @endif @endif">This week</a>
                        </div>
                    </div>
                    <div>
                        <div class="flex">
                            <div class="flex align-center my4 move-to-right">
                                <span class="mr4 fs13 gray">Discussions/Page :</span>
                                <select name="" class="small-dropdown row-num-changer">
                                    <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                    <option value="20" @if($pagesize == 20) selected @endif>20</option>
                                    <option value="50" @if($pagesize == 50) selected @endif>50</option>
                                </select>
                            </div>
                        </div>
                        {{ $threads->onEachSide(0)->links() }}
                    </div>
                </div>
                <div id="threads-global-container">
                    @foreach($threads as $thread)
                        <x-index-resource :thread="$thread"/>
                    @endforeach
                </div>
                @if(!$threads->count())
                    <div class="full-center">
                        <div>
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("No threads matched your search !") }}</p>
                            <p class="my4 text-center">{{ __("Try to create a new ") }} <a href="{{ route('thread.add') }}" class="link-path">{{__('thread')}}</a></p>
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