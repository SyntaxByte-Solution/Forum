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
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1">
        <div>
            <a href="/" class="link-path">{{ __('Board index') }} > </a>
            <a href="/{{ request()->forum->slug }}/discussions" class="link-path">{{ __(request()->forum->forum) }}</a>
            <!--<span class="current-link-path">The side effects of using glutamin</span>-->
        </div>
        <div class="flex space-between">
            <h1 id="page-title">Discussions & questions</h1>
            <div>
                <a href="{{ route('forum.all', [request('forum')->slug]) }}" class="page-section-button page-section-button-selected">ALL</a>
                <a href="{{ route('forum.discussions', [request('forum')->slug]) }}" class="page-section-button">DISCUSSIONS</a>
                <a href="{{ route('forum.questions', [request('forum')->slug]) }}" class="page-section-button">QUESTIONS</a>
            </div>
        </div>

        <div class="flex align-center my8 mr4">
            <label class="label-style-2">Select Category: </label>
            <select name="category" id="" class="basic-dropdown">
                <option value="0">{{ __('All') }}</option>
                @foreach($categories as $category)
                    <option value="">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex align-center space-between" style="margin-bottom: 10px">
            <div class="flex align-center">
                <div class="relative">
                    <a href="" class="mr4 button-right-icon more-icon button-with-suboptions">Add Thread</a>
                    <div class="suboptions-container suboptions-buttons-b-style">
                        <a href="{{ route('discussion.add', ['forum'=>request()->forum->slug]) }}" class="suboption-b-style">Add Discussion</a>
                        <a href="" class="suboption-b-style">Add Question</a>
                    </div>
                </div>
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
        @if($announcements->count() != 0)
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
                <th class="table-col-header">{{ __('THREAD') }}</th>
                <th class="table-col-header">{{ __('CATEGORY') }}</th>
                <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                <th class="table-col-header table-numbered-column">{{ __('VIEWS') }}</th>
                <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
            </tr>
            @foreach($threads as $thread)
                <x-resource-table-row :thread="$thread"/>
            @endforeach
        </table>
    </div>
@endsection