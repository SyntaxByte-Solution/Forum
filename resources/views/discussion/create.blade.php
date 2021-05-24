@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex space-between align-center">
            <h1 id="page-title">Start a discussion</h1>
        </div>
        
        <form action="/thread" method="POST" class="block">
            @csrf
            <div class="input-container">
                <label for="title" class="label-style-1">{{ __('Title') }} @error('subject') <span class="error">*</span> @enderror</label>
                <p class="mini-label">Be specific and imagine you’re asking a question to another person</p>
                <input type="text" id="title" name="subject" class="full-width input-style-1 @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required autocomplete="off" placeholder="eg. Kifach nwli b7al Arnold f simana ?">
                @error('subject')
                    <p class="error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="input-container">
                @error('category_id')
                    <p class="error" role="alert">{{ $message }}</p>
                @enderror
                <label for="category" class="label-style-1">{{ __('Category') }} @error('category_id') <span class="error">*</span> @enderror</label>
                <select name="category_id" id="category" class="dropdown-style">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="input-container" style='margin-top: 20px'>
                <label for="content" class="label-style-1">{{ __('Body') }} @error('content') <span class="error">*</span> @enderror</label>
                <p class="mini-label">Include all the information someone would need to answer your question</p>
                <textarea name="content" id="content" required></textarea>
            </div>
            <input type="hidden" name="thread_type" value="1">
            <div class="input-container">
                <input type="submit" class="button-style block" style="margin-bottom: 8px" value="{{ __('Share') }}">
            </div>
        </form>
    </div>
@endsection