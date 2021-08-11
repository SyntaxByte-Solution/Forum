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
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.thread.viewer')
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" style="padding-top: 30px">
        <div class="full-width">
            <div class="index-middle-width middle-container-style">
                @if(Session::has('message'))
                    <div class="green-message-container mb8">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif
                @auth
                    @include('partials.thread.thread-add', ['editor_height'=>100])
                @endauth
                <h3 class="fs26 page-title forum-color" style="margin: 12px 0 26px 0">{{ __('Discussions and Questions') }}</h3>
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
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("There are no threads for the moment try out later !") }}</p>
                            <p class="my4 text-center">{{ __("Try to create a new ") }} <a href="{{ route('thread.add') }}" class="link-path">{{__('thread')}}</a></p>
                        </div>
                    </div>
                @endif
                <div class="flex my8">
                    <div class="move-to-right">
                        {{ $threads->onEachSide(0)->links() }}
                    </div>
                </div>
            </div>
        </div>
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