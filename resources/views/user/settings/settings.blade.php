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
                <h1 class="">Update Profile & Settings</h1>

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

                <div class="relative us-user-media-container">
                    <div class="us-settings-cover-container full-center relative">
                        @if(!$user->cover)
                            <div class="full-center full-dimensions">
                                <input type="file" name="cover" form="profile-edit-form" class="full-dimensions bottom0 absolute pointer" style="height: 200%">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/image.png') }}" class="small-image mr4" alt="">
                                    <p class="fs17 white">Upload a cover</p>
                                </div>
                            </div>
                        @else
                            <img src="{{ asset('storage') . '/' . $user->cover }}" class="us-cover" alt="">
                            <div class="absolute flex align-center" style="bottom: 6px; right: 6px">
                                <div class="flex align-center px8 py8 change-cover-cont relative">
                                    <input type="file" name="cover" form="profile-edit-form" class="opacity0 absolute full-dimensions bottom0 pointer" style="height: 200%">
                                    <img src="{{ asset('assets/images/icons/image.png') }}" class="small-image mr4" alt="">
                                    <p class="fs14 no-margin white">Update Cover</p>
                                </div>
                                <div>
                                    <a href="">
                                        <img src="{{ asset('assets/images/icons/wx.png') }}" class="small-image-size flex ml4" alt="">
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="flex my8">
                        <div class="relative" style="height: max-content;">
                            <a href="ererer" class="absolute x-button rounded full-center">
                                <img src="{{ asset('assets/images/icons/wx.png') }}" style="height: 10px; width: 10px" alt="">
                            </a>
                            <div class="absolute full-center update-avatar-bottom-section hidden-overflow">
                                <input type="file" name="avatar" form='profile-edit-form' class="absolute bottom0 opacity0 pointer full-width full-height block" style="height: 200%">
                                <a href="" class="white simple-link no-underline">{{__('Update Avatar')}}</a>
                            </div>
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}">
                                <div class="us-settings-profile-picture-container full-center">
                                    <img src="{{ asset('storage') . '/' . $user->avatar }}" class="us-settings-profile-picture" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="ml8 full-width">
                            <h2 class="no-margin forum-color">{{ $firstname . ' ' . $lastname }}</h2>
                            <div class="flex">
                                <div class="input-container full-width" style="margin-right: 8px">
                                    <div class="flex">
                                        <label for="firstname" class="label-style-1 gray">{{ __('Firstname') }}@error('firstname')<span class="error ml4">*</span>@enderror</label>
                                        @error('firstname')
                                            <p class="error" role="alert">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <input type="text" id="firstname" name="firstname" form="profile-edit-form" class="full-width input-style-1" value="@if(@old('firstname')){{@old('firstname')}}@else{{$firstname}}@endif" required autocomplete="off" placeholder="firstname">
                                </div>

                                <div class="input-container full-width ">
                                    <div class="flex">
                                        <label for="lastname" class="label-style-1 gray">{{ __('Lastname') }} @error('lastname') <span class="error ml4">*</span> @enderror</label>
                                        @error('lastname')
                                            <p class="error" role="alert">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <input type="text" id="lastname" name="lastname" form="profile-edit-form" class="full-width input-style-1" value="@if(@old('lastname')){{@old('lastname')}}@else{{$lastname}}@endif" required autocomplete="off" placeholder="lastname">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my8">
                        <div class="input-container full-width ">
                            <div class="flex align-center">
                                <label for="username" class="label-style-1 gray mr4">{{ __('Change username') }} </label>
                                <input type="button" class="simple-button pointer check-username mr4" value="check">
                                <div class="align-center red-box none">
                                    <img src="{{ asset('assets/images/icons/red-close.png') }}" class="small-image-size mr4" alt="">
                                    <span class="error fs12"></span>
                                </div>
                                <div class="align-center green-box none">
                                    <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="small-image-size mr4" alt="">
                                    <span class="green fs12"></span>
                                </div>
                            </div>
                            <div class="flex align-center">
                                <input type="text" id="username" name="username" form="profile-edit-form" class="input-style-1" value="@if(@old('username')){{@old('username')}}@else{{$username}}@endif" required autocomplete="off" placeholder="Username">
                            </div>
                            @error('username')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="input-container full-width">
                            <span class="error frt-error"></span>
                            <label for="username" class="label-style-1 gray mr4">{{ __('About me') }} </label>
                            <textarea name="about" id="about" form="profile-edit-form"></textarea>
                            <style>
                                .CodeMirror,
                                .CodeMirror-scroll {
                                    max-height: 200px;
                                    min-height: 200px;
                                }
                            </style>
                        </div>
                        <div>
                            <form action="{{ route('change.user.settings', ['user'=>$user->username]) }}" method="POST" id="profile-edit-form" class="flex align-center" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <input type="submit" value="{{ __('Save') }}" class="button-style">
                                <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="black-link ml8">{{__('Cancel')}}</a>
                            </form>
                            <script>
                                var simplemde = new SimpleMDE({ element: document.getElementById('about') });
                                simplemde.value(htmlDecode(`{{ $user->about }}`));

                                function htmlDecode(input){
                                    var e = document.createElement('textarea');
                                    e.innerHTML = input;
                                    // handle case of empty input
                                    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ms-right-panel">

            </div>
        </section>
    </div>
@endsection