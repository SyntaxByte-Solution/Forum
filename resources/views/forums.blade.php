@extends('layouts.app')

@section('title', 'MG Forums')

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
    @include('partials.left-panel', ['page' => 'forums'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div>
            <div class="flex align-center space-between full-width border-box">
                <div class="flex align-center">
                    <a href="/" class="link-path">{{ __('Board index') }}</a>
                    <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                    <a href="/forums" class="link-path">{{ __('Forums') }}</a>
                    <!--<span class="current-link-path">The side effects of using glutamin</span>-->
                </div>
                @auth
                    <div class="flex align-center">
                        <p class="mr8 fs13 gray">Add: </p>
                        <a href="{{ route('thread.add') }}" class="button-style-1 flex">{{ __('Discussion or Question') }}</a>
                    </div>
                @endauth
            </div>
            <div class="half-width my8">
                <img src="{{ asset('assets/images/img/forums.png') }}" class="full-width br6" alt="">
            </div>
            <div id="forums-section" style='padding-top: 0'>
                <div>
                    @if(Session::has('message'))
                        <div class="green-message-container">
                            <p class="green-message">{{ Session::get('message') }}</p>
                        </div>
                    @endif
                    @if(Session::has('error'))
                        <div class="error-message-container">
                            <p class="error-message">{{ Session::get('error') }}</p>
                        </div>
                    @endif
                </div>
                <div class="flex align-center">
                    <img src="" class="" alt="">
                    <h1 id="page-title">Forums</h1>
                </div>
                <table class="forums-table">
                    <tr>
                        <th class="table-col-header">{{ __('ALL FORUMS') }}</th>
                        <th class="table-col-header table-numbered-column">{{ __('THREADS') }}</th>
                        <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                        <th class="table-col-header table-last-post">{{ __('LAST THREAD') }}</th>
                    </tr>
                    @foreach($forums as $forum)
                        <x-forum-table-row :forum="$forum"/>
                    @endforeach
                </table>
            </div>
        </div>
        <div id="right-panel">
            @include('partials.right-panels.recent-forum-threads')
            @include('partials.right-panels.forum-guidelines-panel-section')
        </div>
    </div>
    <div>
        
    </div>
@endsection