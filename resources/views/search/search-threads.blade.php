@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.thread.viewer')
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'threads-search'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width index-middle-width middle-container-style">
            <div>
                <a href="/" class="link-path">{{ __('Board index') }} > </a>
                <a href="/search" class="link-path">{{ __('Search') }} > </a>
                <span class="current-link-path">{{ __('Threads search') }}</span>
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
            <h2 class="fs20 flex align-center gray">Threads search results for: "<span class="black">{{ $search_query }}</span>" ({{$threads->total()}} {{__('found')}})</h2>
            @endif
            <div class="simple-line-separator my8"></div>
            <h2 class="fs20 blue unselectable my4 flex align-center">{{ __('Threads') }}</h2>
            <div>
                <div class="flex align-center space-between my4">
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