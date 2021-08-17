@extends('layouts.app')

@section('title', 'Contact')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/contactus.js') }}" defer></script>
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'contactus'])
    <style>
        .contactus-text {
            font-size: 13px;
            min-width: 300px;
            line-height: 1.7;
            letter-spacing: 1.4px;
            margin: 0 0 16px 0;
            color: #1e2027;
        }
        #cu-heading {
            color: #1e2027;
            letter-spacing: 5px;
            margin: 10px 0;
        }
        #contact-us-form-wrapper {
            width: 70%;
            min-width: 320px;
        }
        #middle-padding {
            padding: 0 46px 26px 46px;
        }
    </style>
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('Contact & Feedback') }}</span>
    </div>
    <div id="middle-padding">
        <div>
            @if(Session::has('message'))
                <div class="green-message-container full-width border-box flex align-center" style="margin-top: 16px">
                    <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:rgb(67, 172, 67)"/></svg>
                    <p class="green-message">{{ Session::get('message') }}</p>
                </div>
            @endif
            <div class="flex align-center">
                <svg class="size28 mr8 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128,132,57.22,238.11,256,470,454.78,238.11,384,132Zm83,90H104l35.65-53.49Zm-30-60H331l-75,56.25Zm60,90V406.43L108.61,252Zm30,0H403.39L271,406.43Zm30-30,71.32-53.49L408,222ZM482,72V42H452V72H422v30h30v30h30V102h30V72ZM60,372H30v30H0v30H30v30H60V432H90V402H60ZM0,282H30v30H0Zm482-90h30v30H482Z"/></svg>
                <h1 id="cu-heading">Contact & Feedback</h1>
            </div>
            <p class="contactus-text">{{ __("If you have any questions or queries, a member of staff will always be happy to help. Feel free to contact us using the form below, or by our telephone or email in the right panel and we will be sure to get back to you as soon as possible") }}.</p>
            <p class="contactus-text">{{ __("Be clear, thoughtful, and respectful. Make sure the feedback you offer is accurate, specific, and is limited only to the behavior in question, suggestion or advice") }}.</p>
            <div class="simple-line-separator my8"></div>
            @if($rate_limit_reached)
            <div class="flex align-center">
                <svg class="size17 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M404.57,112.64V101.82c0-43.62-40.52-76.69-83-65.55-25.63-49.5-94.09-47.45-118,.75-41.28-10.56-82.41,20.92-82.41,65V228.13A65.45,65.45,0,0,0,59.06,237a67.45,67.45,0,0,0-14.55,93.15l120,168.42A32,32,0,0,0,190.54,512h222.9a32,32,0,0,0,31.18-24.81l30.18-131a203.49,203.49,0,0,0,5.2-45.67V179C480,138.38,444.48,107,404.57,112.64ZM432,310.56a155.71,155.71,0,0,1-4,34.89L400.71,464H198.79L83.59,302.3c-14.44-20.27,15-42.77,29.4-22.6l27.12,38.08c9,12.62,29,6.28,29-9.29V102c0-25.65,36.57-24.81,36.57.69V256a16,16,0,0,0,16,16h6.86a16,16,0,0,0,16-16V67c0-25.66,36.57-24.81,36.57.69V256a16,16,0,0,0,16,16H304a16,16,0,0,0,16-16V101.13c0-25.68,36.57-24.81,36.57.69V256a16,16,0,0,0,16,16h6.85a16,16,0,0,0,16-16V179.69c0-26.24,36.57-25.64,36.57-.69V310.56Z"/>
                </svg>
                <p class="contactus-text" style="margin-bottom: 0">{{ __("You have reached messages limit of 2 messages/day, try again later") }}</p>
            </div>
            <p class="contactus-text">{{ __("We have received all your messages, and we will get back to you as soon as possible") }}</p>
            @else
            <div id="contact-us-form-wrapper">
                <div class="full-width flex align-center">
                    <div class="mr8 half-width">
                        <label for="firstname" class="flex align-center bold forum-color mb2">{{ __('Firstname') }}<span class="error none fs12" style="font-weight: 400; margin: 0">* {{ __('Firstname is required') }}</span></label>
                        <input type="text" id="firstname" class="styled-input" maxlength="60" autocomplete="off" placeholder='{{ __("Your firstname") }}' value="@auth {{ auth()->user()->firstname }} @endauth" @auth disabled @endauth>
                    </div>
                    <div class="half-width">
                        <label for="lastname" class="flex align-center bold forum-color mb2">{{ __('Lastname') }}<span class="error none fs12" style="font-weight: 400; margin: 0">* {{ __('Lastname is required') }}</span></label>
                        <input type="text" id="lastname" class="styled-input" maxlength="60" autocomplete="off" placeholder='{{ __("Your lastname") }}' value="@auth {{ auth()->user()->lastname }} @endauth" @auth disabled @endauth>
                    </div>
                </div>
                <div style="margin: 12px 0">
                    <input type="hidden" class="invalide-email" value="{{ __('Invalide email address') }}">
                    <input type="hidden" class="email-required" value="{{ __('Email is required') }}">
                    <label for="contact-email" class="flex align-center bold forum-color mb2">{{ __('Email') }}<span class="error none fs12" style="font-weight: 400; margin: 0"></span></label>
                    <input type="text" id="contact-email" class="styled-input" maxlength="400" autocomplete="off" placeholder='{{ __("Your email") }}' value="@auth {{ auth()->user()->email }} @endauth" @auth disabled @endauth>
                </div>
                <div class="flex">
                    <div class="half-width mr8" style="margin-bottom: 12px">
                        <label for="company" class="flex align-center align-center bold forum-color mb2">{{ __('Company') }} <span style="font-weight: 400; margin-left: 2px; font-size: 12px">({{__('optional')}})</span><span class="error none fs12" style="font-weight: 400; margin: 0">* __('Invalid company name')</span></label>
                        <input type="text" id="company" class="styled-input" maxlength="200" autocomplete="off" placeholder='{{ __("Company") }}'>
                    </div>
                    <div class="half-width" style="margin-bottom: 12px">
                        <label for="phone" class="flex align-center align-center bold forum-color mb2">{{ __('Phone') }} <span style="font-weight: 400; margin-left: 2px; font-size: 12px">({{__('optional')}})</span><span class="error none fs12" style="font-weight: 400; margin: 0">* __('Invalid phone number')</span></label>
                        <input type="text" id="phone" class="styled-input" maxlength="200" autocomplete="off" placeholder='{{ __("Your phone number") }}'>
                    </div>
                </div>
                <div>
                    <label for="message" class="flex align-center align-center bold forum-color mb2">{{ __('Message') }} <span class="error none fs12" style="font-weight: 400; margin: 0">* {{ __('Message is required') }}</span></label>
                    <p class="fs12 no-margin mb2 gray">{{ __('Be specific and imagine you’re talking with another person') }}</p>
                    <div class="countable-textarea-container">
                        <textarea id="message" class="no-margin block styled-textarea move-to-middle countable-textarea" autocomplete="off" min maxlength="2000" spellcheck="false" autocomplete="off" form="profile-edit-form" placeholder="{{ __('Your message') }}"></textarea>
                        <p class="block my4 mr4 unselectable fs12 gray textarea-counter-box move-to-right width-max-content"><span class="textarea-chars-counter">0</span>/2000</p>
                        <input type="hidden" class="max-textarea-characters" value="2000">
                    </div>
                </div>
                <div class="flex align-center">
                    <input type="hidden" class="btn-text-ing" value="{{ __('Submitting message') }}..">
                    <input type="hidden" class="btn-no-text-ing" value="{{ __('Submit message') }}">
                    <input type='button' class="contact-send-message inline-block button-style" value="{{ __('Submit message') }}">
                    <div class="spinner size17 ml4 opacity0">
                        <svg class="size17" xmlns="http://www.w3.org/2000/svg" fill="#000" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div id="right-panel">
        <div>
            <div class="right-panel-header-container">
                <div class="flex align-center">
                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M65.4,453.77h85.53V512l55-24.76L261,512V453.77H446.6V0H65.4ZM231,465.61l-25-11.27-25,11.27V423.74H231ZM155.44,30H416.6V333.7H155.44Zm-60,0h30.05V333.7h-30Zm0,333.7H416.6v60.07H261v-30H150.93v30H95.4ZM301,231.9V161.85H241v30h30V231.9H241v30h90.07v-30ZM271,101.8h30v30H271Z"/></svg>
                    <p class="bold no-margin unselectable my4">{{ __('Contact & Feedback guidelines') }}</p>
                </div>
            </div>
            <div class="mx8 py8">
                <p class="fs12 my8"><strong>1. {{ __('Include the topic for your contact in the first line of message section') }}</strong></p>
                <p class="fs12 my8 ml8"><strong>1.1</strong> {{ __('Including the topic of your message help our team to help you when you ask a question or ask for something') }}.</p>
                <p class="fs12 my8"><strong>2. {{ __('Use what is appropriate') }}</strong></p>
                <p class="fs12 my8 ml8"><strong>2.1</strong> {{ __('Be clear, thoughtful, and respectful. Make sure the feedback you offer is accurate, specific, and is limited only to the behavior in question or suggestion') }}.</p>
                <p class="fs12 my8 ml8"><strong>2.2</strong> {{ __('Deliver feedback in a timely manner. It is best to give feedback as close as possible to the occurrence of the behavior or issue that requires correction') }}.</p>
                <p class="fs12 my8"><strong>3. {{ __('How to Share Useful – and Respectful – Feedback') }}</strong></p>
                <p class="fs12 my8 ml8"><strong>3.1</strong> {{ __('Concentrate on the positive first before giving criticism. Feedback should start with positive observations about the contributions we are making before detailing areas that need improvement') }}.</p>
                <p class="fs12 my8 ml8"><strong>3.2</strong> {{ __('Be clear about what you want to say before you say it') }}.</p>
                <p class="fs12 my8 ml8"><strong>3.3</strong> {{ __('The information should be about your own perception of information, not about the other’s perceptions, assumptions and motives. Use ‘I’ statements as much as possible to indicate that your impressions are your own') }}.</p>

                <div class="flex">
                    <a href="{{ route('guidelines') }}" class="link-style fs12 move-to-right">Go to guidelines for all</a>
                </div>
            </div>
        </div>
    </div>
@endsection