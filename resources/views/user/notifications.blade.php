@extends('layouts.app')

@prepend('scripts')
    <script type="application/javascript" defer>
        $(document).ready(function() {   //same as: $(function() { 
            let element = $('.notification-button');
            let icon = element.find('.notifications-icon');
            element.off();
            icon.off();
            icon.css('background-position', '0px 0px');

            console.log(element);
            console.log(icon);
        });
    </script>
@endprepend

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
            <div class="notifications-wrapper">
                <h1 id="page-title">Notifications</h1>
                <div class="flex flex-column notifs-box">
                    @foreach($user->notifs as $notification)
                        <x-user.header-notification :notification="$notification"/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection