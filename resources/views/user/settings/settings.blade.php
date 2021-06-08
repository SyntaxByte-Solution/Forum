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
                <div class="relative us-user-media-container">
                    <div class="us-settings-cover-container full-center relative">
                        @if(!$user->cover)
                            <div class="full-center full-dimensions">
                                <input type="file" class="full-dimensions bottom0 absolute pointer" style="height: 200%">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/image.png') }}" class="small-image mr4" alt="">
                                    <p class="fs17 white">Upload a cover</p>
                                </div>
                            </div>
                        @else
                            <img src="{{ $user->cover }}"  class="us-cover" alt="">
                            <div class="absolute flex align-center" style="bottom: 6px; right: 6px">
                                <div class="flex align-center px8 py8 change-cover-cont relative">
                                    <input type="file" class="opacity0 absolute full-dimensions bottom0 pointer" style="height: 200%">
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
                            <a href="ererer" class="small-image-size absolute" style="top: 6px; right: 6px">
                                <img src="{{ asset('assets/images/icons/wx.png') }}" class="small-image-size" alt="">
                            </a>
                            <div class="absolute full-center update-avatar-bottom-section hidden-overflow">
                                <input type="file" name="avatar" class="absolute bottom0 opacity0 pointer full-width full-height block" style="height: 200%">
                                <a href="" class="white simple-link no-underline">{{__('Update Avatar')}}</a>
                            </div>
                            <a href="{{ route('user.activities', ['user'=>$user->username]) }}">
                                <div class="us-settings-profile-picture-container full-center">
                                    <img src="{{ $user->avatar }}" class="us-settings-profile-picture" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="ml8 full-width">
                            <h2 class="no-margin forum-color">{{ $firstname . ' ' . $lastname }}</h2>
                            <div class="flex">
                                <div class="input-container full-width" style="margin-right: 8px">
                                    <label for="firstname" class="label-style-1 gray">{{ __('Firstname') }} @error('firstname') <span class="error">* this field is required</span> @enderror <span class="error frt-error">* this field is required</span></label>
                                    <input type="text" id="firstname" name="subject" class="full-width input-style-1" value="{{ $firstname }}" required autocomplete="off" placeholder="firstname">
                                    @error('name')
                                        <p class="error" role="alert">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="input-container full-width ">
                                    <label for="lastname" class="label-style-1 gray">{{ __('Lastname') }} @error('lastname') <span class="error">* this field is required</span> @enderror <span class="error frt-error">* this field is required</span></label>
                                    <input type="text" id="lastname" name="lastname" class="full-width input-style-1" value="{{ $lastname }}" required autocomplete="off" placeholder="lastname">
                                    @error('lastname')
                                        <p class="error" role="alert">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my8">
                        <div class="input-container full-width ">
                            <span class="error frt-error">* this field is required</span>
                            <div class="flex align-center">
                                <label for="username" class="label-style-1 gray mr4">{{ __('Change username') }} </label>
                                <a href="" class="simple-button">check</a>
                            </div>
                            <div class="flex align-center">
                                <input type="text" id="username" name="username" class="input-style-1" value="{{ $username }}" required autocomplete="off" placeholder="Username">
                            </div>
                            @error('username')
                                <p class="error" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="input-container full-width">
                            <span class="error frt-error"></span>
                            <label for="username" class="label-style-1 gray mr4">{{ __('About me') }} </label>
                            <textarea name="about" id="about"></textarea>
                            <script>
                                var simplemde = new SimpleMDE();
                                simplemde.value(htmlDecode(`{{ $user->about }}`));

                                function htmlDecode(input){
                                    var e = document.createElement('textarea');
                                    e.innerHTML = input;
                                    // handle case of empty input
                                    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
                                }
                            </script>
                            <style>
                                .CodeMirror,
                                .CodeMirror-scroll {
                                    max-height: 200px;
                                    min-height: 200px;
                                }
                            </style>
                        </div>
                        <div class="flex align-center">
                            <a href="" class="button-style">{{__('Save')}}</a>
                            <a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="black-link ml8">{{__('Cancel')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ms-right-panel">

            </div>
        </section>
    </div>
@endsection