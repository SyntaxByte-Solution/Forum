@extends('layouts.app')

@section('title', 'MG Forums')

@push('styles')
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
    <style>
        .contactus-text {
            width: 90%;
            min-width: 300px;
            line-height: 1.7;
            letter-spacing: 1.4px;
            margin: 0 0 16px 0;
            color: #1e2027;
        }
        #cu-heading {
            color: #1e2027;
            letter-spacing: 5px;
            margin: 20px 0 10px 0;
        }
        #contact-us-form-wrapper {
            width: 60%;
            min-width: 320px;
        }
    </style>
    <div id="middle-container" class="middle-padding-1">
        <div class="flex align-center">
            <a href="/" class="link-path flex align-center unselectable">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                {{ __('Board index') }}
            </a>
            <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <span class="current-link-path unselectable">{{ __('Contact us') }}</span>
        </div>
        <div>
            <h1 id="cu-heading">CONTACT US</h1>
            <p class="contactus-text">{{ __("If you have any questions or queries, a member of staff will always be happy to help. Feel free to contact us using the form below, or by our telephone or email in the right panel and we will be sure to get back to you as soon as possible") }}.</p>
            @auth
            <p class="contactus-text">{{ __("Because you're currently logged in, The message will be sent along with your name and email") }}.</p>
            @endauth
            <div id="contact-us-form-wrapper">
                <input type="hidden" class="required-text" value="{{ __('Title field is required') }}">
                @guest
                <div class="full-width flex align-center">
                    <div class="mr8 half-width">
                        <label for="firstname" class="flex bold gray mb2">{{ __('Firstname') }}<span class="error none">*</span></label>
                        <input type="text" id="firstname" name="firstname" class="styled-input" required autocomplete="off" placeholder='{{ __("Your firstname") }}'>
                    </div>
                    <div class="half-width">
                        <label for="lastname" class="flex bold gray mb2">{{ __('Lastname') }}<span class="error none">*</span></label>
                        <input type="text" id="lastname" name="lastname" class="styled-input" required autocomplete="off" placeholder='{{ __("Your lastname") }}'>
                    </div>
                </div>
                <div style="margin: 12px 0">
                    <label for="email" class="flex bold gray mb2">{{ __('Email') }}<span class="error none">*</span></label>
                    <input type="email" id="email" name="email" class="styled-input" required autocomplete="off" placeholder='{{ __("Your email") }}'>
                </div>
                <div style="margin: 12px 0">
                    <label for="company" class="flex align-center bold gray mb2">{{ __('Company') }} <span style="font-weight: 400; margin-left: 2px; font-size: 12px">({{__('optional')}})</span><span class="error none">*</span></label>
                    <input type="text" id="company" name="company" class="styled-input" autocomplete="off" placeholder='{{ __("Company") }}'>
                </div>
                @endguest
                <div>
                    <label for="message" class="flex align-center bold gray mb2">{{ __('Message') }} <span style="font-weight: 400; margin-left: 2px; font-size: 12px">({{__('optional')}})</span><span class="error none">*</span></label>
                    <div class="countable-textarea-container">
                        <textarea name="message" id="message" class="no-margin block styled-textarea move-to-middle countable-textarea" autocomplete="off" maxlength="2000" spellcheck="false" autocomplete="off" form="profile-edit-form" placeholder="{{ __('Your message') }}"></textarea>
                        <p class="block my4 mr4 unselectable fs12 gray textarea-counter-box move-to-right width-max-content"><span class="textarea-chars-counter">0</span>/2000</p>
                        <input type="hidden" class="max-textarea-characters" value="2000">
                    </div>
                </div>
                <input type='button' class="inline-block button-style" value="{{ __('Submit message') }}">
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forum-guidelines-panel-section')
    </div>
@endsection