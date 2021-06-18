@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.activities'])
    <div id="middle-container" class="middle-padding-1">
        <div class="flex">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page'=>'activities'])
                <div class="flex space-between">
                    <h2 class="my8 fs20">My Activities</h2>
                    <div class="mr8">
                        @unless($all)
                            {{ $threads->onEachSide(0)->links() }}
                        @endunless
                    </div>
                </div>
                <table class="forums-table">
                    <tr>
                        <th class="table-col-header">
                            <div class="flex space-between align-center">
                                <div>
                                    {{ __('Threads') }}@if($all) ({{$threads->count()}}) @endif
                                </div>
                                <div>
                                    <div class="mx4 inline-block">
                                        <div class="flex align-center">
                                            <span>rows: </span>
                                            <select name="" class="small-dropdown row-num-changer">
                                                <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                                <option value="20" @if($pagesize == 20) selected @endif>20</option>
                                                <option value="50" @if($pagesize == 50) selected @endif>50</option>
                                                <option value="all" @if($pagesize == 'all') selected @endif>ALL</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th class="table-col-header table-numbered-column">{{ __('REPLIES/VIEWS') }}</th>
                        <th class="table-col-header">{{ __('LAST POST') }}</th>
                    </tr>
                    @foreach($threads as $thread)
                        <x-index-resource :thread="$thread"/>
                    @endforeach
                </table>
                @if(!$threads->count())
                    <div class="full-center">
                        <div>
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any discussions or question for the moment !") }}</p>
                            @php
                                $forum = \App\Models\Forum::first();
                                $forum_slug = $forum->slug;
                                $category_slug = $forum->categories->first()->slug;
                            @endphp
                            <p class="my4 text-center">{{ __("Try to create a new ") }} <a href="{{ route('thread.add', ['forum'=>$forum_slug, 'category'=>$category_slug]) }}" class="link-path">{{__('thread')}}</a></p>
                        </div>
                    </div>
                @endif
            </div>
            <div>
                @include('partials.user-space.user-card')
            </div>
        </div>
    </div>
@endsection