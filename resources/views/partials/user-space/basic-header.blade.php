
<div class="full-width">
    <div class="flex align-center space-between" style="margin-bottom: 10px">
        <div class="flex align-center">
            <!-- {{ __('') }} -->
            <a href="{{ route('user.profile', ['user'=>request()->user->username]) }}" class="regular-menu-button @if($page == 'profile') rmb-selected @endif bold">{{ __('Profile') }}</a>
            <a href="{{ route('user.activities', ['user'=>request()->user->username]) }}" class="regular-menu-button @if($page == 'activities') rmb-selected @endif bold">{{ __('Activities') }}</a>
        </div>
        <a href="{{ route('user.settings', ['user'=>request()->user->username]) }}" class="regular-menu-button move-to-right @if($page == 'settings') rmb-selected @endif bold">{{ __('Edit profile and settings') }}</a>
    </div>
</div>