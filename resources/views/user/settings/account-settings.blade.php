@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush


@push('scripts')
    <script src="{{ asset('js/settings.js') }}" defer></script>
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
                <h1>Account Management</h1>
                <div class="simple-line-separator my8"></div>

                <div class="my8">
                    <div>
                        @if(Session::has('error'))
                        <div class="error-container">
                            <p class="error-message">{{ Session::get('error') }}</p>
                        </div>
                        @endif
                        @if(Session::has('message'))
                            <div class="green-message-container">
                                <p class="green-message">{{ Session::get('message') }}</p>
                            </div>
                        @endif
                        @if($errors->any())
                        <div class="error-container">
                            <p class="error-message">{{$errors->first()}}</p>
                        </div>
                        @endif

                        <h2 class="fs18">Account deactivation</h2>
                        @if(Session::has('errordeactiv'))
                        <div class="error-container">
                            <p class="error-message">{{ Session::get('errordeactiv') }}</p>
                        </div>
                        @endif
                        <p class="fs13">{{ __("Your account will not be deleted, all your threads and activities will be hidden from public access. You can restore your account later") }}.</p>
                        @if($user->password == NULL && $user->provider)
                        <p class="fs13 no-margin">({{ __("If you don't have a password, you need set a password in password managements to complete this task") }})</p>
                        @endif
                        <div id="deactivate-account-container">
                            <div class="input-container">
                                <label for="password" class="label-style-1">{{ __('Your current password') }} @error('password') <span class="error">*</span> @enderror </label>
                                <p class="mini-label">{{ __("Enter your current password to verify your identity.") }}</p>
                                <input type="password" id="password" name="password" form="account-deactivation-form" class="full-width input-style-1" required autocomplete="off" placeholder="{{__('Your current password')}}">
                                @error('password')
                                    <p class="error" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex">
                                <form action="{{ route('deactivate.user.account') }}" method="post" id="account-deactivation-form">
                                    @method('patch')
                                    @csrf
                                    <input type="submit" class="button-style" value="{{ __('Close Temporarily') }}">
                                </form>
                            </div>
                        </div>
                        <div class="simple-line-separator" style="margin: 20px"></div>
                        <h2 class="fs18">Account deletion</h2>
                        <p class="my4 bold fs15">{{ __('Disclaimer') }}</p>
                        <div class="error-container">
                            <p class="error-message">{{ __("This will permanently, irreversibly remove content from your account and deactivate it. Your username will remain reserved to prevent future impersonations") }}.</p>
                            <p class="error-message my8">{{ __("Remember that If you delete your account all your threads, replies and activities will be deleted permanently and you can't restore any data in the future") }}.</p>
                        </div>
                        <div id="delete-account-container">
                            <div class="input-container">
                                <label for="password" class="label-style-1">{{ __('Your current password') }} @error('password') <span class="error">*</span> @enderror </label>
                                <p class="mini-label">{{ __("Enter your current password to verify your identity.") }}</p>
                                <input type="password" id="password" name="password" form="account-delete-form" class="full-width input-style-1" required autocomplete="off" placeholder="Your current password">
                                @error('password')
                                    <p class="error" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex">
                                <form action="{{ route('delete.user.account') }}" method="post" id="account-delete-form">
                                    @method('patch')
                                    @csrf
                                    <input type="submit" class="button-style" value="{{ __('Delete Account') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                @include('partials.settings.profile-right-side-menu', ['item'=>'user-account-settings'])
                <div class="ms-right-panel my8 toggle-box">
                    <a href="" class="black-link bold blue toggle-container-button" style="margin-bottom: 12px; margin-top: 0">Account deletion <span class="toggle-arrow">▾</span></a>
                    <div class="toggle-container ml8 block" style="max-width: 280px">
                        <p class="fs12 my8">• {{ __("Your password must be set If you want to deactivate or delete your account") }}.</p>
                        <p class="fs12 my8">• {{ __("If you delete your account all your threads and activities will be deleted as well") }}.</p>
                        <p class="fs12 my8">• {{ __("You could just deactivate you account. All your data and activities will be hidden from public") }}.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection