<div class="poll-option-box flex align-center mb8">
    <input type="hidden" class="voted" autocomplete="off" value="{{ $int_voted }}">
    <div class="flex align-center pointer 
        @auth vote-option
            @if($multiple_choice) custom-checkbox-button @else custom-radio-button @endif 
        @endauth 
        @guest login-signin-button @endguest">
        <input type="hidden" class="optionid" autocomplete="off" value="{{ $option->id }}">
        @if($multiple_choice)
        <div class="custom-checkbox-background mr4">
            <div class="custom-checkbox @if($voted) custom-checkbox-checked @endif" style="width: 24px; height: 24px">
                <svg class="size14 custom-checkbox-tick @if(!$voted) none @endif" fill="#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M173.9,439.4,7.5,273a25.59,25.59,0,0,1,0-36.2l36.2-36.2a25.59,25.59,0,0,1,36.2,0L192,312.69,432.1,72.6a25.59,25.59,0,0,1,36.2,0l36.2,36.2a25.59,25.59,0,0,1,0,36.2L210.1,439.4a25.59,25.59,0,0,1-36.2,0Z"/></svg>
                <input type="hidden" class="checkbox-status" autocomplete="off" value="{{ $int_voted }}">
            </div>
        </div>
        @else
        <div class="custom-radio-background mr4">
            <div class="custom-radio @if($voted) custom-radio-checked @endif size18">
                <span class="radio-check-tick @if(!$voted) none @endif" style="width: 14px; height: 14px"></span>
                <input type="hidden" class="radio-status" autocomplete="off" value="{{ $int_voted }}">
            </div>
        </div>
        @endif
        <div class="poll-option-container full-width" style="@if($voted) background-color: #F0F2F5; @endif">
            <div>
                <span class="gray fs11 block unselectable">{{ __('Added by') }} {{ $addedby }}</span>
                <p class="no-margin mt4 fs16 unselectable">{{ $option->content }}</p>
            </div>
        </div>
    </div>
    <div class="ml8">
        <span class="block fs11 gray">(0%)</span>
        <div class="block forum-color"><span class="option-vote-count">{{ $option->votes()->count() }}</span><span style="margin-left: 2px">{{__('votes')}}</span></div>
    </div>
</div>