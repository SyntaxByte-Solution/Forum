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
    @include('partials.basic-right-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex align-center space-between full-width">
            <div>
                <a href="" class="link-path">{{ __('Board index') }}</a>
                <!--<span class="current-link-path">The side effects of using glutamin</span>-->
            </div>
            @auth
                <div class="flex align-center">
                    <p class="mr8 fs13 gray">Add: </p>
                    <a href="{{ route('discussion.add', ['forum'=>'general']) }}" class="button-style-1 flex">{{ __('Discussion') }}</a>
                    <div class="mx4 fs11">or</div>
                    <a href="{{ route('question.add', ['forum'=>'general']) }}" class="button-style-1 flex">{{ __('Question') }}</a>
                </div>
            @endauth
        </div>
        <div id="forums-section">
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
                <h1 id="page-title">❝ {{__('THE ONLY PERSON WHO CAN STOP YOU FROM REACHING YOUR GOALS IS YOU.') }} ❞</h1>
                <div class="flex">
                    <p class="move-to-right gray bold" style="margin-top: -14px">~ Jackie Joyner-Kersee</p>
                </div>
            </div>

            <table class="forums-table">
                <tr>
                    <th class="table-col-header">{{ __('MB FORUMS') }}</th>
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
@endsection