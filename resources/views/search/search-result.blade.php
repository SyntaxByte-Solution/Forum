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
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.activities'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex">
            <div class="full-width">
                <div class="flex space-between my8">
                    <h2 class="py8 fs26">Search results for: "{{ $original_keyword }}"</h2>
                </div>

            </div>
        </div>
    </div>
@endsection