@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.11.2/simplemde.min.js"></script>
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="{{ asset('js/search.js') }}" defer></script>
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
                <h2 class="fs20 flex align-center gray">{{__('Threads search results for')}}: "<span class="black">{{ $search_query }}</span>" ({{$threads->total()}} {{__('found')}})</h2>
                @if(isset($filters) && count($filters))
                <style>
                    .adv-search-filter-item {
                        position: relative;
                        display: flex;
                        align-items: center;
                        flex-wrap: wrap;
                        padding: 4px 26px 4px 8px;
                        margin: 3px;
                        border-radius: 3px;
                        background-color: #eee;
                        border: 1px solid #d5d5d5;

                        transition: all 1s ease;
                    }

                    .adv-search-filter-item:hover {
                        background-color: #d5d5d5;
                    }

                    .adv-search-remove-filter {
                        position: absolute;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        right: 4px;
                        border-radius: 50%;
                        cursor: pointer;

                        background-color: #353535;
                        color: white;
                    }
                </style>
                <div>
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511"><path d="M492,0H21A20,20,0,0,0,1,20,195,195,0,0,0,66.37,165.55l87.42,77.7a71.1,71.1,0,0,1,23.85,53.12V491a20,20,0,0,0,31,16.6l117.77-78.51a20,20,0,0,0,8.89-16.6V296.37a71.1,71.1,0,0,1,23.85-53.12l87.41-77.7A195,195,0,0,0,512,20,20,20,0,0,0,492,0ZM420.07,135.71l-87.41,77.7a111.1,111.1,0,0,0-37.25,83V401.82l-77.85,51.9V296.37a111.1,111.1,0,0,0-37.25-83L92.9,135.71A155.06,155.06,0,0,1,42.21,39.92H470.76A155.06,155.06,0,0,1,420.07,135.71Z"/></svg>
                        <p class="bold gray my4">{{ __('Your search filters') }} :</p>
                    </div>
                    <div class="ml8 flex flex-wrap">
                        @foreach($filters as $filter)
                        <div class="adv-search-filter-item">
                            <p class="no-margin fs12 bold blue unselectable">{{ $filter[0] }}</p>
                            <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                            <p class="no-margin fs12 bold unselectable">{{ $filter[1] }}</p>
                            <input type="hidden" class="removed-filter" autocomplete="off" value="{{ $filter[2] }}">
                            <div class="size17 adv-search-remove-filter">
                                <span class="fs12">✖</span>
                            </div>
                        </div>
                        @endforeach

                        <script>
                            let forum_exists = category_exists = false;
                            let forum;
                            $('.removed-filter').each(function() {
                                if($(this).val() == 'forum') {
                                    forum = $(this).parent().find('.adv-search-remove-filter');
                                    forum_exists = true;
                                }
                                if($(this).val() == 'category') {
                                    category_exists = true;
                                }
                            });

                            if(forum_exists && category_exists) {
                                forum.parent().css('padding-right', '8px')
                                forum.remove();
                            }
                        </script>
                    </div>
                </div>
                @endif
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