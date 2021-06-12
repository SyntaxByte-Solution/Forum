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
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.settings'])
    <div id="middle-container" class="middle-padding-1">
        <section class="flex">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'settings'])
                <h1 class="">Account Management</h1>
                <div class="simple-line-separator my8"></div>

                <div class="my8">
                    <div style="margin-top: 20px">
                        <p class="fs15 my8">{{ __('This account is currently deactivated. You can activate it by clicking on activate account button down bellow.') }}</p>
                        <form action="{{ route('user.account.activating') }}" method="post" id="account-deactivation-form">
                            @method('patch')
                            @csrf
                            <input type="submit" class="button-style green-background bold" value="{{ __('Activate account') }}">
                        </form>
                    </div>
                </div>
            </div>
            <div>
                @include('partials.settings.profile-right-side-menu', ['item'=>'user-account-settings'])
                <div class="ms-right-panel my8">
                    <a href="" class="black-link bold blue toggle-container-button" style="margin-bottom: 12px; margin-top: 0">Account activation <span class="toggle-arrow">▾</span></a>
                    <div class="toggle-container ml8 block" style="max-width: 280px">
                        <p class="fs12 my8">• {{ __("You can't access any web page unless you activate your account") }}.</p>
                        <p class="fs12 my8">• {{ __("Activate your account to make it accessible to the public") }}.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection