@extends('layouts.app')

@push('styles')
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
        <div class="full-width index-middle-width middle-container-style">
            <div class="flex">
                <div>
                    <a href="/" class="link-path">{{ __('Board index') }} > </a>
                    <a href="/search" class="link-path">{{ __('Search') }} > </a>
                    <span class="current-link-path">{{ __('Advanced search') }}</span>
                </div>
                <a href="{{ route('users.search') }}" class="link-path flex align-center bold move-to-right">
                    <svg class="size17 mr4" fill="#2ca0ff" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                    {{ __('Users Search') }}
                </a>
            </div>
            <div class="flex">
                <div class="flex">
                    <h1 id="page-title" class="my8 fs28 forum-color">{{ __('Advanced search') }}</h1>
                </div>
            </div>
            <div>
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
                        <label for="forum_category_dropdown" class="mr8 fs13 bold  no-margin" style="width: 160px">{{__('Forum')}} @error('forum')<span class="error">*</span>@enderror</label>
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
                        <label for="threads_date" class="mr8 fs13 bold" style="width: 160px">{{ __('Thread Creation Date') }}</label>
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
        </div>
    </div>
    <div id="right-panel">
        @include('partials.right-panels.forums-list')
        <div class="mb8">
            <div>
                <div class="right-panel-header-container">
                    <p class="bold no-margin unselectable my4">{{ __('Advanced Search Rules') }}</p>
                </div>
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
                    <p class="fs12 my4">• {{ __('If you want to search for a user, go to ') }} <a href="{{ route('users.search') }}" class="link-path">{{ __('users search') }}</a> {{ __(' page') }}.</p>
                </div>
            </div>
        </div>
    </div>
@endsection