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
    @include('partials.left-panel', ['page' => 'user', 'subpage'=>'user.profile'])
    <div id="middle-container" class="middle-padding-1">
        <section class="flex">  
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page' => 'profile'])
                <div class="flex space-between">
                    <h1 class="">User Discussions</h1>
                    <div class="mr8">
                        @unless($all)
                            {{ $discussions->onEachSide(0)->links() }}
                        @endunless
                    </div>
                </div>
                <table class="forums-table">
                    <tr>
                        <th class="table-col-header">
                            <div class="flex space-between align-center">
                                <div>
                                    {{ __('Discussions') }}({{$discussions->count()}})
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
                    @foreach($discussions as $discussion)
                        <x-index-resource :thread="$discussion"/>
                    @endforeach
                </table>
                @if(!$discussions->count())
                    <div class="full-center">
                        <div>
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any discussions or question for the moment !") }}</p>
                            <p class="my4 text-center">{{ __("Try to create a ") }} <a href="{{ route('discussion.add', ['forum'=>'general']) }}" class="link-path">{{__('discussion')}}</a> / <a href="{{ route('question.add', ['forum'=>'general']) }}" class="link-path">{{__('question')}}</a></p>
                        </div>
                    </div>
                @endif
            </div>
            <div>
                @include('partials.user-space.user-card')
            </div>
        </section>
    </div>
@endsection