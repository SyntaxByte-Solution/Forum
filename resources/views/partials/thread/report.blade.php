<div class="report-resource-container thread-report-container none">
    <input type="hidden" class="reportable-id" value="">
    <input type="hidden" class="reportable-type" value="">
    <div class="close-report-container x-close-container-style" style="top: 12px; right: 12px">
        <span class="x-close">✖</span>
    </div>
    @if($thread->already_reported)
    <div>
        <div class="flex move-to-middle">
            <div class="small-image-2 sprite sprite-2-size report17filled-icon mr8" style="margin-top: 1px"></div>
            <h2 class="text-center gray my8">{{ __('You already report this discussion.') }}</h2>
        </div>
        <p class="text-center my8">{{ __('We have received your report submit and we are going to verify if this discussion respects our guidelines and standards as soon as possible.') }}</p>
    </div>
    @else
    <div style="width: calc(100% - 20px);">
        <div class="flex">
            <div class="small-image-2 sprite sprite-2-size report17filled-icon mr8" style="margin-top: 1px"></div>
            <h3 class="no-margin mb8">{{ __('I am flagging to report this discussion as') }}... </h3>
        </div>
    </div>
    <div>
        <label class="resource-report-option">
            <input type="radio" name="report" value="spam" class="height-max-content report-input">
            <div class="ml8">
                <p class="bold no-margin">{{__('spam')}}</p>
                <p class="no-margin gray">{{__("Exists only to promote a product or service, does not disclose the author's affiliation, repetitive or out of topic")}}.</p>
            </div>
        </label>
        <label class="resource-report-option">
            <input type="radio" name="report" value="rude-or-abusive" class="height-max-content report-input">
            <div class="ml8">
                <p class="bold no-margin">{{__('rude or abusive')}}</p>
                <p class="no-margin gray">{{__('A reasonable person would find this content inappropriate for respectful discourse')}}.</p>
            </div>
        </label>
        <label class="resource-report-option">
            <input type="radio" name="report" value="low-quality" class="height-max-content report-input">
            <div class="ml8">
                <p class="bold no-margin">{{__('very low quality')}}</p>
                <p class="no-margin gray">{{__('This question has severe formatting or content problems. This discussion is unlikely to be salvageable through editing, and might need to be removed')}}.</p>
            </div>
        </label>
        <label class="resource-report-option has-child-to-be-opened">
            <input type="radio" name="report" value="moderator-intervention" class="height-max-content report-input">
            <div class="ml8">
                <p class="bold no-margin">{{__('in need of moderator intervention')}}</p>
                <p class="no-margin gray">{{__('A problem not listed above that requires action by a moderator')}}. <i>{{__('Be specific and detailed')}}!</i></p>
                <div class="child-to-be-opened">
                    <textarea name="content" class="report-section-textarea" placeholder="{{ __('Be specific and detailed') }}"></textarea>
                    <p class="no-margin ml4 fs12 gray report-content-counter"><span class="report-content-count"></span> <span class="report-content-count-phrase">{{ __('Enter at least 10 characters') }}</span></p>
                    <input type="hidden" class="first-phrase-text" value="{{ __('Enter at least 10 characters') }}">
                    <input type="hidden" class="more-to-go-text" value="{{ __('more to go..') }}">
                    <input type="hidden" class="chars-left-text" value="{{ __('characters left') }}">
                    <input type="hidden" class="too-long-text" value="{{ __('Too long by ') }}">
                    <input type="hidden" class="characters-text" value="{{ __('characters') }}">
                </div>
            </div>
        </label>
    </div>
    <p class="fs12 my8">{{__('Please check carefully your report before submit it, because inappropriate or random reports could lead')}} <strong>{{__('your account to be banned')}}</strong> !</p>
    <div class="flex align-center">
        <input type="button" class="submit-thread-report button-style mr8" value="{{ __('Submit') }}" disabled style="background-color: #a6d5ff; cursor: default">
        <input type="hidden" class="button-no-ing-text" value="{{ __('Submit') }}">
        <input type="hidden" class="button-ing-text" value="{{ __('Submitting ..') }}">
        <input type="hidden" class="reported-text" value="{{ __('Your report has been sent successfully.') }}">
        <input type="hidden" class="button-no-ing-text">
        <div class="pointer close-report-container link-path">{{ __('Cancel') }}</div>
    </div>
    @endif
</div>