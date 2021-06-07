@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'misc'])
    <div id="middle-container" class="middle-padding-1">
        <input type="hidden" id="forum-slug" value="{{ request('forum')->slug }}">
        <div>
            <a href="/" class="link-path">{{ __('Board index') }} > </a>
            <a href="{{ route('forum.misc', ['forum'=>request()->forum->slug]) }}" class="link-path">{{ __(request()->forum->forum) }} ></a>
            <a href="{{ route('category.misc', ['forum'=>request()->forum->slug, 'category'=>$category->slug]) }}" class="link-path">{{ __($category->category) }}</a>
            <!--<span class="current-link-path">The side effects of using glutamin</span>-->
        </div>
        <div class="flex space-between">
            <h1 id="page-title">Discussions & questions</h1>
            <div>
                <div class="flex">
                    <a href="" class="page-section-button page-section-button-selected">ALL</a>
                    <a href="{{ route('category.discussions', ['forum'=>request('forum')->slug, 'category'=>$category->slug]) }}" class="page-section-button">DISCUSSIONS</a>
                    <a href="{{ route('category.questions', ['forum'=>request('forum')->slug, 'category'=>$category->slug]) }}" class="page-section-button">QUESTIONS</a>
                </div>
                <div class="flex align-center" style="margin-top: 8px">
                    <p class="gray fs12 mr8">Forum: </p>
                    <div class="relative">
                        <a href="request('forum')->slug" class="mr4 button-right-icon more-icon button-with-suboptions">{{ request('forum')->forum }}</a>
                        <div class="suboptions-container suboptions-buttons-b-style">
                            @foreach($forums as $forum)
                                <a href="{{ route('forum.misc', ['forum'=>$forum->slug]) }}" class="suboption-b-style">{{ $forum->forum }}</a>
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
                    <a href="" class="mr4 button-right-icon more-icon button-with-suboptions">Add Thread</a>
                    <div class="suboptions-container suboptions-buttons-b-style">
                        <a href="{{ route('discussion.add', ['forum'=>request()->forum->slug]) }}" class="suboption-b-style">Add Discussion</a>
                        <a href="{{ route('question.add', ['forum'=>request()->forum->slug]) }}" class="suboption-b-style">Add Question</a>
                    </div>
                </div>
                <form action="">
                    <input type="text" name="search" class="input-style-2" placeholder="Search this forum">
                    <input type="submit" value="" class="search-forum-button" style="margin-left: -8px">
                </form>
                <a href="/advanced/search" class="bsettings-icon background-style" style="width: 26px; height: 26px"></a>
            </div>
            <div class="mr8">
                {{ $threads->onEachSide(0)->links() }}
            </div>
        </div>
        <table class="forums-table">
            <tr>
                <th class="table-col-header flex align-center">
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
                        <div class="inline-block">
                            <a href="" class="ms-table-small-button mstsb-selected all-table-threads-changer">all</a>
                            <a href="" class="ms-table-small-button all-table-discussions-changer">discussions</a>
                            <a href="" class="ms-table-small-button all-table-questions-changer">questions</a>
                        </div>
                    </div>
                </th>
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