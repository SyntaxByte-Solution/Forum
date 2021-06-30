@extends('layouts.app')

@prepend('scripts')
    <script type="application/javascript" defer>
        $(document).ready(function() { 
            $('.header-button-counter-indicator').css('opacity', '0');
            let element = $('.notification-button');
            let icon = element.find('.notifications-icon');
            icon.removeClass('notification-icon')
            icon.off();
            icon.css('background-position', '0px 0px');
            element.off();

            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() == $(document).height()) {
                    let button;
                    if(button = $('.notifications-load')) {
                        loadNotifications(button);
                    }
                }
            });
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
                    <input type="hidden" class="notif-state-couter" value="1">
                    @foreach($user->notifs as $notification)
                        @if($loop->index == 8)
                            @break
                        @endif
                        <x-user.header-notification :notification="$notification"/>
                    @endforeach
                    @if(!$user->notifications->count())
                        <div class="my8">
                            <div class="size28 sprite sprite-2-size binbox28-icon move-to-middle"></div>
                            <h3 class="my4 fs17 text-center">{{__('Notifications box is empty')}}</h3>
                            <p class="my4 fs13 gray text-center">{{ __('Try to start discussions/questions or react to people posts') }}.</p>
                        </div>
                    @elseif($user->notifications->count() > 6)
                        <input type='button' class="see-all-full-style notifications-load" value="{{__('load more')}}">
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection