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
    <div id="middle-container">
        <div class="flex space-between full-width">
            <div>
                <a href="" class="link-path">{{ __('Board index') }}</a>
                <!--<span class="current-link-path">The side effects of using glutamin</span>-->
            </div>
            <div>
                <a href="" class="button-style">{{ __('Start Discussion') }}</a>
            </div>
        </div>
        <div id="forums-section">
            <table class="forums-table">
                <tr>
                    <th class="table-col-header">MB FORUMS</th>
                    <th class="table-col-header table-numbered-column">DISCUSSIONS & QUESTIONS</th>
                    <th class="table-col-header table-numbered-column">REPLIES</th>
                    <th class="table-col-header table-last-post">LAST POST</th>
                </tr>
                <tr>
                    <td>
                        <div class="flex">
                            <div class="forum-category-icon-container">
                                <img src="" class="forum-category-icon" alt="">
                            </div>
                            <div>
                                <h2 class="forum-category-link-header"><a href="" class="forum-style-link">Music and Audio Production</a></h2>
                                <p class="forum-category-description">Discussion of music production, audio, equipment and any related topics, either with or without Ableton Live </p>
                            </div>
                        </div>
                    </td>
                    <td class="fs13">15488</td>
                    <td class="fs13">98555</td>
                    <td>
                        <div>
                            <a href="" class="block forum-style-link fs12 bold">Re: Recording Automation in A…</a>
                            <p class="no-margin fs11">by <a href="" class="bold forum-style-link fs11">Hostname47 </a></p>
                            <p class="fs11 no-margin" style="margin-top: 3px">Wed May 19, 2021 11:13 pm </p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection