<div class="ms-right-panel">
    @php
        $user = auth()->user();
    @endphp
    <p class="bold forum-color" style="margin-bottom: 12px; margin-top: 0">Settings</p>
    <div class="ml4">
        <a href="{{ route('user.settings') }}" class="black-link fs13 block my8 @if($item == 'settings-general') blue block-click default-cursor @endif">Profile settings</a>
        <a href="{{ route('user.personal.settings') }}" class="black-link fs13 block my8 @if($item == 'settings-personal') blue block-click default-cursor @endif">Personal settings</a>
        <a href="" class="black-link fs13 block my8 @if($item == 'settings-password') blue block-click default-cursor @endif">Password management</a>
        <a href="" class="black-link fs13 block my8 @if($item == 'settings-account-delete') blue block-click default-cursor @endif">Delete profile</a>
    </div>
</div>