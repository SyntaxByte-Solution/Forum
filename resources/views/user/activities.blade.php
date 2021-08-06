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
        <input type="hidden" class="activities-user" value="{{ $user->id }}">
        <div class="flex">
            <div class="full-width">
                @include('partials.user-space.basic-header', ['page'=>'activities'])
                <div class="flex">
                    @if($is_current)
                    <h1 class="my8 fs20">My Activities</h1>
                    @else
                    <h1 class="my8 fs20">{{ $user->username }} activities</h1>
                    @endif
                </div>
                <div class="activities-sections-container">
                    <div class="activities-sections-header" style="padding-right: 8px;">
                        <div class="flex inline-buttons-container">
                            <div class="inline-button-style align-center selected-inline-button-style activity-section-switcher" style="border-top-left-radius: 4px">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                                {{ __('Threads') }}
                                <input type="hidden" class="activity-section-name" value="threads">
                            </div>
                            @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id == $user->id)
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/></svg>
                                {{ __('Saved threads') }}
                                <input type="hidden" class="activity-section-name" value="saved-threads">
                            </div>
                            @endif
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.4,64.3C400.6,15.7,311.3,23,256,79.3,200.7,23,111.4,15.6,53.6,64.3-21.6,127.6-10.6,230.8,43,285.5L218.4,464.2a52.52,52.52,0,0,0,75.2.1L469,285.6C522.5,230.9,533.7,127.7,458.4,64.3ZM434.8,251.8,259.4,430.5c-2.4,2.4-4.4,2.4-6.8,0L77.2,251.8c-36.5-37.2-43.9-107.6,7.3-150.7,38.9-32.7,98.9-27.8,136.5,10.5l35,35.7,35-35.7c37.8-38.5,97.8-43.2,136.5-10.6,51.1,43.1,43.5,113.9,7.3,150.8Z"/></svg>
                                @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id == $user->id)
                                {{ __('Threads I liked') }}
                                @else
                                {{ __('Liked threads') }}
                                @endif
                                <input type="hidden" class="activity-section-name" value="liked-threads">
                            </div>
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></svg>
                                @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id == $user->id)
                                {{ __('Threads I voted on') }}
                                @else
                                {{ __('Voted Threads') }}
                                @endif
                                <input type="hidden" class="activity-section-name" value="voted-threads">
                            </div>
                            @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id == $user->id)
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 331.53 331.53"><path d="M197.07,216.42a11,11,0,0,1-11,11H145.46a11,11,0,0,1,0-22h40.61A11,11,0,0,1,197.07,216.42ZM331.53,51.9v68.32a11,11,0,0,1-11,11H313.4V279.63a11,11,0,0,1-11,11H29.13a11,11,0,0,1-11-11V131.22H11a11,11,0,0,1-11-11V51.9a11,11,0,0,1,11-11H320.53A11,11,0,0,1,331.53,51.9ZM291.4,131.22H221.24a56.55,56.55,0,0,1-110.94,0H40.13V268.63H291.4ZM165.77,154.77a34.61,34.61,0,0,0,32.75-23.55H133A34.6,34.6,0,0,0,165.77,154.77ZM309.53,62.9H22v46.32H309.53Z"/></svg>
                                {{ __('Archive') }}
                                <input type="hidden" class="activity-section-name" value="archived-threads">
                            </div>
                            @endif
                            @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id == $user->id)
                            <div class="inline-button-style align-center activity-section-switcher">
                                <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M48,48A48,48,0,1,0,96,96,48,48,0,0,0,48,48Zm0,160a48,48,0,1,0,48,48A48,48,0,0,0,48,208Zm0,160a48,48,0,1,0,48,48A48,48,0,0,0,48,368Zm448,16H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V400A16,16,0,0,0,496,384Zm0-320H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V80A16,16,0,0,0,496,64Zm0,160H176a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H496a16,16,0,0,0,16-16V240A16,16,0,0,0,496,224Z"/></svg>
                                {{ __('Activity log') }}
                                <input type="hidden" class="activity-section-name" value="activity-log">
                            </div>
                            @endif
                            @if(!(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id == $user->id))
                            <div class="move-to-right flex align-center relative">
                                <!-- this button will be displayed only to other users and not to the activities profile owner -->
                                <svg class="size17 pointer button-with-suboptions" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                                <div class="suboptions-container simple-information-suboptions-container" style="width: 480px">
                                    <!-- container closer -->
                                    <div class="closer-style fill-opacity-style hide-parent">
                                        <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>
                                    </div>
                                    <div class="flex mb8">
                                        <svg class="size4 mr8" style="margin-top: 6px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
                                        <p class="no-margin fs13">{{ __('Private threads will not be displayed in any section') }}.</p>
                                    </div>
                                    <div class="flex">
                                        <svg class="size4 mr8" style="margin-top: 6px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
                                        <p class="no-margin fs13">{{ __('If you are not either authenticated or follower of this person, threads that are marked as followers only visibility will no be displayed as well') }}.</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div id="activities-sections-content" class="relative">
                        <div id="activities-sections-loading-container" class="none full-center">
                            <div class="flex flex-column align-center">
                                <div class="spinner size24">
                                    <svg class="size24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path fill="#2ca0ff" d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                                </div>
                                <p class="bold">{{ __('Please wait') }}</p>
                            </div>
                        </div>
                        <x-activities.sections.threads :user="$user"/>
                    </div>
                </div>
            </div>
            <div>
                @include('partials.user-space.user-card', ['withcover'=>true])
                @include('partials.ads.w300h250')
            </div>
        </div>
    </div>
@endsection