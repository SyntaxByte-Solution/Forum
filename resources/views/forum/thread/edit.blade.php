@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simplemde.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/simplemde.js') }}"></script>
    <script src="{{ asset('js/thread/edit.js') }}" defer></script>
@endpush

@section('header')
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'questions'])
    <div id="page-top" class="flex align-center space-between middle-padding-1">
        <div class="flex align-center">
            <a href="/" class="link-path flex align-center unselectable">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
                {{ __('Board index') }}
            </a>
            <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <span class="current-link-path unselectable">{{ __('Discussion Update') }}</span>
        </div>
        <div>
            <a href="{{ $thread->link }}" class="link-path flex align-center unselectable">
                <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M31.7,239l136-136a23.9,23.9,0,0,1,33.8-.1l.1.1,22.6,22.6a23.91,23.91,0,0,1,.1,33.8l-.1.1L127.9,256l96.4,96.4a23.91,23.91,0,0,1,.1,33.8l-.1.1L201.7,409a23.9,23.9,0,0,1-33.8.1l-.1-.1L31.8,273a23.93,23.93,0,0,1-.26-33.84l.16-.16Z"/></svg>
                {{ __('Return to discussion') }}
            </a>
        </div>
    </div>
    <div class="full-width middle-padding-1" style="padding-top: 0; margin-bottom: 20px">
        <h1 class="fs26 no-margin forum-color" style="margin-bottom: 12px">{{ __('Edit your discussion') }}</h1>
        <div class="my8 thread-edit-error-container none">
            <div class="flex">
                <svg class="size14 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                <span class="error fs13 bold no-margin thread-edit-error"></span>
            </div>
        </div>
        <div>
            <!-- validation errors messages -->
            <input type="hidden" class="subject-required-error" value="{{ __('Title field is required') }}">
            <input type="hidden" class="category-required-error" value="{{ __('Category field is required') }}">
            <input type="hidden" class="content-required-error" value="{{ __('Content field is required') }}">
        </div>
        <div class="input-container">
            @error('category_id')
                <p class="error" role="alert">{{ $message }}</p>
            @enderror
            <label for="category" class="label-style-1">{{ __('Category') }} <span class="error ml4 none">*</span></label>
            <select name="category_id" id="category" class="dropdown-style">
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @if($c->slug == $category->slug) selected @endif>{{ __($c->category) }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-container">
            <label for="subject" class="label-style-1" style="margin: 0">{{ __('Title') }} <span class="error ml4 none">*</span></label>
            <div class="flex space-between align-end">
                <p class="mini-label">{{ __('Be specific and imagine you’re talking to another person') }}</p>
                <div class="flex align-center">
                    <p class="fs13 no-margin mr4">{{__('Edit visibility')}}:</p>
                    <div class="visibility-box">
                        <div class="relative">
                            <div class="flex align-center pointer button-with-suboptions thread-visibility-changer" style="padding: 4px 6px" title="{{ $thread->visibility->visibility }}">
                                <svg class="size14 thread-resource-visibility-icon" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    {!! $thread->visibility->icon !!}
                                </svg>
                                <span class="gray fs12" style="margin-top: 1px">▾</span>
                            </div>
                            <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:max-content">
                                <div class="pointer simple-suboption flex align-center thread-visibility-button" title="{{ __('Public') }}">
                                    <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z"/></svg>
                                    <div class="fs13">{{ __('Public') }}</div>
                                    <input type="hidden" class="thread-add-visibility-slug" value="public">
                                    <input type="hidden" class="icon-path-when-selected" value="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z">
                                    <div class="loading-dots-anim ml4 none">•</div>
                                </div>
                                <div class="pointer simple-suboption flex align-center thread-visibility-button" title="{{ __('Followers Only') }}">
                                    <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z"/></svg>
                                    <div class="fs13">{{ __('Followers Only') }}</div>
                                    <input type="hidden" class="thread-add-visibility-slug" value="followers-only">
                                    <input type="hidden" class="icon-path-when-selected" value="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z">
                                    <div class="loading-dots-anim ml4 none">•</div>
                                </div>
                                <div class="pointer simple-suboption flex align-center thread-visibility-button" title="{{ __('Only Me') }}">
                                    <svg class="size17 mr4" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z"/></svg>
                                    <div class="fs13">{{ __('Only Me') }}</div>
                                    <input type="hidden" class="thread-add-visibility-slug" value="private">
                                    <input type="hidden" class="icon-path-when-selected" value="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z">
                                    <div class="loading-dots-anim ml4 none">•</div>
                                </div>
                                <input type="hidden" class="message-after-change" value="{{ __('Your discussion visibility has been changed successfully') }}.">
                                <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="text" id="subject" name="subject" class="full-width styled-input" value="{{ $thread->subject }}" required autocomplete="off" placeholder="{{ __('Update your title here') }}">
            @error('subject')
                <p class="error" role="alert">{{ $message }}</p>
            @enderror
        </div>
        <div class="input-container content-container" style='margin-top: 10px'>
            <label for="content" class="label-style-1">{{ __('Content') }} <span class="error ml4 none">*</span></label>
            <p class="mini-label" style='margin-bottom: 6px'>{{ __('Include all the information someone would need to understand your discussion') }}</p>
            <textarea name="content" id="content" placeholder="{{ __('Update your discussion') }}">{{ $thread->content }}</textarea>
            <style>
                .CodeMirror,
                .CodeMirror-scroll {
                    max-height: 220px;
                    min-height: 220px;
                    border-radius: 0;
                    border-color: #b9b9b9;
                }
                .CodeMirror-scroll:focus {
                    border-color: #64ceff;
                    box-shadow: 0 0 0px 3px #def2ff;
                }
                .editor-toolbar {
                    padding: 0 4px;
                    opacity: 0.8;
                    height: 38px;
                    border-radius: 0;
                    border-top-color: #b9b9b9;
                    background-color: rgb(244, 244, 244);

                    display: flex;
                    align-items: center;
                }
                .editor-toolbar .fa-arrows-alt, .editor-toolbar .fa-columns,
                .share-post-form .separator:nth-of-type(2), .editor-statusbar {
                    display: none !important;
                }
            </style>
        </div>
        <div class="flex">
            <div class="flex align-center move-to-right">
                <label for="thread-post-switch" class="my4 mr4 flex align-center">
                    <svg class="size17 flex mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><circle cx="286.31" cy="273.61" r="20.21"/><circle cx="205.48" cy="273.61" r="20.21"/><circle cx="124.65" cy="273.61" r="20.21"/><path d="M437.87,249.45v44.37H377.24V262.45A130.67,130.67,0,0,1,336.83,255V374.65H160.62l-13.74,40.42-13.74-40.42h-59V172.58h182a131.13,131.13,0,0,1-6.64-40.42H155V71.54H263.84A131.48,131.48,0,0,1,287.36,39,4.66,4.66,0,0,0,284,31.13H152.13a37.58,37.58,0,0,0-37.58,37.58v63.45H70.09a36.57,36.57,0,0,0-36.37,36.38V378.69a36.57,36.57,0,0,0,36.37,36.38h34l19.2,52.33a28.08,28.08,0,0,0,24.25,13.74h5a28.48,28.48,0,0,0,22.63-20.2l14.55-45.87H340.87a36.57,36.57,0,0,0,36.37-36.38V334.24H440.7a37.59,37.59,0,0,0,37.58-37.59V230.49a4.67,4.67,0,0,0-7.89-3.37A131.55,131.55,0,0,1,437.87,249.45Z"/><path d="M422.66,69A75.55,75.55,0,0,0,318,173.66ZM444,90.34A75.55,75.55,0,0,1,339.34,195ZM381,26.25A105.75,105.75,0,1,1,275.25,132,105.76,105.76,0,0,1,381,26.25Z" style="fill-rule:evenodd"/></svg>
                    {{ __('Turn off replies on this discussion') }}: 
                </label>
                <input type="checkbox" id="thread-post-switch" @if($thread->replies_off) checked @endif>
            </div>
        </div>
        <div class="input-container">
            <label for="category" class="label-style-1">{{ __('Medias') }}</label>
            <div class="thread-add-media-section px8">
                <div class="thread-add-media-error px8 my8">
                    <p class="error tame-image-type none">* {{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported') }}.</p>
                    <p class="error tame-image-limit none">* {{ __('You could only upload 20 images max per post') }}.</p>
                    <p class="error tame-video-type none">* {{ __('Only .MP4, .WEBM, .MPG, .MP2, .MPEG, .MPE, .MPV, .OGG, .M4P, .M4V, .AVI video formats are supported') }}.</p>
                    <p class="error tame-video-limit none">* {{ __('You could only upload 4 videos max per post') }}.</p>
                </div>
                <div class="flex align-center">
                    <p class="no-margin fs13">{{ __('Add media') }}: </p>
                    <div class="flex align-center thread-add-button-hover-style mr8 relative">
                        <svg class="size24" style="margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M395.3,76H116.72C94.26,76,76,95.47,76,119.46V392.59c0,24,18.26,43.41,40.72,43.41H395.3c22.46,0,40.7-19.45,40.7-43.41V119.46C436,95.47,417.76,76,395.3,76Zm-86.5,64.63c21.71,0,39.32,18.79,39.32,42s-17.61,42-39.32,42-39.33-18.79-39.33-42S287.07,140.63,308.8,140.63Zm73.73,255.22H135.1c-10.86,0-15.7-8.38-10.81-18.73l67.5-142.61c4.89-10.34,14.21-11.26,20.81-2.06l67.87,94.61c6.6,9.21,18.13,10,25.77,1.75l16.6-17.94c7.63-8.24,18.87-7.22,25.1,2.27l43,65.51C397.14,388.15,393.4,395.85,382.53,395.85Z" style="fill:#010002"/></svg>
                        <p class="no-margin fs13">{{__('Photo')}}</p>
                        <input type="file" name="images[]" id="thread-photos" class="thread-add-file-input" multiple accept=".jpg,.jpeg,.png,.bmp,.gif">
                    </div>
                    <div class="flex align-center thread-add-button-hover-style relative">
                        <svg class="size24" style="margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,56C145.52,56,56,145.52,56,256s89.52,200,200,200,200-89.52,200-200S366.48,56,256,56Zm93.31,219.35L207.37,356.81a19.39,19.39,0,0,1-28.79-16.94V172.13a19.41,19.41,0,0,1,28.79-16.94l141.94,86.29C362.53,248.9,362.53,268,349.31,275.35Z"/></svg>
                        <p class="no-margin fs13">{{__('Video')}}</p>
                        <input type="file" name="videos[]" id="thread-videos" class="thread-add-file-input" multiple accept=".mp4,.webm,.mpg,.mp2,.mpeg,.mpe,.mpv,.ogg,.mp4,.m4p,.m4v,.avi">
                    </div>
                </div>
            </div>
            <!-- the following div will be used to clone uploaded images -->
            <div class="thread-add-uploaded-media relative none thread-add-uploaded-media-projection-model">
                <img src="" class="thread-add-uploaded-image move-to-middle none" alt="">
                <div class="close-thread-media-upload x-close-container-style remove">
                    <span class="x-close unselectable">✖</span>
                </div>
                <div class="thread-add-video-indicator full-center none">
                    <svg class="size36" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 271.95 271.95"><path d="M136,272A136,136,0,1,0,0,136,136,136,0,0,0,136,272ZM250.2,136A114.22,114.22,0,1,1,136,21.76,114.35,114.35,0,0,1,250.2,136ZM112.29,205a21.28,21.28,0,0,0,8.24,1.66,21.65,21.65,0,0,0,15.34-6.37l48.93-49a21.75,21.75,0,0,0,0-30.77L135.84,71.64a21.78,21.78,0,0,0-15.4-6.37,20.81,20.81,0,0,0-8.15,1.66A21.58,21.58,0,0,0,99,87v97.91A21.6,21.6,0,0,0,112.29,205Zm8.5-116.42V87l49,48.95-48.95,49Z"/></svg>
                </div>
                <input type="hidden" class="uploaded-media-index" value="-1">
                <input type="hidden" class="uploaded-media-genre" value="">
            </div>
            <div id="thread-uploads-wrapper" class="thread-add-uploaded-medias-container flex my4">
                <input type="hidden" class="uploaded-images-counter" value="0" autocomplete="off">
                <input type="hidden" class="uploaded-videos-counter" value="0" autocomplete="off">
                @php
                    $count = 0;
                @endphp
                @if($thread->has_media)
                    @foreach($medias as $media)
                        <div class="thread-add-uploaded-media relative">
                            <img src="@if($media['type'] == 'image'){{ asset($media['frame']) }}@endif" class="thread-add-uploaded-image move-to-middle" id="media{{ $count }}" alt="">
                            <div class="close-thread-media-upload-edit x-close-container-style remove">
                                <span class="x-close unselectable">✖</span>
                            </div>
                            @if($media['type'] == 'video')
                            <div class="thread-add-video-indicator full-center">
                                <svg class="size36" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 271.95 271.95"><path d="M136,272A136,136,0,1,0,0,136,136,136,0,0,0,136,272ZM250.2,136A114.22,114.22,0,1,1,136,21.76,114.35,114.35,0,0,1,250.2,136ZM112.29,205a21.28,21.28,0,0,0,8.24,1.66,21.65,21.65,0,0,0,15.34-6.37l48.93-49a21.75,21.75,0,0,0,0-30.77L135.84,71.64a21.78,21.78,0,0,0-15.4-6.37,20.81,20.81,0,0,0-8.15,1.66A21.58,21.58,0,0,0,99,87v97.91A21.6,21.6,0,0,0,112.29,205Zm8.5-116.42V87l49,48.95-48.95,49Z"/></svg>
                            </div>
                            @endif
                            <input type="hidden" class="uploaded-media-index" value="-1">
                            <input type="hidden" class="uploaded-media-genre" value="{{ $media['type'] }}">
                            <input type="hidden" class="uploaded-media-url" value="{{ asset($media['frame']) }}">
                        </div>
                        @php $count++; @endphp
                    @endforeach
                @endif
            </div>
        </div>
        <div class="flex align-center">
            <div class="input-container">
                <input type="hidden" class="thread_id" value="{{ $thread->id }}">
                <input type="submit" class="button-style block edit-thread" value="{{ __('Save Changes') }}">
                <input type="hidden" class="text-button-no-ing" value="{{ __('Save Changes') }}">
                <input type="hidden" class="text-button-ing" value="{{ __('Saving changes') }}..">
            </div>
            <div class="spinner size20 ml8 opacity0" id="edit-thread-button-spinner">
                <svg class="size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forum-guidelines-panel-section')
    </div>
@endsection