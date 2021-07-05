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
    @include('partials.left-panel', ['page' => 'threads'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <input type="hidden" id="forum-slug" value="{{ request('forum')->slug }}">
            <div>
                <a href="/" class="link-path">{{ __('Board index') }} > </a>
                <a href="{{ route('forum.all.threads', ['forum'=>request()->forum->slug]) }}" class="link-path">{{ __(request()->forum->forum) }} ></a>
                <a href="{{ route('category.threads', ['forum'=>request()->forum->slug, 'category'=>$category->slug]) }}" class="link-path">{{ __($category->category) }} > </a>
                <span class="current-link-path">{{ __('All Category Threads') }}</span>
            </div>
            <div class="flex space-between">
                <h1 id="page-title">Discussions, Questions and more</h1>
                <div>
                    <div class="flex align-center" style="margin-top: 8px">
                        <p class="gray fs12 mr8">Forum: </p>
                        <div class="relative">
                            <a href="request('forum')->slug" class="mr4 button-right-icon more-icon button-with-suboptions">{{ request('forum')->forum }}</a>
                            <div class="suboptions-container suboptions-buttons-b-style">
                                @foreach($forums as $forum)
                                    <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="suboption-b-style">{{ $forum->forum }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex align-center my8 mr4">
                <label class="label-style-2 category-dropdown">Select Category: </label>
                <select name="category" id="category-dropdown" class="basic-dropdown">
                    <option value="all">{{ __('All') }}</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->slug }}" @if($c->category == $category->category) selected @endif>{{ $c->category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex align-center space-between" style="margin-bottom: 10px">
                <div class="flex align-center">
                    <div class="relative">
                        <a href="{{ route('thread.add', ['forum'=>request()->forum->slug, 'category'=>$category->slug]) }}" class="button-style-1 mr4">Add Thread</a>
                    </div>
                    <form action="{{ route('advanced.search.results') }}" class="flex">
                        <input type="hidden" name="forum" value="{{ request()->forum->id }}">
                        <input type="hidden" name="category" value="{{ $category->id }}">
                        <input type="text" name="k" class="input-style-2" placeholder="{{ __('Search this category') }}" required>
                        <input type="submit" value="" class="search-forum-button" style="margin-left: -8px">
                    </form>
                    <a href="{{ route('advanced.search') }}" class="size24 sprite sprite-2-size adv24-icon mx4"></a>
                </div>
                <div class="mr8">
                    {{ $threads->onEachSide(0)->links() }}
                </div>
            </div>
            <table class="forums-table">
                <tr>
                    <th class="table-col-header">
                        <div class="flex align-center">
                            {{ __('THREAD') }}
                            <div class="move-to-right">
                                <div class="mx4 inline-block">
                                    <div class="flex align-center">
                                        <span>rows: </span>
                                        <select name="" class="small-dropdown row-num-changer">
                                            <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                            <option value="20" @if($pagesize == 20) selected @endif>20</option>
                                            <option value="50" @if($pagesize == 50) selected @endif>50</option>
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