@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1">
        <div>
            <a href="/" class="link-path">{{ __('Board index') }} > </a>
            <a href="/forum/{{ request()->forum->slug }}" class="link-path">{{ __(request()->forum->forum) }}</a>
            <!--<span class="current-link-path">The side effects of using glutamin</span>-->
        </div>
        <h1 id="page-title">Discussions & Questions</h1>
        <div class="flex align-center space-between" style="margin-bottom: 10px">
            <div class="flex align-center">
                <a href="" class="button-style-1 mx4">New Topic</a>
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
        <table class="forums-table">
            <tr>
                <th class="table-col-header">{{ __('DISCUSSIONS') }}</th>
                <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                <th class="table-col-header table-numbered-column">{{ __('VIEWS') }}</th>
                <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
            </tr>
            @foreach($discussions as $discussion)
                <x-forum-resource-table-row :discussion="$discussion"/>
            @endforeach
        </table>
    </div>
@endsection