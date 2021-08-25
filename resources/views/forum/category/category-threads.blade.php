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
    <input type="hidden" id="forum-slug" value="{{ request('forum')->slug }}">
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path flex align-center">
            <svg class="small-image-size mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            {{ $forum->forum }}
        </a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('category.threads', ['forum'=>request()->forum->slug, 'category'=>$category->slug]) }}" class="link-path">{{ __($category->category) }}</a>
        <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path">{{ __('Discussions') }}</span>
    </div>
    <div class="index-middle-width middle-container-style">
        <div class="flex" style="margin: 16px 0">
            <svg class="size30 mr8" style="margin-top: 2px" fill="#202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            <div>
                <h1 class="forum-color fs30 no-margin">{{ __(request()->forum->forum . ' Forum') }}</h1>
                <h2 class="forum-color fs16 no-margin ml4">{{ __('Category') . " : " . __($category->category) }}</h2>
            </div>
        </div>
        <div class="flex align-center">
            <form action="{{ route('advanced.search.results') }}" class="flex full-width">
                <input type="hidden" name="forum" value="{{ request()->forum->id }}">
                <input type="hidden" name="category" value="{{ $category->id }}">
                <input type="text" name="k" class="input-style-1 full-width" placeholder="{{ __('Search in this category') }}" required>
                <button type="submit" class="button-style-1 flex align-center ml4">
                    <svg class="size15 mr4" fill="#fff" viewBox="0 0 515.558 515.558" xmlns="http://www.w3.org/2000/svg"><path d="m378.344 332.78c25.37-34.645 40.545-77.2 40.545-123.333 0-115.484-93.961-209.445-209.445-209.445s-209.444 93.961-209.444 209.445 93.961 209.445 209.445 209.445c46.133 0 88.692-15.177 123.337-40.547l137.212 137.212 45.564-45.564c0-.001-137.214-137.213-137.214-137.213zm-168.899 21.667c-79.958 0-145-65.042-145-145s65.042-145 145-145 145 65.042 145 145-65.043 145-145 145z"/></svg>
                    {{ __('Search') }}
                </button>
            </form>
            <a href="{{ route('advanced.search') }}" class="link-path flex align-center mr4 ml8">
                <svg class="size12 mr4" style="min-width: 14px; fill: #2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511 511"><path d="M492,0H21A20,20,0,0,0,1,20,195,195,0,0,0,66.37,165.55l87.42,77.7a71.1,71.1,0,0,1,23.85,53.12V491a20,20,0,0,0,31,16.6l117.77-78.51a20,20,0,0,0,8.89-16.6V296.37a71.1,71.1,0,0,1,23.85-53.12l87.41-77.7A195,195,0,0,0,512,20,20,20,0,0,0,492,0ZM420.07,135.71l-87.41,77.7a111.1,111.1,0,0,0-37.25,83V401.82l-77.85,51.9V296.37a111.1,111.1,0,0,0-37.25-83L92.9,135.71A155.06,155.06,0,0,1,42.21,39.92H470.76A155.06,155.06,0,0,1,420.07,135.71Z"/></svg>
                <span class="width-max-content">{{ __('Adv. search') }}</span>
            </a>
        </div>
        <div class="simple-line-separator my8"></div>
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
                            @foreach($forums as $f)
                                <a href="{{ route('forum.all.threads', ['forum'=>$f->slug]) }}" class="@if($f->id == $forum->id) block-click @endif thread-add-suboption black no-underline flex align-center" style="@if($f->id == $forum->id) background-color: #e1e1e1; cursor: default @endif">
                                    <svg class="small-image-size forum-ico mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        {!! $f->icon !!}
                                    </svg>
                                    <span>{{ $f->forum }}</span>
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
                            <span class="fs13 bold">{{ $category->category }}</span>
                            <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                        </div>
                        <div class="suboptions-container thread-add-suboptions-container width-max-content">
                            <a href="{{ route('category.threads', ['forum'=>$category->forum->slug, 'category'=>$category->slug]) }}" class="thread-add-suboption black no-underline flex align-center">
                                <span>{{ __('All categories') }}</span>
                            </a>
                            @foreach($categories as $c)
                                <a href="{{ route('category.threads', ['forum'=>$c->forum->slug, 'category'=>$c->slug]) }}" class="@if($c->id == $category->id) block-click @endif thread-add-suboption black no-underline flex align-center" style="@if($c->id == $category->id) background-color: #e1e1e1; cursor: default @endif">
                                    <span>{{ $c->category }}</span>
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
        </div>
        @foreach($threads as $thread)
            <x-index-resource :thread="$thread"/>
        @endforeach
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forums-list')
        @include('partials.right-panels.recent-forum-threads')
        <div class="sticky" style="top: 70px">
            @include('partials.right-panels.feedback')
        </div>
    </div>
@endsection