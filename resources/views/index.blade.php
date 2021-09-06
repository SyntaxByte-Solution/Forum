@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/simplemde.js') }}"></script>
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
    <div>
        <img src="{{ asset('assets/images/img/welcome.jpg') }}" class="block full-width" alt="">
    </div>
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
        <input type="hidden" class="date-tab" autocomplete="off" value="{{ $tab }}">
        @if(Session::has('message'))
            <div class="green-message-container mb8">
                <p class="green-message">{{ Session::get('message') }}</p>
            </div>
        @endif
        <h1 class="fs26 forum-color" style="margin: 12px 0">{{ __('Sports Discussions') }}</h1>
        <div class="flex align-center space-between mb4">
            <div class="flex align-center">
                @auth
                <div class="flex align-center button-style-2 mr8 thread-add-display-toggler">
                    <svg class="size14" style="margin-right: 6px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M402.29,237.71v36.58A13.76,13.76,0,0,1,388.57,288H288V388.57a13.76,13.76,0,0,1-13.71,13.72H237.71A13.76,13.76,0,0,1,224,388.57V288H123.43a13.76,13.76,0,0,1-13.72-13.71V237.71A13.76,13.76,0,0,1,123.43,224H224V123.43a13.76,13.76,0,0,1,13.71-13.72h36.58A13.76,13.76,0,0,1,288,123.43V224H388.57A13.76,13.76,0,0,1,402.29,237.71ZM512,54.86V457.14A54.87,54.87,0,0,1,457.14,512H54.86A54.87,54.87,0,0,1,0,457.14V54.86A54.87,54.87,0,0,1,54.86,0H457.14A54.87,54.87,0,0,1,512,54.86ZM457.14,450.29V61.71a6.87,6.87,0,0,0-6.85-6.85H61.71a6.87,6.87,0,0,0-6.85,6.85V450.29a6.87,6.87,0,0,0,6.85,6.85H450.29A6.87,6.87,0,0,0,457.14,450.29Z"/></svg>
                    <span class="unselectable">{{ __('Add a discussion') }}</span>
                </div>
                @endauth
                <div class="relative">
                    <div class="flex align-center">
                        <div class="flex align-center forum-color button-with-suboptions pointer br4 light-grey-hover" style="padding: 4px 6px;">
                            <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path d="M438.09,273.32h-39.6a102.92,102.92,0,0,1,6.24,35.4V458.37a44.18,44.18,0,0,1-2.54,14.79h65.46A44.4,44.4,0,0,0,512,428.81V347.23A74,74,0,0,0,438.09,273.32ZM107.26,308.73a102.94,102.94,0,0,1,6.25-35.41H73.91A74,74,0,0,0,0,347.23v81.58a44.4,44.4,0,0,0,44.35,44.35h65.46a44.17,44.17,0,0,1-2.55-14.78Zm194-73.91H210.74a74,74,0,0,0-73.91,73.91V458.38a14.78,14.78,0,0,0,14.78,14.78H360.39a14.78,14.78,0,0,0,14.78-14.78V308.73A74,74,0,0,0,301.26,234.82ZM256,38.84a88.87,88.87,0,1,0,88.89,88.89A89,89,0,0,0,256,38.84ZM99.92,121.69a66.44,66.44,0,1,0,66.47,66.47A66.55,66.55,0,0,0,99.92,121.69Zm312.16,0a66.48,66.48,0,1,0,66.48,66.47A66.55,66.55,0,0,0,412.08,121.69Z"/>
                            </svg>
                            <span class="forum-color bold">{{ __('All forums') }}</span>
                            <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                        </div>
                        <div class="suboptions-container thread-add-suboptions-container" style="max-height: 236px; overflow-y: scroll">
                            @foreach($forums as $forum)
                                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="thread-add-suboption black no-underline flex align-center">
                                    <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        {!! $forum->icon !!}
                                    </svg>
                                    <span>{{ __($forum->forum) }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative mr4">
                <div class="flex align-center forum-color button-with-suboptions pointer fs13 py4">
                    <span class="mr4 gray unselectable">{{ __('Filter by date') }}:</span>
                    <span class="forum-color fs13 bold unselectable">{{ __($tab_title) }}</span>
                    <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                </div>
                <div class="suboptions-container thread-add-suboptions-container" style="width: 220px">
                    <a href="/" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('All') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get all discussions sorted by the newest created') }}</p>
                            <input type="hidden" class="tab" value="all">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                    <a href="?tab=today" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('Today') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get only discussions created today. (This will be sorted by number of views)') }}</p>
                            <input type="hidden" class="tab" value="today">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                    <a href="?tab=thisweek" class="no-underline thread-add-suboption sort-by-option flex">
                        <div>
                            <p class="no-margin sort-by-val bold forum-color">{{ __('This week') }}</p>
                            <p class="no-margin fs12 gray">{{ __('Get only discussions created this week. (This will be sorted by number of views)') }}</p>
                            <input type="hidden" class="sort-by-key" value="votes">
                        </div>
                        <div class="loading-dots-anim ml4 none">•</div>
                    </a>
                </div>
            </div>
        </div>
        @auth
        <div id="thread-add-component" class="none" style="margin-bottom: 10px">
            @auth
                @include('partials.thread.thread-add', ['editor_height'=>170])
            @endauth
            <div class="simple-line-separator" style="margin: 12px 0"></div>
        </div>
        @endauth
        <div id="threads-global-container">
            @foreach($threads as $thread)
                <x-index-resource :thread="$thread"/>
            @endforeach
        </div>
        @if(!$threads->count())
            <div class="full-center">
                <div class="flex flex-column align-center">
                    <svg class="size48 my8" viewBox="0 0 442 442"><path d="M442,268.47V109.08a11.43,11.43,0,0,0-.1-1.42,2.51,2.51,0,0,0,0-.27,10.11,10.11,0,0,0-.29-1.3v0c-.1-.31-.21-.62-.34-.92l-.12-.26-.15-.32c-.17-.34-.36-.67-.56-1a.57.57,0,0,1-.08-.13,10.33,10.33,0,0,0-.81-1l-.17-.18a8,8,0,0,0-.84-.81l-.14-.12a9.65,9.65,0,0,0-1.05-.76l-.26-.15a8.61,8.61,0,0,0-1.05-.53.67.67,0,0,0-.12-.06l-236-99-.06,0-.28-.1a10,10,0,0,0-4.4-.61h-.08a10.59,10.59,0,0,0-1.94.39l-.12,0c-.27.09-.55.18-.82.29l0,0-69.22,29a10,10,0,0,0,0,18.44L186,74.73v88.16L6.13,238.37l-.36.17-.36.17c-.28.15-.55.31-.82.48l-.13.07s0,0,0,0a9.86,9.86,0,0,0-1,.72l-.09.08c-.25.23-.49.46-.72.71l-.2.22a8.19,8.19,0,0,0-.53.67c-.07.08-.13.17-.19.25-.18.27-.34.54-.5.81l-.09.15c-.17.33-.32.67-.46,1,0,.09-.07.19-.1.28-.09.26-.18.53-.25.79l-.09.35c-.06.28-.12.55-.16.83,0,.1,0,.19,0,.28A11.87,11.87,0,0,0,0,247.62V333a10,10,0,0,0,6.13,9.22l235.92,99a9.8,9.8,0,0,0,1.95.6l.19,0c.26.05.52.09.79.12s.66.05,1,.05.67,0,1-.05.53-.07.79-.12l.19,0a9.8,9.8,0,0,0,2-.6l186-78A10,10,0,0,0,442,354V268.47ZM330.23,300.4l-63.15-26.49a10,10,0,0,0-7.74,18.44l45,18.9L246,335.75,137.62,290.29l58.4-24.5,35.53,14.9a10,10,0,1,0,7.74-18.44l-33.27-14V184.58l200.13,84ZM186,248.29l-74.25,31.16L35.85,247.59l150.17-63v63.71ZM196,20.84,406.15,109l-43.37,18.2L200,58.89l-.09,0L152.65,39Zm162.82,126.4a10,10,0,0,0,7.81,0L422,124.05V253.51L206,162.89V83.13ZM20,262.63l216,90.62V417L20,326.34ZM422,347.3,256,417V353.25l166-69.66Z"/></svg>
                    <p class="fs20 bold gray text-center" style="margin: 2px 0">{{ __("There are no discussions at the moment try out later or change the date filter") }}</p>
                    <p class="my4 text-center">{{ __("Try to create a new") }} <a href="{{ route('thread.add') }}" class="link-path">{{__('discussion')}}</a></p>
                </div>
            </div>
        @else
            @include('partials.thread.faded-thread', ['classes'=>'index-fetch-more'])
        @endif
    </div>

    <div id="right-panel">
        @include('partials.right-panels.forums-list')
        @include('partials.right-panels.recent-forum-threads')
        @include('partials.right-panels.statistics')
        <!-- <div class="line-separator"></div>
        <div style="width: 300px; height: 250px; margin: 0 auto" class="full-center">
            <h2>ADS HERE</h2>
        </div> -->
        @include('partials.right-panels.feedback')
    </div>
@endsection