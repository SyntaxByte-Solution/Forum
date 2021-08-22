@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header', ['globalpage'=>'home'])
@endsection

@section('content')
    @include('partials.thread.viewer')
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex align-center">
            <a href="/" class="link-path flex align-center unselectable">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                {{ __('Board index') }}
            </a>
        </div>
    </div>
    <div class="index-middle-width middle-container-style">
        <input type="hidden" class="current-threads-count" autocomplete="off" value="{{ $pagesize }}">
        @if(Session::has('message'))
            <div class="green-message-container mb8">
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
        <div class="thread-add-component none">
            @auth
                @include('partials.thread.thread-add', ['editor_height'=>100])
            @endauth
        </div>
        <h1 class="fs26 forum-color my8">{{ __('Discussions and Questions') }}</h1>
        <div class="flex space-between stick-after-header">
            <div class="relative">
                <div class="flex align-center forum-color button-with-suboptions pointer fs13 py4">
                    <span class="mr4 gray">{{ __('Filter by date') }}:</span>
                    <span class="forum-color fs13 bold">{{ __($tab_title) }}</span>
                    <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                </div>
                <div class="suboptions-container thread-add-suboptions-container" style="width: 220px">
                    <a href="/" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('All') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get all threads sorted by the newest created threads') }}</p>
                            <input type="hidden" class="tab" value="all">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                    <a href="?tab=today" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('Today') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get only threads created today') }}</p>
                            <input type="hidden" class="tab" value="today">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                    <a href="?tab=thisweek" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('This week') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get only threads created this week') }}</p>
                            <input type="hidden" class="sort-by-key" value="votes">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                </div>
            </div>
            <a href="{{ route('advanced.search') }}" class="fs13 bold no-underline forum-color flex align-center">
                <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512,28.48A28.27,28.27,0,0,0,484,0H28.06A27.71,27.71,0,0,0,11.92,5.19,28.75,28.75,0,0,0,5.11,44.87L170.4,283.44,170.87,457A55.72,55.72,0,0,0,180,487.44a53.81,53.81,0,0,0,75.32,15.29l59-40a57.19,57.19,0,0,0,25-47.66l-.6-130.63L506.8,45A28.85,28.85,0,0,0,512,28.48ZM282.54,266.39l.68,149L227,453.45l-.5-188.1L82.09,57H429.51Z"/></svg>
                {{ __('Adv. Search') }}
            </a>
        </div>
        <div id="threads-global-container">
            @foreach($threads as $thread)
                <x-index-resource :thread="$thread"/>
            @endforeach
        </div>
        @include('partials.thread.faded-thread', ['classes'=>'index-fetch-more'])
        @if(!$threads->count())
            <div class="full-center">
                <div>
                    <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("There are no threads for the moment try out later !") }}</p>
                    <p class="my4 text-center">{{ __("Try to create a new ") }} <a href="{{ route('thread.add') }}" class="link-path">{{__('thread')}}</a></p>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <!-- <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script> -->
        <script>
        // window.googletag = window.googletag || {cmd: []};
        // googletag.cmd.push(function() {
        //     googletag
        //         .defineSlot(
        //             '/6355419/Travel/Europe/France/Paris', [300, 250], 'banner-ad')
        //         .addService(googletag.pubads());
        //     googletag.enableServices();
        // });
        </script>
    @endpush
    <div id="right-panel">
        @include('partials.right-panels.forums-list')
        @include('partials.right-panels.recent-forum-threads')
        @include('partials.right-panels.statistics')
        <div class="line-separator"></div>
        <div id="banner-ad" style="width: 300px; height: 250px; margin: 0 auto" class="full-center">
            <h2>ADS HERE</h2>
            <script>
                // googletag.cmd.push(function() {
                // googletag.display('banner-ad');
                // });
            </script>
        </div>
        @include('partials.right-panels.feedback')
    </div>
@endsection