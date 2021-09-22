@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/post.js') }}" defer></script>
    <script src="{{ asset('js/thread/announcement-show.js') }}" defer></script>
    <script src="{{ asset('js/simplemde.js') }}"></script>
@endpush


@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    @include('partials.header')
@endsection
@section('content')
    @include('partials.left-panel', ['page' => 'announcement-show'])
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('announcements') }}" class="link-path">{{ __('Announcement') }}</a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path flex align-center">
            <svg class="small-image-size mr4" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            {{ $forum->forum }}
        </a>
    </div>
    <div id="middle-container" class="middle-padding-1" style="width: 70%; margin: 0 auto;">
        <input type="hidden" class="page" value="announcement-show">
        <div class="flex">
            <div class="full-width">
                <div class="activity-thread-wrapper thread-container-box relative" style="background-color: white">
                    <div class="thread-component">
                        <div class="full-width">
                            <div class="flex">
                                <div class="flex align-center height-max-content mr8">
                                    <div class="flex flex-column align-center">
                                        <div class="size48 rounded hidden-overflow mb8" style="min-width: 48px">
                                            <a href="{{ $announcement->user->profilelink }}">
                                                <img src="{{ asset($announcement->user->sizedavatar(100, '-h')) }}" class="handle-image-center-positioning" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="full-width">
                                    <div class="flex align-center space-between">
                                            <div class="flex align-center">
                                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    {!! $announcement->category->forum->icon !!}
                                                </svg>
                                                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ __($forum->forum) }}</a>
                                            </div>
                                            <div class="flex align-center move-to-right">
                                                <div class="simple-border-container">
                                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><path class="cls-1" d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                                                    <p class="fs12 no-margin unselectable">{{ $announcement->view_count }} {{ __('views') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    <div>
                                        <a href="{{ $announcement->announcement_link }}" class="blue no-underline bold flex fs15">{{ $announcement->subject }}</a>
                                        <div class="my4 expand-box">
                                            <span class="expandable-text fs15 no-underline">{{ $announcement->mediumcontentslice }}</span>
                                            @if($announcement->content != $announcement->mediumcontentslice)
                                            <input type="hidden" class="expand-slice-text" value="{{ $announcement->mediumcontentslice }}">
                                            <input type="hidden" class="expand-whole-text" value="{{ $announcement->content }}">
                                            <input type="hidden" class="expand-text-state" value="0">
                                            <span class="pointer expand-button fs12 inline-block blue">{{ __('see all') }}</span>
                                            <input type="hidden" class="expand-text" value="{{ __('see all') }}">
                                            <input type="hidden" class="collapse-text" value="{{ __('see less') }}">
                                            @endif
                                        </div>
                                        <div class="relative flex align-center" style="margin-top: 2px">
                                            <div class="size14" title="{{ $announcement->visibility->visibility }}">
                                                <svg class="size14 thread-resource-visibility-icon" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    {!! $announcement->visibility->icon !!}
                                                </svg>
                                            </div>
                                            <span class="fs10 gray" style="margin: 2px 4px">•</span>
                                            <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Posted') }}: {{ $at_hummans }}</p>
                                            <div class="tooltip tooltip-style-1">
                                                {{ $at }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex align-center mt8">
                                        <div class="thread-react-hover @auth like-resource like-resource-from-outside-viewer @endauth @guest login-signin-button @endguest">
                                            <input type="hidden" class="likable-id" value="{{ $announcement->id }}">
                                            <input type="hidden" class="likable-type" value="thread">
                                            <svg class="size17 like-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                                                <path class="red-like @if(!$announcement->liked) none @endif" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                                                <path class="grey-like @if($announcement->liked) none @endif" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                                            </svg>
                                            <p class="no-margin fs12 resource-likes-counter unselectable ml4">{{ $announcement->likes->count() }}</p>
                                            <p class="no-margin fs12 unselectable ml4">{{ __('like') . (($announcement->likes->count()>1) ? 's' : '' ) }}</p>
                                        </div>
                                        <div class="flex align-center ml8">
                                            <svg class="size16 mr4" style="fill:#1c1c1c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                                            <p class="fs12 no-margin unselectable">{{ $announcement->posts()->count() }} {{ __('replies') }}</p>
                                        </div>
                                        <p class="no-margin gray ml4 fs12">@if($announcement->replies_off) ({{ __('Replies disabled') }}) @endif</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($announcement->replies_off)
                    <div style="margin-top: 20px">
                        <svg class="size40 move-to-middle flex mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="286.31" cy="273.61" r="20.21"/><circle cx="205.48" cy="273.61" r="20.21"/><circle cx="124.65" cy="273.61" r="20.21"/><path d="M437.87,249.45v44.37H377.24V262.45A130.67,130.67,0,0,1,336.83,255V374.65H160.62l-13.74,40.42-13.74-40.42h-59V172.58h182a131.13,131.13,0,0,1-6.64-40.42H155V71.54H263.84A131.48,131.48,0,0,1,287.36,39,4.66,4.66,0,0,0,284,31.13H152.13a37.58,37.58,0,0,0-37.58,37.58v63.45H70.09a36.57,36.57,0,0,0-36.37,36.38V378.69a36.57,36.57,0,0,0,36.37,36.38h34l19.2,52.33a28.08,28.08,0,0,0,24.25,13.74h5a28.48,28.48,0,0,0,22.63-20.2l14.55-45.87H340.87a36.57,36.57,0,0,0,36.37-36.38V334.24H440.7a37.59,37.59,0,0,0,37.58-37.59V230.49a4.67,4.67,0,0,0-7.89-3.37A131.55,131.55,0,0,1,437.87,249.45Z"/><path d="M422.66,69A75.55,75.55,0,0,0,318,173.66ZM444,90.34A75.55,75.55,0,0,1,339.34,195ZM381,26.25A105.75,105.75,0,1,1,275.25,132,105.76,105.76,0,0,1,381,26.25Z" style="fill-rule:evenodd"/></svg>
                        <p class="text-center my4">{{ $announcement->user->username }} {{ __('turned off replies on this announcement') }}</p>
                    </div>
                @else
                <div>
                    <div class="share-post-form">
                        <div class="input-container">
                            <div class="fs14" style="margin: 20px 0 8px 0">
                                <div class="relative">
                                    <span class="absolute" id="reply-site" style="margin-top: -70px"></span>
                                </div>
                                <label for="reply-content" class="flex bold fs16">
                                    {{__('Your reply')}} 
                                    <span class="error frt-error reply-content-error">  *</span>
                                </label>
                            </div>
                            <p class="error frt-error reply-content-error" id="global-error" role="alert"></p>
                            <textarea name="subject" class="reply-content" id="post-reply" placeholder="{{ __('Your feedback on this announcement') }}"></textarea>
                            <style>
                                .CodeMirror,
                                .CodeMirror-scroll {
                                    max-height: 120px;
                                    min-height: 120px;
                                    border-color: #dbdbdb;
                                }
                                .CodeMirror-scroll:focus {
                                    border-color: #64ceff;
                                    box-shadow: 0 0 0px 3px #def2ff;
                                }
                                .editor-toolbar {
                                    padding: 0 4px;
                                    opacity: 0.8;
                                    height: 38px;
                                    border-top-color: #dbdbdb;
                                    background-color: #f2f2f2;
                                    display: flex;
                                    align-items: center;
                                }
                                .editor-toolbar .fa-arrows-alt, .editor-toolbar .fa-columns, 
                                .fa-question-circle, .fa-link, .fa-picture-o, .fa-link,
                                .share-post-form .separator:nth-of-type(2), .editor-statusbar {
                                    display: none !important;
                                }
                        </style>
                        </div>
                        <input type="hidden" name="thread_id" class="thread_id" value="{{ $announcement->id }}">
                        <input type='button' class="inline-block button-style @auth share-post @endauth @guest login-signin-button @endguest" value="Post your reply">
                    </div>
                </div>
                @endif
                    
                <div class="flex space-between align-end replies_header_after_thread @if(!$tickedPost && $posts->count() == 0) none @endif" id="thread-show-replies-section">
                    <p class="bold fs20" style="margin-top: 30px"><span class="thread-replies-number thread-replies-counter">@if($tickedPost) {{ $posts->total() + 1 }} @else {{ $posts->total() }} @endif</span> Replies</p>
                    <div>
                        {{ $posts->onEachSide(0)->links() }}
                    </div>
                </div>
                <div id="replies-container" style="margin-bottom: 30px">
                    @if($tickedPost)
                    <x-post-component :post="$tickedPost"/>
                    @endif
                    @foreach($posts as $post)
                        <x-post-component :post="$post"/>
                    @endforeach
                    @if($posts->count() > 10)
                    <div class="flex">
                        <div class="move-to-right">
                            {{ $posts->onEachSide(0)->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="right-panel">
        <x-right-panels.forumslist/>
        <x-right-panels.recentthreads/>
        @include('partials.right-panels.statistics')
    </div>
@endsection