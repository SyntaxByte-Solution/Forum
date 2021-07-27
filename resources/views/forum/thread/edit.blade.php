@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpush

@section('header')
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'questions'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div class="flex align-center space-between">
                <div>
                    <a href="/" class="link-path">{{ __('Board index') }} > </a>
                    <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="link-path">{{ __($forum->forum) }}</a>
                </div>
                <a href="{{ $thread->link }}" class="link-path"><< {{ __('return to the thread') }}</a>
            </div>
            <div class="flex space-between align-center">
                <h1 id="page-title">{{ __('Edit your discussion') }}</h1>
            </div>
            <div class="error-container none">
                <p class="error-message"></p>
            </div>
            <div class="input-container">
                <label for="subject" class="label-style-1" style="margin: 0">{{ __('Subject') }} <span class="error ml4 none">*</span></label>
                <div class="flex space-between align-end">
                    <p class="mini-label">Be specific and imagine you’re asking a question to another person</p>
                    <div class="flex align-center">
                        <p class="fs13 no-margin mr4">Edit visibility:</p>
                        <div class="status-box">
                            <div class="relative">
                                <div class="flex align-center pointer button-with-suboptions thread-status-changer" style="padding: 4px 6px">
                                    @php
                                        $icon;
                                        $alt = $thread->status->status;
                                        if($thread->status_id == 1) {
                                            $icon = "public14-icon";
                                        } else if($thread->status_id == 2) {
                                            $icon = "closed14-icon";
                                        } else if($thread->status_id == 3) {
                                            $icon = "followers14-icon";
                                        } else if($thread->status_id == 4) {
                                            $icon = "private14-icon";
                                        }
                                    @endphp
                                    <div class="size14 sprite sprite-2-size thread-status-button-14icon {{ $icon }}" title="{{ $alt }}"></div>
                                    <span class="gray fs12" style="margin-top: 1px">▾</span>
                                </div>
                                <div class="suboptions-container suboptions-container-right-style" style="left: 0; width:156px">
                                    <div class="pointer simple-suboption flex align-center thread-status-button">
                                        <div class="size18 sprite sprite-2-size public18-icon mr4"></div>
                                        <div class="fs13">{{ __('Public') }}</div>
                                        <input type="hidden" class="thread-add-status-slug" value="live">
                                        <input type="hidden" class="icon-when-selected" value="public14-icon">
                                        <div class="loading-dots-anim ml4 none">•</div>
                                    </div>
                                    <div class="pointer simple-suboption flex align-center thread-status-button">
                                        <div class="size18 sprite sprite-2-size followers18-icon mr4"></div>
                                        <div class="fs13">{{ __('Followers Only') }}</div>
                                        <input type="hidden" class="thread-add-status-slug" value="followers-only">
                                        <input type="hidden" class="icon-when-selected" value="followers14-icon">
                                        <div class="loading-dots-anim ml4 none">•</div>
                                    </div>
                                    <div class="pointer simple-suboption flex align-center thread-status-button">
                                        <div class="size18 sprite sprite-2-size private18-icon mr4"></div>
                                        <div class="fs13">{{ __('Only Me') }}</div>
                                        <input type="hidden" class="thread-add-status-slug" value="only-me">
                                        <input type="hidden" class="icon-when-selected" value="private14-icon">
                                        <div class="loading-dots-anim ml4 none">•</div>
                                    </div>
                                    <input type="hidden" class="thread-id" value="{{ $thread->id }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="text" id="subject" name="subject" class="full-width input-style-1" value="{{ $thread->subject }}" required autocomplete="off" placeholder="eg. Kifach nwli b7al Arnold f simana ?">
                @error('subject')
                    <p class="error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-container">
                @error('category_id')
                    <p class="error" role="alert">{{ $message }}</p>
                @enderror
                <label for="category" class="label-style-1">{{ __('Category') }} <span class="error ml4 none">*</span></label>
                <select name="category_id" id="category" class="dropdown-style">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @if($c->slug == $category->slug) selected @endif>{{ $c->category }}</option>
                    @endforeach
                </select>
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
                            <div class="size24 sprite sprite-2-size image24-icon mr4"></div>
                            <p class="no-margin fs13">Photos</p>
                            <input type="file" name="images[]" id="thread-photos" class="thread-add-file-input" multiple accept=".jpg,.jpeg,.png,.bmp,.gif">
                        </div>
                        <div class="flex align-center thread-add-button-hover-style relative">
                            <div class="size24 sprite sprite-2-size video24-icon mr4"></div>
                            <p class="no-margin fs13">Videos</p>
                            <input type="file" name="videos[]" id="thread-videos" class="thread-add-file-input" multiple accept=".mp4,.webm,.mpg,.mp2,.mpeg,.mpe,.mpv,.ogg,.mp4,.m4p,.m4v,.avi">
                        </div>
                    </div>
                </div>
                <div class="thread-add-uploaded-medias-container flex my4">
                    <input type="hidden" class="uploaded-images-counter" value="0" autocomplete="off">
                    <input type="hidden" class="uploaded-videos-counter" value="0" autocomplete="off">
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
                            <script type="module" defer>
                                let image = $('#media{{ $count }}');
                                let video_url = "{{ asset($media['frame']) }}";

                                var GetFileBlobUsingURL = function (url, convertBlob) {
                                        var xhr = new XMLHttpRequest();
                                        xhr.open("GET", url);
                                        xhr.responseType = "blob";
                                        xhr.addEventListener('load', function() {
                                            convertBlob(xhr.response);
                                        });
                                        xhr.send();
                                };
                                var blobToFile = function (blob, name) {
                                        blob.lastModifiedDate = new Date();
                                        blob.name = name;
                                        return blob;
                                };
                                var GetFileObjectFromURL = function(filePathOrUrl, convertBlob) {
                                    GetFileBlobUsingURL(filePathOrUrl, function (blob) {
                                        convertBlob(blobToFile(blob, 'testFile.jpg'));
                                    });
                                };

                                GetFileObjectFromURL(video_url, function (fileObject) {
                                    get_thumbnail(fileObject, 1.5, image.parent()).then(value => {
                                        image.attr("src", value);
                                    });
                                });
                                image.parent().imagesLoaded(function() {
                                    handle_image_dimensions(image);
                                });
                                already_uploaded_thread_videos_assets.push(video_url);
                            </script>
                            @elseif($media['type'] == 'image')
                            <script type="module" defer>
                                let image = $('#media{{ $count }}');
                                let image_url = "{{ asset($media['frame']) }}";
                                image.parent().imagesLoaded(function() {
                                    handle_image_dimensions(image);
                                });
                                already_uploaded_thread_images_assets.push(image_url);
                            </script>
                            @endif
                            <input type="hidden" class="uploaded-media-index" value="-1">
                            <input type="hidden" class="uploaded-media-genre" value="">
                            <input type="hidden" class="uploaded-media-url" value="{{ $media['frame'] }}">
                        </div>
                        @php $count++; @endphp
                    @endforeach
                @endif
            </div>
            <script type="module" defer>
                console.log('uploaded images: ');
                console.log(already_uploaded_thread_images_assets);
                console.log('uploaded videos: ');
                console.log(already_uploaded_thread_videos_assets);
            </script>
            <div class="input-container" style='margin-top: 10px'>
                <label for="content" class="label-style-1">{{ __('Content') }} <span class="error ml4 none">*</span></label>
                <p class="mini-label" style='margin-bottom: 6px'>Include all the information someone would need to answer your question</p>
                <textarea name="content" id="content"></textarea>
                <script>
                    var simplemde = new SimpleMDE();
                    simplemde.value(htmlDecode(`{{$thread->content}}`));

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
                <p class="my4 mr4">{{ __('Turn off replies on this thread') }}: </p>
                <input type="checkbox" id="thread-post-switch" @if($thread->replies_off) checked @endif>
            </div>
            <div class="simple-half-line-separator"></div>
            <div class="input-container">
                <input type="hidden" class="thread_id" value="{{ $thread->id }}">
                <input type="submit" class="button-style block edit-thread" value="{{ __('Save Changes') }}">
                <input type="hidden" class="text-button-no-ing" value="{{ __('Save Changes') }}">
                <input type="hidden" class="text-button-ing" value="{{ __('Saving changes..') }}">

                <input type="hidden" class="subject-required-error" value="{{ __('Subject field is required') }}">
                <input type="hidden" class="content-required-error" value="{{ __('Content field is required') }}">
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forum-guidelines-panel-section')
    </div>
@endsection