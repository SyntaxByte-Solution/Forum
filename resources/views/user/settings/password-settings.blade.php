@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
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
                <h1 class="">Password Settings</h1>

                @if($errors->any())
                <div class="error-container">
                    <p class="error-message">{{$errors->first()}}</p>
                </div>
                @endif
                @if(Session::has('message'))
                    <div class="green-message-container">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif

                <div>
                    <div>
                        <div class="flex">
                            <p class="no-margin" style="margin-right: 8px">●</p>
                            <p class="no-margin fs13" style="line-height: 150%">{{ __("Your're currently using ") }} <b> {{ $user->provider }} </b> {{ __(" service and you can access your account by choosing this service in the login section without using a password. However If you intend to create a password for your account, this will allow you to loggin using normal authentication(email & password) or login directly using your social network service") }}.</p>
                        </div>
                        <div class="flex" style="margin-top: 12px">
                            <p class="no-margin" style="margin-right: 8px">●</p>
                            <p class="no-margin fs13" style="line-height: 150%">{{ __("However keep in mind when you choose a password and forget it later, you can't reset your password because this feature is not present for the moment. Instead you can login directly using your social netweork service") }}.</p>
                        </div>
                    </div>
                    @if($user->password == NULL && $user->provider)
                        <div class="flex">
                            <div>
                                <div class="input-container">
                                    <div class="flex">
                                        <label for="password" class="label-style-2">{{ __('Your email') }}: </label>
                                        <span class="bold gray ml8">{{ $user->email }}</span>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <label for="password" class="label-style-2">{{ __('New Password') }} @error('password') <span class="error ml4">*</span> @enderror</label>
                                    <input type="text" id="password" name="password" form="password-update-form" class="full-width input-style-1" autocomplete="off" placeholder="Your new password">
                                    @error('password')
                                        <p class="error" role="alert">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-container">
                                    <label for="password_confirmation" class="label-style-2">{{ __('Confirm Your Password') }} @error('password_confirmation') <span class="error ml4">*</span> @enderror</label>
                                    <input type="text" id="password_confirmation" name="password_confirmation" form="password-update-form" class="full-width input-style-1" autocomplete="off" placeholder="Confirm password">
                                    @error('password_confirmation')
                                        <p class="error" role="alert">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="input-container">
                                    <form action="{{ route('change.user.settings.password') }}" method="post" id="password-update-form">
                                        @method('patch')
                                        @csrf
                                        <input type="submit" class="button-style block edit-thread" value="{{ __('Save Password') }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="no-margin fs13" style="line-height: 150%">{{ __("Your password has been set previously. If you forgot your password you still can login using your social network account or wait until we add password reset feature") }}.</p>
                    @endif
                </div>
            </div>
            <div>
                @include('partials.settings.profile-right-side-menu', ['item'=>'settings-password'])
                <div class="ms-right-panel my8">
                    <a href="" class="black-link bold blue toggle-container-button" style="margin-bottom: 12px; margin-top: 0">Password rules <span class="toggle-arrow">▾</span></a>
                    <div class="toggle-container ml8 block" style="max-width: 280px">
                        <p class="fs12 my8">• {{ __("Password must contains at least one character, one uppercase character and one figure") }}.</p>
                        <p class="fs12 my8">• {{ __("The two passwords must match each others") }}.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection