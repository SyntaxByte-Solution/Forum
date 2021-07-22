<div class="report-resource-container thread-report-container none">
    <div class="close-report-container x-close-container-style" style="top: 12px; right: 12px">
        <span class="x-close">✖</span>
    </div>
    <div style="width: calc(100% - 20px);">
        <h3 class="no-margin mb8">{{ __('I am flagging to report this discussion as') }}... </h3>
    </div>
    <div>
        <label class="resource-report-option">
            <input type="radio" name="report" value="spam" class="height-max-content report-input">
            <div class="ml8">
                <p class="bold no-margin">spam</p>
                <p class="no-margin gray">Exists only to promote a product or service, does not disclose the author's affiliation.</p>
            </div>
        </label>
        <label class="resource-report-option">
            <input type="radio" name="report" value="rude-or-abusive" class="height-max-content report-input">
            <div class="ml8">
                <p class="bold no-margin">rude or abusive</p>
                <p class="no-margin gray">A reasonable person would find this content inappropriate for respectful discourse.</p>
            </div>
        </label>
        <label class="resource-report-option">
            <input type="radio" name="report" value="low-quality" class="height-max-content report-input">
            <div class="ml8">
                <p class="bold no-margin">very low quality</p>
                <p class="no-margin gray">This question has severe formatting or content problems. This question is unlikely to be salvageable through editing, and might need to be removed.</p>
            </div>
        </label>
        <label class="resource-report-option has-child-to-be-opened">
            <input type="radio" name="report" value="moderator-intervention" class="height-max-content report-input">
            <div class="ml8">
                <p class="bold no-margin">in need of moderator intervention</p>
                <p class="no-margin gray">A problem not listed above that requires action by a moderator. <i>Be specific and detailed!</i></p>
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
    <p class="fs12 my8">Please check carefully your report before submit it, because inappropriate or random reports could affect <strong>your account to be banned</strong> !</p>
    <div class="flex align-center">
        <input type="button" class="submit-report button-style mr8" value="{{ __('Submit') }}" disabled style="background-color: #a6d5ff; cursor: default">
        <input type="hidden" class="button-ing-text" value="{{ __('Submit') }}">
        <input type="hidden" class="button-ing-text" value="{{ __('Submitting ..') }}">
        <input type="hidden" class="button-no-ing-text">
        <div class="pointer close-report-container link-path">{{ __('Cancel') }}</div>
    </div>
</div>