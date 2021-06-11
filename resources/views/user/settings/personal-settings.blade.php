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
                <h1 class="">Update Personal Settings</h1>

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

                <div class="flex">
                    <div class="half-width mx8">
                        <div class="input-container">
                            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                            <script>
                                $( function() {
                                    $( "#datepicker" ).datepicker({
                                        changeMonth: true,
                                        changeYear: true,
                                        maxDate: "+1m +1w",
                                        yearRange: '1950:2021',
                                        dateFormat: "yy-mm-dd"
                                    });
                                } );
                            </script>
                            <div class="flex align-center">
                                <label for="datepicker" class="label-style-2 mr8">{{ __('Date of birth') }} @error('birth') <span class="error ml4">*</span> @enderror</label>
                                <input type="text" id="datepicker" name="birth" value="@if(@old('birth')) {{ @old('birth') }} @else {{ $user->personal->birth }} @endif" form="personal-infos-form" class="basic-input" style="min-width: unset" placeholder="birth">
                            </div>
                        </div>
                        <div class="input-container">
                            <script src="{{ asset('js/jq-plugins/country-picker-flags/build/js/countrySelect.js') }}"></script>
                            <link rel="stylesheet" href="{{ asset('js/jq-plugins/country-picker-flags/build/css/countrySelect.css') }}">
                            <div class="flex align-center">
                                <label for="subject" class="label-style-2 mr8">{{ __('Country') }} @error('country') <span class="error ml4">*</span> @enderror</label>
                                <input id="country_selector" form="personal-infos-form" name="country" type="text" class="basic-input">
                                <script>
                                    $("#country_selector").countrySelect({
                                        preferredCountries: ['ma', 'dz', 'tn', 'eg'],
                                        @if(!$user->personal->country)
                                            defaultCountry: "ma"
                                        @endif
                                    });

                                    @if($user->personal->birth)
                                        $("#country_selector").countrySelect("setCountry", "{{ $user->personal->country }}");
                                    @endif
                                </script>
                            </div>
                        </div>
                        <div class="input-container">
                            <label for="city" class="label-style-2">{{ __('City') }} @error('city') <span class="error ml4">*</span> @enderror</label>
                            <input type="text" id="city" name="city" value="@if(@old('city')){{ @old('city') }}@else{{ $user->personal->city }}@endif" form="personal-infos-form" class="full-width input-style-1" autocomplete="off" placeholder="your city">
                            @error('city')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="input-container">
                            <label for="phone" class="label-style-2">{{ __('Phone') }} @error('phone') <span class="error ml4">*</span> @enderror</label>
                            <input type="text" id="phone" name="phone" value="@if(@old('phone')){{ @old('phone') }}@else{{ $user->personal->phone }}@endif" form="personal-infos-form" class="full-width input-style-1" autocomplete="off" placeholder="phone number">
                            @error('phone')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="half-width mx8">
                        <div class="input-container">
                            <div class="flex align-center">
                                <img src="{{ asset('assets/images/icons/facebook.svg') }}" class="small-image-2" style="margin-right: 4px" alt="">
                                <label for="facebook" class="label-style-2">{{ __('Facebook') }} @error('facebook') <span class="error ml4">*</span> @enderror</label>
                            </div>
                            <input type="text" id="facebook" name="facebook" value="@if(@old('facebook')){{ @old('facebook') }}@else{{ $user->personal->facebook }}@endif" form="personal-infos-form" class="full-width input-style-1" autocomplete="off" placeholder="Your facebook account url">
                            @error('facebook')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="input-container" style="margin-top: 13px">
                            <div class="flex align-center">
                                <img src="{{ asset('assets/images/icons/instagram.svg') }}" class="small-image-2" style="margin-right: 4px" alt="">
                                <label for="instagram" class="label-style-2">{{ __('Instagram') }} @error('instagram') <span class="error ml4">*</span> @enderror</label>
                            </div>
                            <input type="text" id="instagram" name="instagram" value="@if(@old('instagram')){{ @old('instagram') }}@else{{ $user->personal->instagram }}@endif" form="personal-infos-form" class="full-width input-style-1" autocomplete="off" placeholder="Your instagram username">
                            @error('instagram')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="input-container" style="margin-top: 13px">
                            <div class="flex align-center">
                                <img src="{{ asset('assets/images/icons/twitter.svg') }}" class="small-image-2" style="margin-right: 4px" alt="">
                                <label for="twitter" class="label-style-2">{{ __('Twitter') }} @error('twitter') <span class="error ml4">*</span> @enderror</label>
                            </div>
                            <input type="text" id="twitter" name="twitter" value="@if(@old('twitter')){{ @old('twitter') }}@else{{ $user->personal->twitter }}@endif" form="personal-infos-form" class="full-width input-style-1" autocomplete="off" placeholder="Your twitter account url">
                            @error('twitter')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div>
                <div class="input-container">
                    <form action="{{ route('change.user.settings.personal') }}" method="post" id="personal-infos-form">
                        @method('patch')
                        @csrf
                        <div class="flex align-center">
                            <input type="submit" class="button-style block" value="{{ __('Save Changes') }}">
                            <a href="{{ route('user.profile', ['user'=>auth()->user()->username]) }}" class="black-link ml8">Cancel</a>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            <div>
                @include('partials.settings.profile-right-side-menu', ['item'=>'settings-personal'])
            </div>
        </section>
    </div>
@endsection