<div id="poll-option-deletion-viewer" class="global-viewer full-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>

    <div class="viewer-box-style-1">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color">{{ __('Delete Option') }}</span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div style="padding: 14px">
            <p class="no-margin mb8 fs15">{{ __('Are you sure you want to delete this option from the poll') }} ?</p>
            <div class="flex">
                <div class="move-to-right">
                    <div class="flex align-center">
                        <input type="hidden" class="optionid">
                        <input type="button" class="delete-option button-style mr8" value="{{ __('Delete') }}">
                        <input type="hidden" class="button-no-ing-text" value="{{ __('Delete') }}">
                        <input type="hidden" class="button-ing-text" value="{{ __('Deleting') }}..">
                        <input type="hidden" class="reported-text" value="{{ __('Option removed from the poll') }}">
                        <div class="pointer close-global-viewer bblack bold">{{ __('Cancel') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>