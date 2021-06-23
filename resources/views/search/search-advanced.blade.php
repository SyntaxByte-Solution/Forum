@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/search.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'search', 'subpage'=>'advanced-search'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div class="flex">
                <div>
                    <a href="/" class="link-path">{{ __('Board index') }} > </a>
                    <a href="/search" class="link-path">{{ __('Search') }} > </a>
                    <span class="current-link-path">{{ __('Advanced search') }}</span>
                </div>
                <a href="{{ route('users.search') }}" class="button-style move-to-right">{{ __('Users Search') }}</a>
            </div>
            <div class="flex">
                <div class="flex">
                    <h1 id="page-title" class="my8 fs28 forum-color">{{ __('Advanced search') }}</h1>
                </div>
            </div>
            <div>
                @php
                    
                @endphp
                <form action="{{ route('advanced.search.results') }}" method='get' class="full-width">
                    <div class="full-width">
                        <label for='main-srch' class="fs12 no-margin mt8" style="margin-bottom: 2px">{{ __('Search for thread by putting its keywords in the textbox down bellow') }}</label>
                        <input type="text" id="main-srch" name="k" class="input-style-1 full-width" value="{{ request()->input('k') }}" placeholder="Thread keywords" required>
                    </div>
                    <div class="my8">
                        <p class="bold gray fs16">Filters</p>
                    </div>
                    @error('forum')
                        <p class="error">{{ $message }}</p>
                    @enderror
                    <div class="full-width flex my8">
                        <label for="forum_category_dropdown" class="mr8 fs13 bold  no-margin" style="width: 160px">{{__('Forum')}}</label>
                        <span class="bold mx4">:</span>
                        <select name="forum" id="forum_category_dropdown" class="dropdown-style" style="width: 180px">
                            <option value="0">{{ __("All forums") }}</option>
                            @foreach($forums as $forum)
                                <option value="{{ $forum->id }}">{{ __("$forum->forum") }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="simple-line-separator my8"></div>
                    @error('category')
                        <p class="error">{{ $message }}</p>
                    @enderror
                    <div class="full-width flex align-center">
                        <label for="category_dropdown" class="mr8 fs13 bold" style="width: 160px">{{ __('Category') }}</label>
                        <span class="bold mx4">:</span>
                        <select name="category" id="category_dropdown" class="dropdown-style" style="width: 180px">
                            <option value="0">{{ __("All categories") }}</option>
                        </select>
                    </div>
                    <div class="simple-line-separator my8"></div>
                    @error('hasbestreply')
                        <p class="error">{{ $message }}</p>
                    @enderror
                    <div class="full-width flex">
                        <label class="mr8 fs13 bold" style="width: 160px">{{ __('Select only threads with best reply') }}</label>
                        <span class="bold mx4">:</span>
                        <input type="checkbox" name="hasbestreply">
                    </div>
                    <div class="simple-line-separator my4"></div>
                    @error('threads_date')
                        <p class="error">{{ $message }}</p>
                    @enderror
                    <div class="full-width flex align-center">
                        <label for="threads_date" class="mr8 fs13 bold" style="width: 160px">{{ __('Date') }}</label>
                        <span class="bold mx4">:</span>
                        <select name="threads_date" id="threads_date" class="dropdown-style" style="width: 180px">
                            <option value="anytime">{{ __("anytime") }}</option>
                            <option value="past24hours">{{ __("past 24 hours") }}</option>
                            <option value="pastweek">{{ __("past week") }}</option>
                            <option value="pastmonth">{{ __("past month") }}</option>
                            <option value="pastyear">{{ __("past year") }}</option>
                        </select>
                    </div>
                    <div class="simple-line-separator my4"></div>
                    <div class="full-width flex align-center">
                        <label for="sorted_by" class="mr8 fs13 bold" style="width: 160px">{{ __('Sorted by') }}</label>
                        <span class="bold mx4">:</span>
                        <select name="sorted_by" id="sorted_by" class="dropdown-style" style="width: 180px">
                            <option value="created_at_desc">{{ __("Creation date --Newest--") }}</option>
                            <option value="created_at_asc">{{ __("Creation date --Oldest--") }}</option>
                            <option value="views">{{ __("Number of views") }}</option>
                            <option value="votes">{{ __("Number of votes") }}</option>
                            <option value="likes">{{ __("number of likes") }}</option>
                        </select>
                    </div>
                    <div class="simple-line-separator my8"></div>
                    <input type="submit" class="button-style-1" style="padding: 9px 12px" value="{{ __('Search') }}">
                </form>
            </div>
            <div class="simple-line-separator my8"></div>
        </div>
        <div>
            <div class="ms-right-panel mb8">
                <div>
                    <p class="black-link bold" style="margin-bottom: 12px; margin-top: 0">{{ __('Advanced Search Rules') }}</p>
                    <div class="ml8 block">
                        <p class="bold forum-color fs13" style="margin-bottom: 12px;">{{ __('Resource type') }}</p>
                        <p class="fs12 my4">• {{__('Choose the resource you want to search (user, thread, [product in market - not supported yet])')}}.</p>
                        <p class="fs12 my4">• {{ __('Th filters will be changed based on the resource type') }}</p>
                    </div>
                </div>
                <div>
                    <p class="bold forum-color fs13 ml8 pointer" style="margin-bottom: 12px;">Thread Filters</p>
                    <div class="ml8">
                        <p class="fs12 my4">• {{ __('Select the forum where you want to search, or select all forums to search in the entire forums') }}.</p>
                        <p class="fs12 my4">• {{ __("Select the category where you want to search, or select all categories to search in all forum's categories") }}.</p>
                        <p class="fs12 my4">• {{ __('If you want to return only the threads where the owner mark as best reply, check the Select only threads with best reply checkbox') }}.</p>
                    </div>
                </div>
                <div>
                    <p class="bold forum-color fs13 ml8 pointer" style="margin-bottom: 12px;">Users Search</p>
                    <div class="ml8">
                        <p class="fs12 my4">• {{ __('If you want to search for a user, go to ') }} <a href="{{ route('users.search') }}" class="link-path">users search</a> {{ __(' page') }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection