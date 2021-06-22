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
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div class="full-center">
                <img src="{{ asset('assets/images/logos/b-large-logo.png') }}" class="half-width" alt="">
            </div>
            <div>
                <h2 class="my8 fs26 forum-color">{{ __('Top Discussions & Questions') }}</h2>
                <div class="flex space-between align-end">
                    <div>
                        <p class="fs12 no-margin mt8" style="margin-bottom: 2px">{{ __('Search for threads, users ..') }}</p>
                        <div class="flex align-center">
                            <div>
                                <form action="{{ route('search') }}" method='get' class="flex">
                                    <input type="text" name="k" class="input-style-2" style="width: 330px" placeholder="Search everything .." required>
                                    <input type="submit" value="" class="search-forum-button" style="margin-left: -8px; width: 60px">
                                </form>
                            </div>
                            <a href="" class="ml4">
                                <img src="{{ asset('assets/images/icons/bsettings.png') }}" class="adv-search-button" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="mr8">
                        <div class="flex">
                            <div class="flex align-center move-to-right">
                                <a href="/" class="pagination-item pag-active @if(!request()->has('tab')) pagination-item-selected @endif bold">Interesting</a>
                                <a href="?tab=today" class="pagination-item pag-active bold @if($t = request()->has('tab')) @if(request()->get('tab') == 'today') pagination-item-selected @endif @endif">Today</a>
                                <a href="?tab=thisweek" class="pagination-item pag-active bold @if($t = request()->has('tab')) @if(request()->get('tab') == 'thisweek') pagination-item-selected @endif @endif">This week</a>
                            </div>
                        </div>
                        <div class="simple-half-line-separator my4 move-to-right"></div>
                        <div class="flex">
                            <div class="move-to-right">
                                {{ $threads->onEachSide(0)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <table class="forums-table my8">
                    <tr>
                        <th class="table-col-header">
                            <div class="flex align-center">
                                {{ __('THREADS') }} ({{$threads->count()}} {{__('in total')}})
                                <div class="inline-block move-to-right mr4">
                                    <div class="flex align-center">
                                        <div class="flex align-center mr8">
                                            <p class="gray fs11 no-margin mr4">Forum: </p>
                                            <div class="relative">
                                                <a href="{{ route('forum.all.threads', ['forum'=>'general']) }}" class="mr4 button-right-icon more-icon button-with-suboptions">{{ __('All') }}</a>
                                                <div class="suboptions-container suboptions-buttons-b-style" style="top: 16px">
                                                    @foreach($forums as $forum)
                                                        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="suboption-b-style">{{ $forum->forum }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex align-center">
                                            <span>rows: </span>
                                            <select name="" class="small-dropdown row-num-changer">
                                                <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                                <option value="20" @if($pagesize == 20) selected @endif>20</option>
                                                <option value="50" @if($pagesize == 50) selected @endif>50</option>
                                                <option value="100" @if($pagesize == 100) selected @endif>50</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th class="table-col-header table-numbered-column">{{ __('REPLIES/VIEWS') }}</th>
                        <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
                    </tr>
                    @foreach($threads as $thread)
                        <x-index-resource :thread="$thread"/>
                    @endforeach
                </table>
                @if(!$threads->count())
                    <div class="full-center">
                        <div>
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("There are no threads for the moment try out later !") }}</p>
                            <p class="my4 text-center">{{ __("Try to create a new ") }} <a href="{{ route('thread.add', ['forum'=>'general']) }}" class="link-path">{{__('thread')}}</a></p>
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
        <div class="index-right-panel-container border-box">
            @include('partials.right-panels.forums-list')
            @include('partials.right-panels.recent-forum-threads')
            <div class="sticky" style="top: 70px">
                @include('partials.right-panels.feedback')
                @include('partials.right-panels.statistics')
            </div>
        </div>
    </div>
@endsection