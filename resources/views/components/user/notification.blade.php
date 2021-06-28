<div>
    <a href="{{ $action_resource_link }}" class="link-wraper notification-component-container">
        <div class="relative" style="height: max-content">
            <img src="{{ $action_user->avatar }}" class="size48 rounded mr8" alt="{{ $action_user->firstname . ' ' . $action_user->lastname . ' profile picture' }}">
            <div class="notification-type-icon sprite sprite-2-size {{ $resource_action_icon }}"></div>
        </div>
        <div>
            <div class="fs14">
                <strong>{{ $action_takers }}</strong> {{ $action_statement }} {{ $resource_string_slice }}
            </div>
            <div class="fs12 blue">{{ $action_date }}</div>
        </div>
    </a>
</div>