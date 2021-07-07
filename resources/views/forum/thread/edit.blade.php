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
                <a href="{{ $thread->link }}" class="link-path">{{ __('<< return to the thread') }}</a>
            </div>
            <div class="flex space-between align-center">
                <h1 id="page-title">Edit your discussion</h1>
            </div>
            <div class="state-message">
                @if(Session::has('message'))
                    <p class="{{ Session::get('type') }}">{!! Session::get('message') !!}</p>
                @endif
            </div>
            <div class="input-container">
                <label for="subject" class="label-style-1">{{ __('Subject') }} @error('subject') <span class="error">* this field is required</span> @enderror <span class="error frt-error">* this field is required</span></label>
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
                <label for="category" class="label-style-1">{{ __('Category') }} @error('category_id') <span class="error">*</span> @enderror<span class="error frt-error">* Invalidate category value</span></label>
                <select name="category_id" id="category" class="dropdown-style">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @if($c->slug == $category->slug) selected @endif>{{ $c->category }}</option>
                    @endforeach
                </select>
            </div>
                
            <div class="input-container" style='margin-top: 20px'>
                <label for="content" class="label-style-1">{{ __('Body') }} @error('content') <span class="error">*</span> @enderror <span class="error frt-error">* This field is required</span></label>
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
                <input type="hidden" name="_method" class="_method" value="PATCH">
                <input type="submit" class="button-style block edit-thread" value="{{ __('Save Changes') }}">
            </div>
        </div>
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forum-guidelines-panel-section')
    </div>
@endsection