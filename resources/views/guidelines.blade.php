@extends('layouts.app')

@section('title', 'Guidelines')

@push('styles')
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
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
    @include('partials.left-panel', ['page' => 'guidelines'])
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
            margin: 20px 0 14px 0;
        }
        #contact-us-form-wrapper {
            width: 70%;
            min-width: 320px;
        }
        #middle-padding {
            padding: 26px 46px;
        }

        em:first-letter {
            margin-left: 10px;
        }
        .text {
            font-size: 15px;
            line-height: 1.5;
            margin: 0;
        }
        .bordered-guideline {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            background-color: #fbfbfb;
        }
        .table-left-grid {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
        }
        p {
            font-size: 15px;
        }
        #left-panel {
            width: 250px;
        }
    </style>
    <div class="flex align-center middle-padding-1">
        <a href="/" class="link-path flex align-center unselectable">
            <svg class="mr4" style="width: 13px; height: 13px" fill="#2ca0ff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M503.4,228.88,273.68,19.57a26.12,26.12,0,0,0-35.36,0L8.6,228.89a26.26,26.26,0,0,0,17.68,45.66H63V484.27A15.06,15.06,0,0,0,78,499.33H203.94A15.06,15.06,0,0,0,219,484.27V356.93h74V484.27a15.06,15.06,0,0,0,15.06,15.06H434a15.05,15.05,0,0,0,15-15.06V274.55h36.7a26.26,26.26,0,0,0,17.68-45.67ZM445.09,42.73H344L460.15,148.37V57.79A15.06,15.06,0,0,0,445.09,42.73Z"/></svg>
            {{ __('Board index') }}
        </a>
        <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
        <span class="current-link-path unselectable">{{ __('Guidelines') }}</span>
    </div>
    <div id="middle-padding">
        <div>
            @if(Session::has('message'))
                <div class="green-message-container full-width border-box flex align-center" style="margin-top: 16px">
                    <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:rgb(67, 172, 67)"/></svg>
                    <p class="green-message">{{ Session::get('message') }}</p>
                </div>
            @endif
            <div class="full-center move-to-middle">
                <svg class="size24 mr8 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M65.4,453.77h85.53V512l55-24.76L261,512V453.77H446.6V0H65.4ZM231,465.61l-25-11.27-25,11.27V423.74H231ZM155.44,30H416.6V333.7H155.44Zm-60,0h30.05V333.7h-30Zm0,333.7H416.6v60.07H261v-30H150.93v30H95.4ZM301,231.9V161.85H241v30h30V231.9H241v30h90.07v-30ZM271,101.8h30v30H271Z"/></svg>
                <h1 id="cu-heading">FORUM GUIDELINES</h1>
            </div>
            <em class="fs15 flex text-center move-to-middle" style="width: 80%">{{ __("Champions aren't made in the gyms. Champions are made from something they have deep inside them -- a desire, a dream, a vision") }} ~ Muhammad Ali</em>
            <div class="flex align-center">
                <h2 class="no-margin my8">WELCOME TO</h2>
                <svg class="size34 ml4" xmlns="http://www.w3.org/2000/svg" viewBox="8 70 200 200">
                    <path d="M85.06,253.65c-.24,5.24,1,11.86-8.2,8.64-.13-.05-.44,0-.45.12-1.32,8.28-11.69,8.1-14.23,15.22-.23.62-.36,1.27-.53,1.9l1,.27a12.88,12.88,0,0,0,.24-1.93c-.17-5.68-3.27-10.78-1.4-17.06A151.8,151.8,0,0,0,67.7,230c.43-5.16,3-8.17,5.22-11.88.28-.35.57-.7.85-1.06l-.7,1.21-4-.61c.37-1.28.33-3.06,1.18-3.77,7.23-6,2.74-10.39-1.62-15.23-12.64-14-31.74-17.26-46.29-28a126.26,126.26,0,0,1-10.79-9.07c-1.13-1-2.4-3-2.17-4.25.41-2.21,2.75-.78,4.22-1,20.42-3.58,41.33-4,61.44-9.67,2.19-.62,4.73.16,7-.17,1.33-.19,4.79-.18,3.51-2-4.37-6.19,1-11,2.4-15.7,1.09-3.68.59-10.47,7.4-11.24.71-.08,1.87-.94,1.86-1.43,0-.79-.83-2.28-1.26-2.26-6.35.25-4.74-3.76-4.28-7.44.84-6.57-1.4-15.67,3.73-19,8.87-5.85,3.48-10.26,1.37-15.68-.27-.7.94-2,1.46-3,1.43,1.41,4.28,3.12,4.06,4.18-1.14,5.41,8,9.68,1.41,15.69-1.75,1.6.94,1.84,2.16,1.83,2.81,0,4.65.93,4.56,4.09-3-2.23-6.12-3.7-9.68-1.27-.56.38-1.19,1.76-1,2,3,3.18,6.59.21,9.88.89.13,0,.49-1.09.74-1.67-1.48,7.26,9.7,8.34,7.76,15.54-1.13,4.22,2.53,3,3.94,4.37,5.21,4.92,1.48,13.06,6.65,18.18,1.29,1.27.92,4.21,1.32,6.38,5.18-4.64,8.89,10.61,14.79,1.1.64-1,5.61-1.07,6.51.07,4.1,5.17,8,2.22,11.94.45,8.18-3.67,16.38-5.51,25.4-3,6,1.67,10.32-4.53,16.42-4.69,2.26-.06,3.57,1,5.35,1.26-3.82,1.24,1.84,6.34-3.51,7.63-9.21,2.24-14,8.7-16.9,17.9-.86,2.77-8.06,3.54-12.33,5.29a36.17,36.17,0,0,0-3.51,1.9c.9.39,2.06.58,2.64,1.25s.75,1.94,1.09,2.94c-6.66,0-5.48,8.82-11.81,10.14-5.31,1.11-9.8,7.68-9.11,11.43a41.06,41.06,0,0,0,6,15.42c6.52,9.7,11.29,20.57,16.79,31l10.83,25c3,1.13,1.39,2.75.67,4.54-1.36,3.35-3.19,1.09-4.46.32-8.61-5.19-16.58-13.34-25.79-15.09-9.68-1.83-9.67-15.83-21.43-13.37-3,.61-5.61-6.45-8.64-9.54-4.6-4.7-11.25-2.94-16.07-.12-5,2.93-8.41,8.43-13.24,11.75-5.57,3.83-8.62,11.51-16.84,11.4-1.48-.8-3-1.63-4.46-.17-.34.33,0,1.34,0,2Zm7-61c.12,6.64,5.94,5.41,9.4,7.6,14.3,9,16.5,9,29.1-4.13,1.69-1.76,3.14-1.44,4.81,0,.9.79,1.44,2.85,3.23,1.39.07,0-1.22-1.63-1.73-2.58-.82-1.52.37-3,.42-4.16.22-5.31.69-11.23-1.38-15.83-1.91-4.25-3.71-10.91-8.54-12.05-38.55-9-28.39-9.45-15.31-4.47,4,1.5-6.33,4-10.77,2.28-1.48-.58-4.86-2.6-6.06,1.35-1.54,5.06-6,12.19-4.14,14.74,4.83,6.62-1.52,9.49-2.37,14-.11.59-2.52-1.12-2.81,1.1,3.5.44,1.31,5.55,4.48,5.76,2,.13,1-2.16,1.23-3.39C91.79,193.77,92,193.24,92.11,192.7ZM79.85,235.44c3.24,6.51,10.16-4.3,13.3,2.15.56,1.14,1.33-.49,1.51-1.29a2,2,0,0,0-.3-1.37c-3.17-5.08,1.83-6.73,4.11-6.34,6.23,1.07,1.27-6.23,5.52-6.45,1.12-.06.69-2.35-.35-3.59-4.92-5.86-19.81-6.7-24.82-1.33a1.65,1.65,0,0,0-.31,1.14c.72.43,1.54,1.08,2.27,1,1.68-.17,4-3.6,4.7.33.36,2.05-.6,4.81-4.85,4.22-2-.28-3.52,3.71-1.84,6.64C79.53,231.84,81.86,232.45,79.85,235.44ZM97.93,136c-2.39,7.87,8.78,7.27,7.14,14.05,2-5.29,5.2-7.89,10.91-4.82-1.28-5.77,6.23-11.41,1.26-16.65-3.44-3.64-8.34-5.85-10.52-10.94-.33-.77-2.73-2.56-4,1.33C100.74,124.88,94.09,129.33,97.93,136Zm54,78.86,1.41-.84c-2.94-3.24-5.48-7-8.92-9.57-3.72-2.79-3.12,2.54-4.94,3.56-3.19,1.77-6.44,3.43-9.66,5.13,5.62.57,2.59,9.49,9.56,9.48,4.55,0,9,1.68,10.49,7.55.36,1.46,3.5,4.85,6.43,3.56,4-1.73.32-4.57-.12-6.62C155.29,222.89,153.42,218.91,152,214.84ZM78.8,172.16c-.46-5.59.9-14.6-11.17-7.64-1.76,1-4.54.06-6.68.64-3.29.9-5.93,2.86-6.57,6.57-.84,4.87,3.31,2.56,5.17,3.52,3,1.54,6.58,2.36,8.82,4.59,2.54,2.52,4.61,3,7.62,1.66C79.81,179.82,78.58,176.5,78.8,172.16Zm70.78,1.54c4.33-.07,14-7.26,18-12.64,3.07-4.12,1.76-4.69-2.52-6.41-7.37-3-13.29,1-18.68,3.7-2.67,1.33-6.09,1-8.25,3.35,4.16,2.7,12,3.05,7.26,11.43Zm23.2-28c1.53-1.32,3.35-2.45,4.53-4,.95-1.29-.65-1.22-1.41-1.21-2,0-4.58-.71-4.68,2.5C171.19,143.91,172.31,144.92,172.78,145.7Zm-9,81.69c.55-1.18,1.29-2.16,1.08-2.45a13.48,13.48,0,0,0-2.51-2.23c-.46.58-1.42,1.46-1.29,1.68A20.71,20.71,0,0,0,163.8,227.39Zm-12.23-76.48a20.43,20.43,0,0,0-4.06-.37c-.75.1-2.93-.66-1.73,1.46.43.76,2,1.19,3,1.18C149.48,153.17,150.15,152.12,151.57,150.91ZM81.84,207.15c-2-1.06-2.65-1.71-3.34-1.71s-1.18.74-1.77,1.16c.5.45.94,1.16,1.5,1.27S79.68,207.62,81.84,207.15Zm70.54-24.25-.45-1.59a10.24,10.24,0,0,0-1.52,1.05c-.15.15,0,.62,0,.95Zm-20.93-22.35a13.06,13.06,0,0,0,2.17,1.92c.21.12,1.31-.79,1.26-.9a6.26,6.26,0,0,0-1.39-2.1C133.34,159.34,132.48,160,131.45,160.55ZM77.92,210.13l3.2,2c.16-.42.56-1.1.44-1.2a6.53,6.53,0,0,0-2-1.29C79.14,209.53,78.57,209.92,77.92,210.13Zm47.59-54.95,1.79-1.34a5,5,0,0,0-1.74-.65,5.39,5.39,0,0,0-1.77.75ZM59,159.37l-1.41.44a5.49,5.49,0,0,0,1,1.54c.21.16.86-.26,1.31-.41Zm47,52.69c-.76.87-1.34,1.28-1.5,1.81-.09.31.48.82.75,1.24a6.48,6.48,0,0,0,1.29-1.39C106.64,213.45,106.26,212.91,106,212.06ZM37.87,161.45c-.35-.28-.72-.71-.84-.65a3.82,3.82,0,0,0-1.29,1c-.09.11.35.62.55.95ZM65.39,265.69c-.42.71-.88,1.16-.79,1.39a7,7,0,0,0,1.07,1.46c.36-.36,1.08-.86,1-1A9.26,9.26,0,0,0,65.39,265.69Zm22-66.34-.41-1.92c-.23.2-.66.4-.66.59a13.48,13.48,0,0,0,.28,2Zm21.3-50.43c-.31.34-.9.72-.85,1,.1.45.57.82.89,1.23.25-.4.65-.78.69-1.2S108.93,149.28,108.65,148.92Zm-22,55.21-1,1.78c.42.12,1.06.47,1.22.32a8.55,8.55,0,0,0,1.12-1.67Zm57.27-61.4a11.65,11.65,0,0,0-.43,2.37c0,.35.48,1,.69,1a6.49,6.49,0,0,0,1.67-.61Zm11,53.19c-.34-.23-.71-.67-1-.64s-.74.47-1.11.74c.37.17.74.49,1.11.49S154.61,196.15,155,195.92ZM78,215.17c.15-.14.4-.26.42-.41s-.21-.33-.32-.49c-.15.13-.41.26-.42.41S77.9,215,78,215.17Zm-1.6,3.44-.24.41.91,0c-.07-.14-.11-.34-.22-.41S76.57,218.62,76.42,218.61Zm30.22-105.33-.28.47,1,.06c-.08-.17-.12-.39-.25-.49S106.81,113.28,106.64,113.28ZM52,169.63l-.25.42.93,0c-.07-.15-.11-.35-.22-.43S52.12,169.65,52,169.63Z" style="fill:#39773b"></path>
                </svg>
                <h2><span style="color: #d02424;">MOROCCAN GLADIATOR</span> FORUM</h2>
            </div>
            <h3 class="no-margin fs17 mb4">INTRODUCTION</h3>
            <p class="text bordered-guideline">
                {{ __("Moroccan gladiator forum is intended to be a place where athletes can engage with each 
                other on a peaceful, friendly basis. The rules which govern this forum have been implemented to protect 
                both the forum and its users. Please make yourself familiar with these rules. Members of the gladiator's 
                Team and Moderators are in the forums on a regular basis, and we will enforce these rules whenever necessary.") }}
            </p>
            <h3 class="no-margin fs17 mb4" style='margin-top: 12px'>I. {{ __('Forum Rules & Guidelines') }}</h3>
            <div style='margin-left: 16px'>
                <p><b>1.</b> {{ __('Respect comes in two unchangeable steps: giving it and receiving it') }}.</p>
                <p><b>2.</b> {{ __('Make sure to be always a useful member..and judge yourself first before people judge you..so make your pen always write about the good things') }}.</p>
                <p><b>3.</b> {{ __("The Forum is dedicated to discussing all topics, discussions and questions related to sports, and any irrelevant topic will be deleted and could lead the topic's user account to be banned") }}.</p>
                <p><b>4.</b> {{ __("Each member must abide by virtuous morals and overcome the barrier of racism in every sporting sector(and they have the right to encourage their teams or favorite players in a manner consistent with the spirit of sport and under the roof of sporting ethics)") }}.</p>
                <p><b>5. {{ __("It is forbidden to write any topic that contradicts the Islamic religion or contradicts religious doctrines") }}</b>.</p>
                <p><b>6.</b> {{ __("The moderators have the right to delete, edit or move any topic or reply that is in violation of the laws and conditions") }}.</p>
                <p><b>7.</b> {{ __("Do not put unorganized and unformatted topics (so that the reader is attracted to read the topic) as copy and paste topics do not have any meaning just to increase views and replies") }}.</p>
                <p><b>8.</b> {{ __("No links to other sports forums") }}.</p>
                <p><b>9.</b> {{ __("Criticism is welcome, but without prejudice or intolerance") }}.</p>
                <p><b>10.</b> {{ __("The member must choose an appropriate title that corresponds to the content of its topic, and the forum administration, monitors and moderators of the forum have the right to change it if necessary(maybe soon, we're going to add a feature where the user could suggest edits)") }}.</p>
                <p><b>11.</b> {{ __("It must be taken into account that the sports forum is attended by visitors of different ages, so we must preserve our writing style so that the topics do not contain bad words that affect modesty") }}.</p>
                <p><b>11.</b> {{ __("We would prefer if we adhere to these rules and stay away from everything that contradicts that, so that we show the beautiful image of our arena, as the forum is for all of us") }}.</p>
                <div class="simple-line-separator my8"></div>
                <div>
                    <p class="my8">{{ __("We confirm what has been mentioned and we wish all the pioneers of the sports section to comply. And always remember") }}:</p>
                    <ul>
                        <li class="my8">{{ __("Your participation is a reflection of your personality") }}.</li>
                        <li class="my8">{{ __("Accepting the other opinion is proof that you are a professional athlete in the truest sense of the word") }}.</li>
                        <li class="my8">{{ __("Your opinion is as valid and wrong as others") }}.</li>
                        <li class="my8">{{ __("These laws were established only to preserve the good relationship of members with each other and to raise the level of our community and It is subject to change and modification if necessary") }}.</li>
                        <li class="my8">{{ __("(Our goal is to promote thought and advancement in the forum, and we hope everyone cooperates with us)") }}.</li>
                        <li class="my8">{{ __("And when there is any suggestion or problem, please go to the contact & feedback section, and you will only find what pleases you Insha'Allah") }}.</li>
                    </ul>
                </div>
            </div>
            <h3 class="no-margin fs17 mb4" style='margin: 12px 0'>II. {{ __('Items that May Result in Immediate Ban') }}</h3>
            <div style="margin-left: 16px">
                <div class="simple-line-separator my8"></div>
                <div class="flex">
                    <p class="no-margin bold text mr8 table-left-grid">{{__('SPAM')}}</p>
                    <p class="no-margin text">{{ __("Spamming or flooding the forums, in which a user posts the same message repeatedly, is prohibited and you will be banned") }}.</p>
                </div>
                <div class="simple-line-separator my8"></div>
                <div class="flex">
                    <p class="no-margin bold text mr8 table-left-grid" >{{ __("Touts / Advertising / Commerce") }}</p>
                    <p class="no-margin text">{{ __("Our forum will not be used as a place to do your personal business. Phone numbers, home addresses, email addresses that are found in any forum other than Website Promotions, will be deleted. Touts involving twitter or Facebook redirects will also result in the user being banned.
                        If you are promoting a service in any forum (including that of a ‘bookie’) other than Website Promotions, your account may be suspended or banned at the discretion of our Moderators and Support team") }}.</p>
                </div>
                <div class="simple-line-separator my8"></div>
                <div class="flex">
                    <p class="no-margin bold text mr8 table-left-grid" >{{ __("Racism, sexism, and other discrimination") }}</p>
                    <p class="no-margin text">{{ __("The use of inappropriate or offensive language is not permitted at Gladiator forum. Inappropriate or offensive language includes, but is not limited to, any language or content that is sexually oriented, sexually suggestive or abusive, harassing, defamatory, vulgar, obscene, profane, hateful, or that contains racially, ethnically or otherwise objectionable material of any kind") }}.</p>
                </div>
                <div class="simple-line-separator my8"></div>
                <div class="flex">
                    <p class="no-margin bold text mr8 table-left-grid" >{{ __("Links to External Sites") }}</p>
                    <p class="no-margin text">{{ __("Links to informational sites or informative articles such as those found on sports websites that include useful informations are permitted but links to personal sites (Facebook), personal spaces, websites, pick services, and sites solely designed for advertising/commerce are not permitted. If you are unsure if your link is permitted, check with a Support or a moderator first") }}.</p>
                </div>
                <div class="simple-line-separator my8"></div>
            </div>
            <h3 class="no-margin fs17 mb4" style='margin-top: 12px'>III. {{ __('Other Rules') }}</h3>
            <div style="margin-left: 16px">
                <p class="no-margin text my8"><b>1. {{ __("Images") }}</b>: {{ __("Any avatars, covers, images, or URLs containing nudity, pornography, or sexually explicit attire (e.g., bikinis/lingerie) are NOT permitted in the forum and will be removed (may lead the user's account to be banned). This includes, but is not limited to") }}:</p>
                <div class="ml8">                                    
                    <p class="text no-margin">1-1. {{ __("Strategically covered nudity") }}</p>
                    <p class="text no-margin">1-2. {{ __("Sheer or see-through clothing") }}</p>
                    <p class="text no-margin">1-3. {{ __("Lewd or provocative poses") }}</p>
                    <p class="text no-margin">1-4. {{ __("Close-ups of breasts, buttocks or crotches") }}</p>
                </div>
                <p class="text no-margin">{{ __("All avatars will be reviewed by the Gladiator team – if they are deemed inappropriate, they will be removed. If users continue to upload avatars that violate these guidelines, the user will be banned") }}.</p>
                <p class="text my8"><b>2.</b> {{ __("Slanderous posts are not allowed. If a post is deemed slanderous, the thread may be deleted or moved to the penalty box and the poster may be boxed or even banned") }}.</p>
                <p class="text my8"><b>3.</b> {{ __("Any obvious site promotions will be assumed to be meant for the promotions area, and will be moved there if not deleted. Any other off-topic threads will be relocated to the appropriate forum and/or deleted accordingly") }}.</p>
                <p class="text my8"><b>4.</b> {{ __("Intentionally repetitive topics posted by the same user may be locked, deleted, or consolidated") }}.</p>
                <p class="text my8"><b>5.</b> {{ __("Any threads in the forum which deteriorate to arguments between two or more users will be moved to the penalty box, or deleted at the discretion of our Moderators") }}.</p>
                <p class="text my8"><b>6.</b> {{ __("If you have nothing positive to offer our forum and are only posting insults, attacks, and/or emoticons, you will be warned, suspended, and/or banned from the forum. Users who are suspended may continue to post in the Penalty Box for a period of time until the Moderators decide to either ban the user or release them from the box") }}.</p>
            </div>
            <h3 class="no-margin fs17 mb4" style='margin-top: 12px'>IV. {{ __('General Guidelines of Behavior') }}</h3>
            <div style="margin-left: 16px">
                <p class="text my8">{{ __("Gladiator’ forum is only enjoyable for our users as long as everyone plays fair. Therefore, we have come up with a few basic guidelines that we expect all of our users to agree to and respect. We are counting on our forum members to do a lot of self-policing to ensure that guidelines are being followed. Respecting these guidelines will keep the forum vibrant, entertaining, and enjoyable") }}!</p>
                <p class="text my8">{{ __("If you notice a member behaving in a way that is a direct violation of the rules and spirit of the forum, please let us know via the contact and feedback page. If this member’s attitude is not violating the rules but is ruining your experience in the forum, please consider ignoring them as opposed to engaging in an online battle") }}.</p>
                <p class="text my8">{{ __("With regards to slanderous posts/comments: as mentioned above, we will be notifying users if we deem a post to be unsubstantiated and slanderous. Once a post has been deemed slanderous, it will either be deleted or moved to the Penalty Box forum") }}.</p>
                <p class="text my8">{{ __("Try to be civil! We know that this can be difficult if someone is being rude and disruptive. However, we also know that nobody wants to read a page full of arguments, either. Please try to maintain a sense of dignity. Refusing to engage in rude or disruptive behavior also shows a lot of class") }}.</p>
                <p class="text my8">{{ __("If you have a good idea about ways to improve the forum, let us know in the contact page! We participated in the creation of this site, and we plan to add new features from time to time so feedback from our users is definitely welcome") }}.</p>
            </div>
            <h3 class="no-margin fs20 mb4" style='margin-top: 12px'>{{ __('The Legal Stuff') }}</h3>
            <p class="text bordered-guideline" style="background-color: #f5fff5">
                {{ __("``All of the information contained inside this forum represents the personal thoughts and opinions of the individual members. Submissions to this forum are not reflective of the thoughts and opinions of moroccan-gladiator.com, nor its employees. moroccan-gladiator.com and its employees do not endorse or represent any of the opinions within the forum, and shall not be held responsible in any legal action resulting from any of the content contained within the forum. Furthermore, moroccan-gladiator.com shall not be responsible for keeping a permanent record of the opinions expressed within the forum, and we may delete or edit submissions to the forum at our discretion if deemed necessary``") }}.
            </p>
            <div class="full-center" style="margin-top: 20px">
                <em class="text flex text-center" style="width: 60%">
                    {{ __("In conclusion, we would like to point out to all members that all of this was only set for the service of our sports department.
    We hope that you will abide by these laws and take them seriously and understand them as we promised you ") }}.
                    </em>
            </div>
        </div>
    </div>
@endsection