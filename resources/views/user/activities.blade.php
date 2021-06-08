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
                                    {{ __('MY THREADS') }}@if($all) ({{$threads->count()}}) @endif
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
                                    <div class="inline-block">
                                        <a href="" class="ms-table-small-button mstsb-selected all-table-threads-changer">all</a>
                                        <a href="" class="ms-table-small-button all-table-discussions-changer">discussions</a>
                                        <a href="" class="ms-table-small-button all-table-questions-changer">questions</a>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th class="table-col-header table-numbered-column">{{ __('REPLIES') }}</th>
                        <th class="table-col-header table-numbered-column">{{ __('VIEWS') }}</th>
                        <th class="table-col-header">{{ __('LAST POST') }}</th>
                    </tr>
                    @foreach($threads as $thread)
                        <x-ms-resource-table-row :thread="$thread"/>
                    @endforeach
                </table>
                    @if(!$threads->count())
                        <div class="full-center">
                            <div>
                                <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any discussions or question for the moment !") }}</p>
                                <p class="my4 text-center">{{ __("Try to create a ") }} <a href="{{ route('discussion.add', ['forum'=>'general']) }}" class="link-path">{{__('discussion')}}</a> / <a href="{{ route('question.add', ['forum'=>'general']) }}" class="link-path">{{__('question')}}</a></p>
                            </div>
                        </div>
                    @endif
            </div>
            <div>
                <div class="ms-right-panel">
                    <div class="flex px8 py8">
                        <div>
                            <img src="{{ $user->avatar }}" class="small-image-1 br6 mr8" alt="">
                        </div>
                        <div class="mr8">
                            <h2 class="no-margin">{{ $user->firstname . ' ' . $user->lastname }}</h2>
                            <p class="fs12 no-margin gray">Join Date: {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <p class="bold fs12 gray my8" style="margin-bottom: 0">{{ __('IMPACT') }}</p>
                            <div class="relative">
                                <p class="fs17 bold inline-block my4 tooltip-section">~ {{ $user->reach }}</p>
                                <div class="tooltip tooltip-style-2 left0">
                                    Estimated number of times people viewed your helpful posts
                                    (based on page views of your questions
                                    and questions where you wrote highly-ranked answers)
                                </div>
                                <p class="fs12 gray no-margin">People reached</p>
                            </div>
                        </div>
                        <div class="simple-line-separator my8"></div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/disc.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Discussions: </p><span class="fs15 bold ml8">{{ $discussions_count }}</span>
                                </div>
                                @if($discussions_count)
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                                @endif
                            </div>
                        </div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/bqst.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Questions: </p><span class="fs15 bold ml8">{{ $questions_count }}</span>
                                </div>
                                @if($questions_count)
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                                @endif
                            </div>
                        </div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Replies: </p><span class="fs15 bold ml8">{{ $posts_count }}</span>
                                </div>
                                @if($posts_count)
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                                @endif
                            </div>
                        </div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/eye.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Profile views: </p><span class="fs15 bold ml8">{{ $user->profile_views }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="my4">
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Votes casts: </p><span class="fs15 bold ml8">20K</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection