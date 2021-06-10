
<div class="full-width">
    <div class="flex align-center space-between" style="margin-bottom: 10px">
        <div class="flex align-center">
            <!-- {{ __('') }} -->
            <a href="{{ route('user.profile', ['user'=>request()->user->username]) }}" class="regular-menu-button @if($page == 'profile') rmb-selected block-click @endif bold">{{ __('Profile') }}</a>
            <a href="{{ route('user.activities', ['user'=>request()->user->username]) }}" class="regular-menu-button @if($page == 'activities') rmb-selected block-click @endif bold">{{ __('Activities') }}</a>
        </div>
        @can('update', $user)
        <a href="{{ route('user.settings', ['user'=>request()->user->username]) }}" class="regular-menu-button move-to-right @if($page == 'settings') rmb-selected block-click @endif bold">{{ __('Edit profile and settings') }}</a>
        @endcan
    </div>
</div>