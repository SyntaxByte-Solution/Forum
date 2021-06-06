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
    @include('partials.left-panel', ['page' => 'myspace', 'subpage'=>'myspace.index'])
    <div id="middle-container" class="middle-padding-1">
        <h1 id="page-title">Beast Space</h1>
        <div class="flex">
            <div class="full-width">
                <div class="flex align-center space-between" style="margin-bottom: 10px">
                    <div class="flex align-center">
                        <!-- {{ __('') }} -->
                        <a href="" class="regular-menu-button">{{ __('Profile') }}</a>
                        <a href="" class="regular-menu-button rmb-selected">{{ __('Activities') }}</a>
                    </div>
                    <a href="" class="regular-menu-button move-to-right">{{ __('Edit profile and settings') }}</a>
                </div>
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
                                <p class="my4 text-center">{{ __("Try to create a ") }} <a href="" class="link-path">discussion</a> / <a href="" class="link-path">question</a></p>
                            </div>
                        </div>
                    @endif
            </div>
            <div>
                <div class="ms-right-panel">
                    <div class="flex px8 py8">
                        <div>
                            <img src="{{asset('avatar.jpg')}}" class="small-image-1 br6 mr8" alt="">
                        </div>
                        <div class="mr8">
                            <h2 class="no-margin">Mouad Nassri</h2>
                            <p class="fs12 no-margin gray">Joined Tue, May 25, 2021 1:17 AM</p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <p class="bold fs12 gray my8" style="margin-bottom: 0">{{ __('IMPACT') }}</p>
                            <div class="relative">
                                <p class="fs17 bold inline-block my4 tooltip-section">~ 2.4K</p>
                                <div class="tooltip tooltip-style-2 left0">
                                    Estimated number of times people viewed your helpful posts
                                    (based on page views of your questions
                                    and questions where you wrote highly-ranked answers)
                                </div>
                                <p class="fs12 gray no-margin">People reached</p>
                            </div>
                        </div>
                        <div class="simple-line-separator my8"></div>
                        <div>
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Discussions: </p><span class="fs15 bold ml8">541</span>
                                </div>
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/bqst.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Questions: </p><span class="fs15 bold ml8">988</span>
                                </div>
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                            </div>
                        </div>
                        <div>
                            <div class="flex align-center">
                                <div class="flex align-center">
                                    <img src="{{ asset('assets/images/icons/disc.png') }}" class="small-image-2 mr4" alt="">
                                    <p class="inline-block my4 fs13">Replies: </p><span class="fs15 bold ml8">11</span>
                                </div>
                                <div class="fill-thin-line"></div>
                                <span class="move-to-right">[<a href="" class="fs11 black-link">SEE</a>]</span>
                            </div>
                        </div>
                        <div>
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