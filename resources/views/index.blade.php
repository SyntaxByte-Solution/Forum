@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @include('partials.hidden-login-viewer')
    @include('partials.header')
@endsection
@section('content')
    @include('partials.hidden-login-viewer')
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex space-between full-width">
            <div>
                <a href="" class="link-path">{{ __('Board index') }}</a>
                <!--<span class="current-link-path">The side effects of using glutamin</span>-->
            </div>
            @auth
                <div>
                    <a href="/general/discussions/add" class="button-style">{{ __('Start Discussion') }}</a>
                </div>
            @endauth
        </div>
        <div id="forums-section">
            <table class="forums-table">
                <tr>
                    <th class="table-col-header">{{ __('MB FORUMS') }}</th>
                    <th class="table-col-header table-numbered-column">{{ __('DISCUSSIONS & QUESTIONS') }}</th>
                    <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                    <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
                </tr>
                @foreach($forums as $forum)
                    <x-forum-table-row :forum="$forum"/>
                @endforeach
            </table>
        </div>
    </div>
@endsection