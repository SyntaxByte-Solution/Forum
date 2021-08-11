@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpush



@section('header')
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'add-thread'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div>
                <a href="/" class="link-path">{{ __('Board index') }} > </a>
                <span class="current-link-path">{{ __('Start a discussion / Ask a question') }}</span>
            </div>
            <div>
                <h1 id="page-title">{{ __('Start a discussion / Ask a question') }}</h1>
            </div>
            @auth
                @include('partials.thread.thread-add', ['editor_height'=>150])
            @endauth
        </div>
        <div id="right-panel">
            @include('partials.right-panels.forum-guidelines-panel-section')
        </div>
    </div>
@endsection