<div class="index-right-panel mt8">
    <div class="flex align-center mx8">
        <div class="small-image-3 sprite sprite-2-size rating22-icon mr4"></div>
        <p class="bold my8">{{ __('Feedback') }}</p>
    </div>
    @canemoji
    <div class="full-center">
        <a href="" class="mx4 emoji-button">
            <img src="{{ asset('assets/images/icons/emoji-sad.svg') }}" class="mx4 size36 emoji-unfilled" alt="">
            <img src="{{ asset('assets/images/icons/emoji-sad-filled.png') }}" class="mx4 size36 none emoji-filled" alt="">
            <input type="hidden" class="feedback-emoji-state" value="sad">
        </a>
        <a href="" class="mx4 emoji-button">
            <img src="{{ asset('assets/images/icons/emoji-thinking.svg') }}" class="mx4 size36 emoji-unfilled" alt="">
            <img src="{{ asset('assets/images/icons/emoji-thinking-filled.png') }}" class="mx4 size36 none emoji-filled" alt="">
            <input type="hidden" class="feedback-emoji-state" value="sceptic">
        </a>
        <a href="" class="mx4 emoji-button">
            <img src="{{ asset('assets/images/icons/emoji-sceptic.svg') }}" class="mx4 size36 emoji-unfilled" alt="">
            <img src="{{ asset('assets/images/icons/emoji-sceptic-filled.png') }}" class="mx4 size36 none emoji-filled" alt="">
            <input type="hidden" class="feedback-emoji-state" value="so-so">
        </a>
        <a href="" class="mx4 emoji-button">
            <img src="{{ asset('assets/images/icons/emoji-happy.svg') }}" class="mx4 size36 emoji-unfilled" alt="">
            <img src="{{ asset('assets/images/icons/emoji-happy-filled.png') }}" class="mx4 size36 none emoji-filled" alt="">
            <input type="hidden" class="feedback-emoji-state" value="happy">
        </a>
        <a href="" class="mx4 emoji-button">
            <img src="{{ asset('assets/images/icons/emoji-veryhappy.svg') }}" class="mx4 size36 emoji-unfilled" alt="">
            <img src="{{ asset('assets/images/icons/emoji-veryhappy-filled.png') }}" class="mx4 size36 none emoji-filled" alt="">
            <input type="hidden" class="feedback-emoji-state" value="veryhappy">
        </a>
    </div>
    @else
        @php
            $feedback_state = \App\Models\EmojiFeedback::where('ip', request()->ip())->orderBy('created_at', 'desc')->first()->emoji_feedback;
        @endphp
    <div class="full-center">
        <a href="" class="mx4 block-click">
            @if($feedback_state == 'sad')
                <img src="{{ asset('assets/images/icons/emoji-sad-filled.png') }}" class="mx4 size36 emoji-filled" alt="">
            @else
                <img src="{{ asset('assets/images/icons/emoji-sad.svg') }}" class="mx4 size36 emoji-unfilled" style="opacity: 0.5" alt="">
            @endif
        </a>
        <a href="" class="mx4 block-click">
            @if($feedback_state == 'sceptic')
                <img src="{{ asset('assets/images/icons/emoji-thinking-filled.png') }}" class="mx4 size36 emoji-filled" alt="">
            @else
                <img src="{{ asset('assets/images/icons/emoji-thinking.svg') }}" class="mx4 size36 emoji-unfilled" style="opacity: 0.5" alt="">
            @endif
        </a>
        <a href="" class="mx4 block-click">
            @if($feedback_state == 'so-so')
                <img src="{{ asset('assets/images/icons/emoji-sceptic-filled.png') }}" class="mx4 size36 emoji-filled" alt="">
            @else
                <img src="{{ asset('assets/images/icons/emoji-sceptic.svg') }}" class="mx4 size36 emoji-unfilled" style="opacity: 0.5" alt="">
            @endif
        </a>
        <a href="" class="mx4 block-click">
            @if($feedback_state == 'happy')
                <img src="{{ asset('assets/images/icons/emoji-happy-filled.png') }}" class="mx4 size36 emoji-filled" alt="">
            @else
                <img src="{{ asset('assets/images/icons/emoji-happy.svg') }}" class="mx4 size36 emoji-unfilled" style="opacity: 0.5" alt="">
            @endif
        </a>
        <a href="" class="mx4 block-click">
            @if($feedback_state == 'veryhappy')
                <img src="{{ asset('assets/images/icons/emoji-veryhappy-filled.png') }}" class="mx4 size36 emoji-filled" alt="">
            @else
                <img src="{{ asset('assets/images/icons/emoji-veryhappy.svg') }}" class="mx4 size36 emoji-unfilled" style="opacity: 0.5" alt="">
            @endif
        </a>
    </div>
    @endcanemoji
    <p class="fs12 my8">We are here to anwser any questions you may have about us or any feedback you have about the website. Reach out to us using below form, and we'll respond as soon as we can.</p>
    <div class="feedback-container">
        <div class="feedback-sent-success-container green-message-container none">
            <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="small-image move-to-middle" alt="">
            <p class="fs13 no-margin text-center green-message">{{ __('Your feedback is sent successfully.') }}</p>
        </div>
        <div class="feedback-sec">
            <p class="no-margin my4 none error"></p>
            @guest
            <div class="input-container">
                <label for="subject" class="label-style-1 fs13">{{ __('Email') }} </label>
                <input type="email" id="email" name="email" class="full-width border-box input-style-2" value="{{ @old('email') }}" required placeholder="Your email">
            </div>
            @endguest
            <div class="input-container">
                <label for="feedback" class="label-style-1 fs13">{{ __('Your feedback') }}</label>
                <textarea name="feedback" id="feedback" class="feedback-textarea" placeholder="{{ __('What do you think about this website ..') }}"></textarea>
            </div>
            <div class="flex">
                <input type="button" value="send" class="move-to-right button-style-1 send-feedback">
            </div>
        </div>
    </div>
</div>