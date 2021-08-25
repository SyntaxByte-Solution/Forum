@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
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
    @include('partials.left-panel', ['page' => 'threads'])
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path flex align-center">
            <svg class="small-image-size mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            {{ $forum->forum }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('All Categories') }}</span>
    </div>
    <div class="index-middle-width middle-container-style">
        <div class="full-width">
            <input type="hidden" id="forum-slug" value="{{ request('forum')->slug }}">
            <div class="flex align-center" style="margin: 16px 0">
                <svg class="size30 mr8" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    {!! $forum->icon !!}
                </svg>
                <h1 class="forum-color fs30 no-margin">{{ __(request()->forum->forum . ' Forum') }}</h1>
            </div>
            @if($announcements->count() != 0)
                <div class="flex align-center space-between">
                    <h2 class="forum-color" style="margin: 0 0 6px 0">Announcements</h2>
                    @if($announcements->count() > 2)
                    <a href="{{ route('announcements') }}" class="blue no-underline bold">{{ __('See all') }}</a>
                    @endif
                </div>
                @foreach($announcements->take(3) as $announcement)
                    <x-thread.announcement :announcement="$announcement"/>
                @endforeach
            <div class="simple-line-separator" style="margin: 14px 0"></div>
            @endif
            <div class="flex space-between align-center">
                <h2 class="fs22 blue unselectable my8 flex align-center">{{ __('Discussions') }}</h2>
            </div>
            <div class="flex align-center space-between mb2">
                <div class="flex align-center">
                    <div class="flex align-center">
                        <p class="no-margin gray fs12 unselectable">{{__('Forum')}}</p>
                        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                        <div class="relative">
                            <div class="flex align-center forum-color button-with-suboptions pointer fs12">
                                <svg class="small-image-size thread-add-forum-icon mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    {!! $forum->icon !!}
                                </svg>
                                <span class="thread-add-selected-forum">{{ $forum->forum }}</span>
                                <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                            </div>
                            <div class="suboptions-container thread-add-suboptions-container">
                                @foreach($forums as $forum)
                                    <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="thread-add-suboption black no-underline flex align-center">
                                        <svg class="small-image-size forum-ico mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            {!! $forum->icon !!}
                                        </svg>
                                        <span>{{ $forum->forum }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="gray height-max-content mx8 fs10">•</div>
                    <div class="flex align-center">
                        <p class="no-margin fs12 gray">{{ __('Category') }} </p>
                        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                        <div class="relative">
                            <div class="flex align-center forum-color button-with-suboptions pointer fs12">
                                <span class="fs13 bold">{{ __('All categories') }}</span>
                                <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                            </div>
                            <div class="suboptions-container thread-add-suboptions-container width-max-content">
                                <a href="{{ route('category.threads', ['forum'=>$category->forum->slug, 'category'=>$category->slug]) }}" class="thread-add-suboption black no-underline flex align-center">
                                    <span>{{ __('All') }}</span>
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('category.threads', ['forum'=>$category->forum->slug, 'category'=>$category->slug]) }}" class="thread-add-suboption black no-underline flex align-center">
                                        <span>{{ $category->category }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                        <div class="flex align-center forum-color button-with-suboptions pointer fs13 py4">
                            <span class="mr4 gray unselectable">{{ __('Filter by date') }}:</span>
                            <span class="forum-color fs13 bold unselectable">{{ __($tab_title) }}</span>
                            <svg class="size7 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                        </div>
                        <div class="suboptions-container thread-add-suboptions-container" style="width: 220px">
                            <a href="?tab=all" class="no-underline thread-add-suboption sort-by-option flex">
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
                                    <p class="no-margin fs12 gray">{{ __('Get only threads created today. (This will be sorted by number of views)') }}</p>
                                    <input type="hidden" class="tab" value="today">
                                </div>
                                <div class="loading-dots-anim ml4 none">•</div>
                            </a>
                            <a href="?tab=thisweek" class="no-underline thread-add-suboption sort-by-option flex">
                                <div>
                                    <p class="no-margin sort-by-val bold forum-color">{{ __('This week') }}</p>
                                    <p class="no-margin fs12 gray">{{ __('Get only threads created this week. (This will be sorted by number of views)') }}</p>
                                    <input type="hidden" class="sort-by-key" value="votes">
                                </div>
                                <div class="loading-dots-anim ml4 none">•</div>
                            </a>
                        </div>
                    </div>
                <!-- <a href="{{ route('advanced.search') }}" class="fs13 bold no-underline forum-color flex align-center">
                    <svg class="size12 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512,28.48A28.27,28.27,0,0,0,484,0H28.06A27.71,27.71,0,0,0,11.92,5.19,28.75,28.75,0,0,0,5.11,44.87L170.4,283.44,170.87,457A55.72,55.72,0,0,0,180,487.44a53.81,53.81,0,0,0,75.32,15.29l59-40a57.19,57.19,0,0,0,25-47.66l-.6-130.63L506.8,45A28.85,28.85,0,0,0,512,28.48ZM282.54,266.39l.68,149L227,453.45l-.5-188.1L82.09,57H429.51Z"/></svg>
                    {{ __('Adv. Search') }}
                </a> -->
            </div>
            @foreach($threads as $thread)
                <x-index-resource :thread="$thread"/>
            @endforeach
            <div class="flex my8">
                <div class="mr8 move-to-right">
                    {{ $threads->onEachSide(0)->links() }}
                </div>
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forums-list')
        @include('partials.right-panels.recent-forum-threads')
        <div class="sticky" style="top: 70px">
            @include('partials.right-panels.feedback')
        </div>
    </div>
@endsection