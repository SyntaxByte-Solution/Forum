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
                @if($is_current)
                <h1 class="my8 fs20">My Activities</h1>
                @else
                <h1 class="my8 fs20">{{ $user->username }} activities</h1>
                @endif
                <div class="activities-sections-container">
                    <div class="activities-sections-header">
                        <div class="flex inline-buttons-container">
                            <div class="inline-button-style align-center selected-inline-button-style">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                                {{ __('Threads') }}
                            </div>
                            @if($is_current)
                            <div class="inline-button-style align-center">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/></svg>
                                {{ __('Saved threads') }}
                            </div>
                            @endif
                            <div class="inline-button-style align-center">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.4,64.3C400.6,15.7,311.3,23,256,79.3,200.7,23,111.4,15.6,53.6,64.3-21.6,127.6-10.6,230.8,43,285.5L218.4,464.2a52.52,52.52,0,0,0,75.2.1L469,285.6C522.5,230.9,533.7,127.7,458.4,64.3ZM434.8,251.8,259.4,430.5c-2.4,2.4-4.4,2.4-6.8,0L77.2,251.8c-36.5-37.2-43.9-107.6,7.3-150.7,38.9-32.7,98.9-27.8,136.5,10.5l35,35.7,35-35.7c37.8-38.5,97.8-43.2,136.5-10.6,51.1,43.1,43.5,113.9,7.3,150.8Z"/></svg>
                                {{ __('Threads I liked') }}
                            </div>
                            <div class="inline-button-style align-center">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></svg>
                                {{ __('Threads I voted on') }}
                            </div>
                            <div class="inline-button-style align-center">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M48,48A48,48,0,1,0,96,96,48,48,0,0,0,48,48Zm0,160a48,48,0,1,0,48,48A48,48,0,0,0,48,208Zm0,160a48,48,0,1,0,48,48A48,48,0,0,0,48,368Zm448,16H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V400A16,16,0,0,0,496,384Zm0-320H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V80A16,16,0,0,0,496,64Zm0,160H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V240A16,16,0,0,0,496,224Z"/></svg>
                                {{ __('Activity log') }}
                            </div>
                        </div>
                    </div>
                    <div id="activities-sections-content" style="padding: 12px">
                        <div class="activities-section-body">
                            <h3 class="no-margin forum-color flex align-center unselectable mb8">
                                <svg class="size4 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
                                {{ __('Threads area') }} [<span class="current-thread-count mx4">{{ $threads->count() }}</span> / {{ $user->threads->count() }} {{ __('threads') }}]
                            </h3>
                            @foreach($threads as $thread)
                                @php
                                    $is_ticked = $thread->posts->where('ticked', 1)->count();
        
                                    $forum = $thread->forum();
                                    $category = $thread->category;
        
                                    $forum_slug = $thread->forum()->slug;
                                    $category_slug = $thread->category->slug;
                                @endphp
                                <div class="activity-thread-wrapper" style="@if($is_ticked) background-color: #cfffcf21; border: 1px solid #a7cca7bd; @endif">
                                    <div class="flex align-center mb8">
                                        <div class="flex align-center">
                                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                {!! $forum->icon !!}
                                            </svg>
                                            <div class="flex align-center">
                                                <a href="{{ route('forum.all.threads', ['forum'=>$forum_slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                                                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                                                <a href="{{ route('category.threads', ['forum'=>$forum_slug, 'category'=>$category_slug]) }}" class="fs11 black-link">{{ $category->category }}</a>
                                            </div>
                                            @if($is_ticked)
                                                <svg class="size20 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
                                            @endif
                                        </div>
                                        <div class="simple-border-container move-to-right">
                                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><path class="cls-1" d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                                            <p class="fs12 no-margin unselectable">{{ $thread->view_count }} {{ __('views') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div class="flex align-center height-max-content">
                                            <div class="flex flex-column align-center">
                                                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M431.34,379.05H80.7c-31.52,0-47.29-38.15-25-60.4L231,143.33a35.21,35.21,0,0,1,49.94,0L456.24,318.65C478.63,340.9,462.87,379.05,431.34,379.05Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:66px"/></svg>
                                                <span class="bold">{{ $thread->votes->count() }}</span>
                                                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M431.34,133H80.7c-31.52,0-47.29,38.15-25,60.4L231,368.67a35.21,35.21,0,0,0,49.94,0L456.24,193.35C478.63,171.1,462.87,133,431.34,133Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:66px"/></svg>
                                            </div>
                                            <div class="gray height-max-content mx4 fs10">•</div>
                                        </div>
                                        <div>
                                            <div>
                                                <a href="{{ $thread->link }}" class="blue no-underline bold flex ml4 fs15">{{ $thread->subject }}</a>
                                            </div>
                                            <div class="flex align-center mt8">
                                                <div class="simple-border-container mr4">
                                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.4,64.3C400.6,15.7,311.3,23,256,79.3,200.7,23,111.4,15.6,53.6,64.3-21.6,127.6-10.6,230.8,43,285.5L218.4,464.2a52.52,52.52,0,0,0,75.2.1L469,285.6C522.5,230.9,533.7,127.7,458.4,64.3ZM434.8,251.8,259.4,430.5c-2.4,2.4-4.4,2.4-6.8,0L77.2,251.8c-36.5-37.2-43.9-107.6,7.3-150.7,38.9-32.7,98.9-27.8,136.5,10.5l35,35.7,35-35.7c37.8-38.5,97.8-43.2,136.5-10.6,51.1,43.1,43.5,113.9,7.3,150.8Z"/></svg>
                                                    <p class="fs12 no-margin unselectable">{{ $thread->likes->count() }} likes</p>
                                                </div>
                                                <div class="simple-border-container mr4">
                                                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                                                    <p class="fs12 no-margin unselectable">{{ $thread->posts->count() }} replies</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(!$threads->count())
                            <div class="full-center">
                                <div>
                                    <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any discussions or question for the moment !") }}</p>
                                    <div class="flex">
                                        <div class="flex align-center move-to-middle my4">
                                            <p class="text-center">{{ __("To create a new discussion, click on the following button") }}</p>
                                            <a href="{{ route('thread.add') }}" class="button-style-1 flex align-center ml8 width-max-content">
                                                <svg class="size14 mr4" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 397.15 397.15"><path d="M390.88,12.37c-4.14-4.15-10.13-6.25-17.78-6.25-26.78,0-70.16,26-93.64,41.55l-1.91,1.27-5.28,41.68-14-28.34-4.81,3.52a763.05,763.05,0,0,0-85.75,73.26c-4.62,4.62-9.16,9.31-13.5,13.94l-.93,1-18.7,82.35-9.86-49.17L118,196.36c-3.84,5.26-7.46,10.53-10.78,15.65l-.62,1-8,62.92L86.17,250.56,82.63,263.1c-4.3,15.28-4.5,28.32-.67,38.5l-80,80a5.52,5.52,0,0,0-1.55,6.22A5.21,5.21,0,0,0,5.24,391a6.85,6.85,0,0,0,2.46-.49l36.94-14a15.23,15.23,0,0,0,5.11-3.41l49.61-52.77A44.27,44.27,0,0,0,118,324h0a82.94,82.94,0,0,0,22.18-3.4l12.54-3.54-25.33-12.49,62.92-8,.95-.62c5.12-3.31,10.39-6.94,15.66-10.79l9.19-6.7-49.17-9.86,82.34-18.71,1-.92c4.64-4.35,9.33-8.89,13.94-13.5,35.17-35.17,70.11-78.39,95.85-118.59l3-4.7L338.24,100,373,95.59l1.23-2.2C397.46,51.81,403.07,24.56,390.88,12.37Z"/></svg>
                                                {{__('Start a discussion')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                @include('partials.user-space.user-card')
            </div>
        </div>
    </div>
@endsection