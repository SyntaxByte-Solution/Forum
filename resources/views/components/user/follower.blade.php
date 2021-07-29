<div class="follow-box-item follow-box">
    <div class="flex align-center">
        <img src="{{ $follower->avatar }}" class="size36 rounded mr8" alt="{{ $follower->username . ' ' . __(' avatar') }}">
        <div>
            <a href="{{ route('user.profile', ['user'=>$follower->username]) }}" class="bold no-underline blue">{{ $follower->username }}</a>
            <p class="fs13 gray no-margin">{{ $follower->firstname . ' ' . $follower->lastname }}</p>
        </div>
    </div>
    @unless(auth()->user() && $follower->id ==auth()->user()->id)
    <div class="move-to-right height-max-content button-wraper-style @auth follow-resource follow-from-profile @endauth @guest login-signin-button @endguest">
        <div class="size14 sprite sprite-2-size follow-button-icon mr4 @if($followed) followed14-icon @else follow14-icon @endif"></div>
        @if($followed)
        <p class="no-margin btn-txt unselectable">{{ __('Followed') }}</p>
        <input type="hidden" class="status" value="1">
        @else
        <p class="no-margin btn-txt unselectable">{{ __('Follow') }}</p>
        <input type="hidden" class="status" value="-1">
        @endif
        <input type="hidden" class="follow-text" value="{{ __('Follow') }}">
        <input type="hidden" class="following-text" value="{{ __('Following ..') }}">
        <input type="hidden" class="followed-text" value="{{ __('Followed') }}">
        <input type="hidden" class="unfollowing-text" value="{{ __('Unfollowing ..') }}">
        <input type="hidden" class="followable-id" value="{{ $follower->id }}">
        <input type="hidden" class="followable-type" value="user">

        <input type="hidden" class="followed-icon" value="followed14-icon">
        <input type="hidden" class="unfollowed-icon" value="follow14-icon">
    </div>
    @endunless
</div>