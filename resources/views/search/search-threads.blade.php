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
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'threads-search'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div class="flex">
                <div>
                    <div>
                        <a href="/" class="link-path">{{ __('Board index') }} > </a>
                        <a href="/search" class="link-path">{{ __('Search') }} > </a>
                        <span class="current-link-path">{{ __('Threads search') }}</span>
                    </div>
                    <!-- 
                        Here we need to know if the page loaded from advanced search; If so we need to show the user
                        the filters.
                     -->
                </div>
                <a href="{{ route('thread.add', ['forum'=>'general', 'category'=>'general-infos']) }}" class="button-style-1 flex move-to-right height-max-content">{{ __('Add a thread') }}</a>
            </div>
            <div class="flex">
                <div>
                    <h1 id="page-title" class="my8 fs28 forum-color">{{ __('Threads Search') }}</h1>
                </div>
            </div>
            <div>
                <form action="{{ route('threads.search') }}" method='get' class="flex align-end full-width">
                    <div class="full-width">
                        <div class="flex align-end space-between">
                            <label for='main-srch' class="fs12 no-margin mt8" style="margin-bottom: 2px">{{ __('Search for threads.') }}</label>
                            <a href="{{ route('advanced.search') }}" class="link-path">Advanced search</a>
                        </div>    
    
                        <input type="text" id="main-srch" name="k" class="input-style-1 full-width" value="{{ request()->input('k') }}" placeholder="{{ __('Search for threads') }}" required>
                    </div>
                    <input type="submit" class="ml8 button-style-1" style="padding: 9px 12px" value="{{ __('Search') }}">
                </form>
            </div>
            @if($search_query != "")
            <h2 class="fs20 flex align-center gray">Search results for: "<span class="black">{{ $search_query }}</span>"</h2>
            @endif
            <div class="simple-line-separator my8"></div>
            <h2 class="fs20 blue unselectable my4 flex align-center">{{ __('Threads') }}</h2>
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
                                <span class="mr4 fs13 gray">Discussion/Page :</span>
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
                            <div class="size36 sprite sprite-2-size notfound36-icon" style="margin: 16px auto 0 auto"></div>
                            <p class="fs20 bold gray my4">{{ __("No threads matched your search !") }}</p>
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