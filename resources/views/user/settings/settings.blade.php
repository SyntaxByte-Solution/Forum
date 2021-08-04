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
                <div class="flex">
                    <h1 class="fs22 my8">{{__('Update Profile & Settings')}}</h1>
                </div>

                @if($errors->any())
                <div class="error-container">
                    <p class="error-message">{{$errors->first()}}</p>
                </div>
                @endif
                @if(Session::has('message'))
                    <div class="green-message-container mb8">
                        <p class="green-message">{{ Session::get('message') }}</p>
                    </div>
                @endif
                <div class="relative us-user-media-container">
                    <div class="us-settings-cover-container full-center relative" style="height: 185px">
                        <p class="error cover-error none">* {{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported') }}.</p>
                        <div class="absolute full-shadowed remove-cover-dialog flex flex-column align-center justify-center br6">
                            <p class="white bold fs17 my4 text-center">{{__('Remove cover')}} ?</p>
                            <div class="flex align-center">
                                <a href="" class="simple-white-button remove-cover-button">{{ __('Remove') }}</a>
                                <a href="" class="white no-underline my4 fs14 close-shadowed-view-button ml8">{{ __('cancel') }}</a>
                            </div>
                        </div>
                        <div class="full-center full-dimensions change-cover-back-container @if($user->cover) none @endif">
                            <div class="flex align-center">
                                <svg class="size20 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V112A48,48,0,0,0,464,64Zm-6,336H54a6,6,0,0,1-6-6V118a6,6,0,0,1,6-6H458a6,6,0,0,1,6,6V394A6,6,0,0,1,458,400ZM128,152a40,40,0,1,0,40,40A40,40,0,0,0,128,152ZM96,352H416V272l-87.52-87.51a12,12,0,0,0-17,0L192,304l-39.51-39.52a12,12,0,0,0-17,0L96,304Z" style="fill:#fff"/></svg>
                                <p class="fs17 white unselectable">{{__('ADD COVER')}}</p>
                            </div>
                        </div>
                        <img src="" class="uploaded-us-cover us-cover none" alt="">
                        <img src="{{ $user->cover }}" class="original-cover us-cover @if(!$user->cover) none @endif" alt="">
                        <div class="absolute flex align-center update-cover-box" style="bottom: 6px; right: 6px">
                            <div class="simple-button-style change-cover-cont">
                                <input type="hidden" name="cover_removed" autocomplete="off" value="0" class="cover-removed" form="profile-edit-form">
                                <input type="file" name="cover" form="profile-edit-form" autocomplete="off" class="opacity0 absolute full-dimensions bottom0 pointer cover-upload-button" style="height: 200%; left: 0">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V112A48,48,0,0,0,464,64Zm-6,336H54a6,6,0,0,1-6-6V118a6,6,0,0,1,6-6H458a6,6,0,0,1,6,6V394A6,6,0,0,1,458,400ZM128,152a40,40,0,1,0,40,40A40,40,0,0,0,128,152ZM96,352H416V272l-87.52-87.51a12,12,0,0,0-17,0L192,304l-39.51-39.52a12,12,0,0,0-17,0L96,304Z" style="fill:#fff"/></svg>
                                <p class="cover-upload-button-text fs14 no-margin white">@if(!$user->cover) {{__('Upload')}} @else {{__('Update')}} @endif</p>
                                <input type="hidden" class="update-btn-text" value="{{ __('Update') }}">
                                <input type="hidden" class="upload-btn-text" value="{{ __('Upload') }}">
                            </div>
                            <div class="simple-button-style discard-cover-upload none ml4">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>
                                <p class="fs14 no-margin white">{{ __('Discard') }}</p>
                            </div>
                            <div>
                                <svg class="size17 ml4 mr4 simple-button-style rounded remove-profile-cover @if(!$user->cover) none @endif" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"/></svg>
                            </div>
                        </div>
                    </div>
                    <p class="error avatar-error none" style="margin-top: 10px">* {{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported for avatar') }}.</p>
                    <div class="flex my8">
                        <div class="relative full-center" id="settings-avatar-area" style="height: max-content;">
                            <div class="absolute full-shadowed full-center remove-avatar-dialog br6" style="z-index: 5">
                                <p class="white bold my4 text-center">Remove avatar ?</p>
                                <div class="flex flex-column align-center">
                                    <div class="simple-white-button remove-avatar-button">Delete</div>
                                    <a href="" class="white no-underline my4 fs13 close-shadowed-view-button">cancel</a>
                                </div>
                            </div>
                            <div class="absolute" style="z-index: 2; right: 4px; top: 4px;">
                                <svg class="size10 remove-profile-avatar simple-icon-button-style @if(is_null($user->avatar)) none @endif" style="padding:6px; margin-bottom: 2px" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"/></svg>
                                <svg class="size10 undo-avatar-upload simple-icon-button-style none" style="padding:6px;" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 512.01 512.01"><path d="M511.14,286.26C502.08,194.86,419.84,128,328,128H192V48A16,16,0,0,0,166,35.5L6,163.5a16.05,16.05,0,0,0,0,25l160,128A16,16,0,0,0,192,304V224H331.39c41.86,0,80,30.08,84.19,71.72A80,80,0,0,1,336,384H208a16,16,0,0,0-16,16v64a16,16,0,0,0,16,16H336C438.82,480,521.47,391.15,511.14,286.26Z"/></svg>
                            </div>
                            <div class="full-center none update-avatar-section-button hidden-overflow">
                                <input type="hidden" name="avatar_removed" autocomplete="off" value="0" class="avatar-removed" form="profile-edit-form">
                                <input type="file" name="avatar" autocomplete="off" form='profile-edit-form' class="absolute bottom0 opacity0 pointer full-width full-height block avatar-upload-button" style="height: 200%">
                                <svg class="size20" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 512 512"><path d="M464,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V112A48,48,0,0,0,464,64Zm-6,336H54a6,6,0,0,1-6-6V118a6,6,0,0,1,6-6H458a6,6,0,0,1,6,6V394A6,6,0,0,1,458,400ZM128,152a40,40,0,1,0,40,40A40,40,0,0,0,128,152ZM96,352H416V272l-87.52-87.51a12,12,0,0,0-17,0L192,304l-39.51-39.52a12,12,0,0,0-17,0L96,304Z"/></svg>
                            </div>
                            <div class="us-settings-profile-picture-container full-center relative">
                                <img src="{{ \App\Models\User::sizeddefaultavatar(100, '-l') }}" class="default-avatar us-settings-profile-picture @if(!is_null($user->avatar)) none @endif" alt="">
                                <img src="{{ $user->avatar }}" class="original-avatar us-settings-profile-picture handle-image-center-positioning" alt="">
                                <img src="" class="uploaded-avatar @if(!$user->avatar) none @endif us-settings-profile-picture " alt="">
                            </div>
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
                            <form action="{{ route('change.user.settings.profile') }}" method="POST" id="profile-edit-form" class="flex align-center" enctype="multipart/form-data">
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
            <div>
                @include('partials.settings.profile-right-side-menu', ['item'=>'settings-general'])
                <div class="ms-right-panel my8">
                    <div class="toggle-box">
                        <a href="" class="black-link bold blue toggle-container-button" style="margin-bottom: 12px; margin-top: 0">Settings rules <span class="toggle-arrow">▾</span></a>
                        <div class="toggle-container ml8 block">
                            <p class="bold forum-color fs13" style="margin-bottom: 12px;">Cover</p>
                            <p class="fs12 my4">• {{__('Supported types')}}: PNG, SVG, BMP, GIF or JPG. At most 5MB.</p>
                            <p class="fs12 my4">• {{ __('Maximum dimensions:') }}</p>
                            <div class="ml8">
                                <p class="fs12 my4">* Height: 1280px max</p>
                                <p class="fs12 my4">* Width: 2050px max</p>
                            </div>
                        </div>
                    </div>
                    <div class="toggle-box">
                        <div class="toggle-container ml8 block">
                            <p class="bold forum-color fs13" style="margin-bottom: 12px;">Avatar</p>
                            <p class="fs12 my4">• {{__('Supported types')}}: PNG, SVG, BMP, GIF or JPG. At most 5MB.</p>
                            <p class="fs12 my4">• {{ __('Maximum dimensions:') }}</p>
                            <div class="ml8">
                                <p class="fs12 my4">* Height: 1000px max</p>
                                <p class="fs12 my4">* Width: 1000px max</p>
                            </div>
                        </div>
                    </div>
                    <div class="toggle-box">
                        <div class="toggle-container ml8 block">
                            <p class="bold forum-color fs13" style="margin-bottom: 12px;">Username</p>
                            <p class="fs12 my4">• {{ __('Should be unique(check it before saving your changes)') }}.</p>
                            <p class="fs12 my4">• {{ __('Should contain at least 6 characters') }}.</p>
                            <p class="fs12 my4">• {{ __('Only contains characters, numbers, dashes or underscores') }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection