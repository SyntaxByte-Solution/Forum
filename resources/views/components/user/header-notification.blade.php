<div class="notification-container">
    <a href="{{ $action_resource_link }}" class="link-wraper notification-component-container">
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
</div>