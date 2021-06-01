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
    <div id="middle-container" class="middle-padding-1">
        <div class="flex align-center">
            <div>
                <a href="/" class="link-path">{{ __('Board index') }} > </a>
                <a href="{{ route('forum.misc', ['forum'=>$forum->slug]) }}" class="link-path">{{ __($forum->forum) }}</a>
            </div>
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
            <p class="mini-label">Be specific and imagine you’re asking a question to another person</p>
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
        <input type="hidden" name="thread_type" id="thread_type" value="1">
        <div class="input-container">
            <input type="hidden" class="thread_id" value="{{ $thread->id }}">
            <input type="hidden" name="_method" class="_method" value="PATCH">
            <input type="submit" class="button-style block edit-thread" value="{{ __('Save Changes') }}">
        </div>
    </div>
@endsection