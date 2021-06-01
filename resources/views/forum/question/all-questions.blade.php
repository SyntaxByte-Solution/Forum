@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @include('partials.hidden-login-viewer')
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'questions'])
    <div id="middle-container" class="middle-padding-1">
        <input type="hidden" id="forum-slug" value="{{ request()->forum->slug }}">
        <div>
            <a href="/" class="link-path">{{ __('Board index') }} > </a>
            <a href="{{ route('forum.misc', ['forum'=>request()->forum->slug]) }}" class="link-path">{{ __(request()->forum->forum) }} > </a>
            <span class="current-link-path">All Forum Questions</span>
        </div>
        <div class="flex space-between">
            <h1 id="page-title">Questions</h1>
            <div>
                <div class="flex">
                    <a href="{{ route('forum.misc', ['forum'=>request('forum')->slug]) }}" class="page-section-button">ALL</a>
                    <a href="{{ route('get.all.forum.discussions', ['forum'=>request('forum')->slug]) }}" class="page-section-button">DISCUSSIONS</a>
                    <a href="{{ route('get.all.forum.questions', ['forum'=>request('forum')->slug]) }}" class="page-section-button page-section-button-selected">QUESTIONS</a>
                </div>
                <div class="flex align-center" style="margin-top: 8px">
                    <p class="gray fs12 mr8">Forum: </p>
                    <div class="relative">
                        <a href="request('forum')->slug" class="mr4 button-right-icon more-icon button-with-suboptions">{{ request('forum')->forum }}</a>
                        <div class="suboptions-container suboptions-buttons-b-style">
                            @foreach($forums as $forum)
                                <a href="{{ route(Illuminate\Support\Facades\Route::currentRouteName(), ['forum'=>$forum->slug]) }}" class="suboption-b-style">{{ $forum->forum }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex align-center my8 mr4">
            <label class="label-style-2">Select Category: </label>
            <select name="category" id="category-dropdown" class="basic-dropdown">
                <option value="all">{{ __('All') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex align-center space-between" style="margin-bottom: 10px">
            <div class="flex align-center">
                <a href="{{ route('question.add', ['forum'=>request()->forum->slug]) }}" class="button-style-1 mx4">New Question</a>
                <form action="">
                    <input type="text" name="search" class="input-style-2" placeholder="Search this forum">
                    <input type="submit" value="" class="search-forum-button" style="margin-left: -8px">
                </form>
                <a href="/advanced/search" class="bsettings-icon background-style" style="width: 26px; height: 26px"></a>
            </div>
            <div class="flex align-center">
                <div class="fs-13" style="margin-right: 6px">1540 Topics</div>
                <a href="" class="pagination-item">1</a>
                <a href="" class="pagination-item">2</a>
                <a href="" class="pagination-item">3</a>
                <a href="" class="pagination-item">4</a>
                <div>...</div>
                <a href="" class="pagination-item">6</a>
            </div>
        </div>

        <!-- main -->
        @if($announcements->count())
        <table class="forums-table">
            <tr>
                <th class="table-col-header">{{ __('ANNOUNCEMENTS') }}</th>
                <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                <th class="table-col-header table-numbered-column">{{ __('VIEWS') }}</th>
                <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
            </tr>
            @foreach($announcements as $announcement)
                <x-discussion-table-row :discussion="$announcement"/>
            @endforeach
        </table>
        @endif
        <table class="forums-table">
            <tr>
                <th class="table-col-header">{{ __('QUESTIONS') }}</th>
                <th class="table-col-header">{{ __('CATEGORY') }}</th>
                <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                <th class="table-col-header table-numbered-column">{{ __('VIEWS') }}</th>
                <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
            </tr>
            @foreach($questions as $question)
                <x-resource-table-row :thread="$question"/>
            @endforeach
        </table>
    </div>
@endsection