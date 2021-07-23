<div class="notification-container flex align-center relative" style="margin: 2px 0">
    <a href="{{ $action_resource_link }}" class="link-wraper notification-component-container" style="@if(!$notif_read) background-color:#ccebf74a @endif">
        <div class="relative" style="height: max-content">
            <img src="{{ $action_user->avatar }}" class="action_takers_image size48 rounded mr8" alt="{{ $action_user->firstname . ' ' . $action_user->lastname . ' profile picture' }}">
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
                <div class="small-image-2 sprite sprite-2-size delete17b-icon mr4"></div>
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