<div class="notification-container flex align-center relative" style="margin: 2px 0">
    <a href="{{ $action_resource_link }}" class="link-wraper notification-component-container" style="@if(!$notif_read) background-color:#ccebf74a @endif">
        <div class="relative" style="height: max-content">
            <div class="size48 rounded hidden-overflow mr8 relative has-fade">
                <div class="fade-loading"></div>
                <img src="{{ $action_user->sizedavatar(36, '-l') }}" class="action_takers_image image-that-fade-wait handle-image-center-positioning" alt="{{ $action_user->firstname . ' ' . $action_user->lastname . ' profile picture' }}">
            </div>
            <div class="action_type_icon notification-type-icon sprite sprite-2-size {{ $resource_action_icon }}"></div>
        </div>
        <div>
            <div class="fs14">
                <strong class="action_takers">{{ $action_takers }}</strong> <span class="action_statement">{{ $action_statement }}</span> <span class="action_resource_slice">{{ $resource_string_slice }}</span>
            </div>
            <div class="fs12 blue bold">{{ $action_date }}</div>
        </div>
    </a>
    <div class="notification-menu-button-container relative none">
        <div class="nested-soc-button notification-menu-button size24 sprite sprite-2-size menu24-icon pointer"></div>
        <div class="suboptions-container nested-soc simple-button-suboptions-container">
            <input type="hidden" class="notif-id" value="{{ $notification_id }}">
            <a href="" class="suboption-style-1 fs13 delete-notification align-center" style="width: 230px;">
                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                <span class="button-text">{{ __('Delete this notification') }}</span>
                <input type="hidden" class="message-ing" value="{{ __('Deleting notification..') }}">
            </a>
            @if($could_be_disabled)
            <a href="" class="suboption-style-1 fs13 disable-switch-notification @if($disabled) enable-notification @else disable-notification @endif align-center" style="width: 230px;">
                <div class="notif-switch-icon small-image-2 sprite sprite-2-size @if($disabled) enablenotif17b-icon @else disablenotif17b-icon @endif disablenotif17b-icon mr4"></div>
                @if($disabled)
                    <span class="button-text">{{ __('Enable notifications on this post') }}</span>
                @else
                    <span class="button-text">{{ __('Disable notifications on this post') }}</span>
                @endif
                <input type="hidden" class="disable-message-ing" value="{{ __('Disabling notifications..') }}">
                <input type="hidden" class="enable-message-ing" value="{{ __('Enabling notifications..') }}">
                <input type="hidden" class="disable-action-text" value="{{ __('Disable notifications on this post') }}">
                <input type="hidden" class="enable-action-text" value="{{ __('Enable notifications on this post') }}">
            </a>
            @endif
        </div>
    </div>
</div>