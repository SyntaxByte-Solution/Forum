<div class="report-resource-container thread-report-container">
    <div class="flex align-center space-between">
        <div style="width: calc(100% - 20px);">
            <h3 class="my8">{{ __('I am flagging to report this discussion as') }}... </h3>
        </div>
        <div class="close-report-container x-close-container-style">
            <span class="x-close">✖</span>
        </div>
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
                    <p class="no-margin ml4 fs12 gray"><span class="report-content-counter"></span><span class="report-content-counter-phrase">{{ __('Enter at least 10 characters') }}</span></p>
                </div>
            </div>
        </label>
    </div>
    <p class="fs12" style="margin: 2px 0">Please check carefully your report before submit it, because inappropriate or random reports could affect <strong>your account to be banned</strong> !</p>
    <div class="flex align-center">
        <input type="button" class="button-style mr8" value="{{ __('Submit') }}" disabled style="background-color: #a6d5ff; cursor: default">
        <div class="pointer close-report-container link-path">{{ __('Cancel') }}</div>
    </div>
</div>