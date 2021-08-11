@extends('layouts.app')

@push('styles')
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
                            <script src="{{ asset('js/jq-plugins/country-picker-flags/build/js/countrySelect.min.js') }}"></script>
                            <link rel="stylesheet" href="{{ asset('js/jq-plugins/country-picker-flags/build/css/countrySelect.min.css') }}">
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

                                    @if($user->personal->country)
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
                                <svg class="small-image-2 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M483.74,0H28.24A28.26,28.26,0,0,0,0,28.26v455.5A28.26,28.26,0,0,0,28.26,512H273.5V314H207V236.5h66.5v-57c0-66.14,40.38-102.14,99.38-102.14,28.26,0,52.54,2.11,59.62,3.05V149.5H391.82c-32.11,0-38.32,15.25-38.32,37.64V236.5h76.75l-10,77.5H353.5V512H483.74A28.25,28.25,0,0,0,512,483.75V28.24A28.26,28.26,0,0,0,483.74,0Z" style="fill:#4267b2"/><path d="M353.5,187.14V236.5h76.75l-10,77.5H353.5V512h-80V314H207V236.5h66.5v-57c0-66.14,40.38-102.14,99.38-102.14,28.26,0,52.54,2.11,59.62,3.05V149.5H391.82C359.71,149.5,353.5,164.75,353.5,187.14Z" style="fill:#fff"/></svg>
                                <label for="facebook" class="label-style-2">{{ __('Facebook') }} @error('facebook') <span class="error ml4">*</span> @enderror</label>
                            </div>
                            <input type="text" id="facebook" name="facebook" value="@if(@old('facebook')){{ @old('facebook') }}@else{{ $user->personal->facebook }}@endif" form="personal-infos-form" class="full-width input-style-1" autocomplete="off" placeholder="Your facebook account url">
                            @error('facebook')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="input-container" style="margin-top: 13px">
                            <div class="flex align-center">
                                <svg class="small-image-2 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"><defs><linearGradient id="linear-gradient" x1="42.97" y1="42.97" x2="469.03" y2="469.04" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffd600"/><stop offset="0.5" stop-color="#ff0100"/><stop offset="1" stop-color="#d800b9"/></linearGradient><linearGradient id="linear-gradient-2" x1="163.04" y1="163.05" x2="348.95" y2="348.96" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ff6400"/><stop offset="0.5" stop-color="#ff0100"/><stop offset="1" stop-color="#fd0056"/></linearGradient><linearGradient id="linear-gradient-3" x1="370.93" y1="370.93" x2="414.37" y2="414.38" gradientTransform="matrix(1, 0, 0, -1, 0, 512)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#f30072"/><stop offset="1" stop-color="#e50097"/></linearGradient></defs><path d="M510.46,150.45c-1.25-27.25-5.57-45.86-11.9-62.14A125.58,125.58,0,0,0,469,43a125.52,125.52,0,0,0-45.34-29.54C407.4,7.11,388.8,2.79,361.55,1.55S325.52,0,256,0,177.75.3,150.45,1.54,104.6,7.11,88.31,13.44A125.58,125.58,0,0,0,43,43,125.52,125.52,0,0,0,13.43,88.31C7.11,104.59,2.79,123.2,1.55,150.45S0,186.47,0,256s.3,78.25,1.55,105.55,5.57,45.85,11.9,62.14A125.43,125.43,0,0,0,43,469a125.38,125.38,0,0,0,45.35,29.52c16.28,6.34,34.89,10.66,62.14,11.91S186.48,512,256,512s78.25-.3,105.55-1.54,45.86-5.57,62.14-11.91a130.87,130.87,0,0,0,74.87-74.86c6.33-16.29,10.65-34.9,11.9-62.14S512,325.52,512,256,511.7,177.75,510.46,150.45Zm-46.08,209c-1.14,25-5.31,38.51-8.81,47.53A84.79,84.79,0,0,1,407,455.57c-9,3.5-22.57,7.68-47.53,8.81-27,1.24-35.09,1.5-103.45,1.5s-76.46-.26-103.45-1.5c-25-1.13-38.51-5.31-47.53-8.81a79.45,79.45,0,0,1-29.44-19.15A79.37,79.37,0,0,1,56.43,407c-3.5-9-7.68-22.57-8.81-47.53-1.23-27-1.49-35.09-1.49-103.45s.26-76.45,1.49-103.45c1.14-25,5.31-38.51,8.81-47.53A79.45,79.45,0,0,1,75.58,75.58,79.45,79.45,0,0,1,105,56.43c9-3.5,22.57-7.67,47.53-8.81,27-1.23,35.09-1.49,103.45-1.49h0c68.35,0,76.45.26,103.45,1.49,25,1.14,38.51,5.31,47.53,8.81a79.34,79.34,0,0,1,29.43,19.15A79.21,79.21,0,0,1,455.56,105c3.51,9,7.68,22.57,8.82,47.53,1.23,27,1.49,35.09,1.49,103.45S465.61,332.45,464.38,359.45Z" style="fill:url(#linear-gradient)"/><path d="M256,124.54A131.46,131.46,0,1,0,387.46,256,131.46,131.46,0,0,0,256,124.54Zm0,216.79A85.34,85.34,0,1,1,341.33,256,85.32,85.32,0,0,1,256,341.33Z" style="fill:url(#linear-gradient-2)"/><path d="M423.37,119.35a30.72,30.72,0,1,1-30.72-30.72A30.72,30.72,0,0,1,423.37,119.35Z" style="fill:url(#linear-gradient-3)"/></svg>
                                <label for="instagram" class="label-style-2">{{ __('Instagram') }} @error('instagram') <span class="error ml4">*</span> @enderror</label>
                            </div>
                            <input type="text" id="instagram" name="instagram" value="@if(@old('instagram')){{ @old('instagram') }}@else{{ $user->personal->instagram }}@endif" form="personal-infos-form" class="full-width input-style-1" autocomplete="off" placeholder="Your instagram username">
                            @error('instagram')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="input-container" style="margin-top: 13px">
                            <div class="flex align-center">
                                <svg class="small-image-2 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512,97.25a218.64,218.64,0,0,1-60.48,16.57,104.36,104.36,0,0,0,46.18-58,210,210,0,0,1-66.56,25.41A105,105,0,0,0,249.57,153,108,108,0,0,0,252,176.93C164.74,172.67,87.52,130.85,35.65,67.14A105,105,0,0,0,67.9,207.42,103.69,103.69,0,0,1,20.48,194.5v1.15a105.43,105.43,0,0,0,84.1,103.13,104.65,104.65,0,0,1-27.52,3.46,92.77,92.77,0,0,1-19.88-1.79c13.6,41.57,52.2,72.13,98.08,73.12A210.93,210.93,0,0,1,25.12,418.34,197.72,197.72,0,0,1,0,416.9,295.54,295.54,0,0,0,161,464c193.16,0,298.76-160,298.76-298.69,0-4.64-.16-9.12-.39-13.57A209.29,209.29,0,0,0,512,97.25Z" style="fill:#03a9f4"/></svg>
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