@extends('layouts.app')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
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
    @include('partials.thread.viewer')
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'search'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div class="index-middle-width middle-container-style">
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
                <h2 class="fs20 flex align-center gray">{{ __('Search results for') }}: "<span class="black">{{ $search_query }}</span>"</h2>
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
                            <div class="flex inline-buttons-container" style="border: 1px solid #c6c6c6; border-right: unset;">
                                <a href="/" class="flex no-underline inline-button-style @if(!request()->has('tab')) selected-inline-button-style @endif">
                                        {{ __('All') }}
                                </a>
                                <a href="?tab=today" class="flex inline-button-style no-underline @if(request()->has('tab') && request()->get('tab') == 'today') selected-inline-button-style @endif">
                                    {{ __('Today') }}
                                </a>
                                <a href="?tab=thisweek"  class="flex inline-button-style no-underline @if(request()->has('tab') && request()->get('tab') == 'thisweek') selected-inline-button-style @endif">
                                    {{ __('This week') }}
                                </a>
                            </div>
                            <div>
                                <div class="flex">
                                    <div class="flex align-center my4 move-to-right">
                                        <span class="mr4 fs13 gray">posts/page :</span>
                                        <select name="" class="small-dropdown row-num-changer" autocomplete="off">
                                            <option value="6" @if($pagesize == 6) selected @endif>6</option>
                                            <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                            <option value="16" @if($pagesize == 16) selected @endif>16</option>
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
                    <div class="flex my8">
                        <div class="move-to-right">
                            {{ $threads->onEachSide(0)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forums-list')
        @include('partials.right-panels.recent-forum-threads')
    </div>
@endsection