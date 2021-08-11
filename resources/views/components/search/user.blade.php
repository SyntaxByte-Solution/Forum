<div class="user-component-container flex align-center {{ $attributes['class'] }}" style="{{ $attributes['style'] }}">
    <div class="flex relative has-fade rounded hidden-overflow">
        <div class="fade-loading"></div>
        <img src="{{ $user->sizedavatar(36) }}" class="size60 rounded image-that-fade-wait" alt="">
    </div>
    <div class="ml8">
        <div class="relative">
            <a href="{{ $user->profilelink }}" class="my4 fs16 bold no-underline blue button-with-container">{{ $user->username }}</a>
            @include('partials.user-profile-card', ['user'=>$user])
        </div>
        <div>
            <div class="flex align-center">
                @if($city = $user->personal->city)
                    <p class="my4 fs12">{{ ucfirst(mb_strtolower($city, 'UTF-8')) }}</p>
                @endif
                @if($country = $user->personal->country)
                    <p class="my4 fs12"> - {{ ucfirst(mb_strtolower($country, 'UTF-8')) }}</p>
                @endif
            </div>
            <p class="fs11 gray my4">{{ 'Member since: ' . $member_since }}</p>
        </div>
    </div>
</div>