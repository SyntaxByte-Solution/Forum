<div class="user-component-container flex align-center {{ $attributes['class'] }}" style="{{ $attributes['style'] }}">
    <div class="flex relative has-fade rounded hidden-overflow">
        <div class="fade-loading"></div>
        <img data-src="{{ $user->sizedavatar(100) }}" class="size60 rounded lazy-image image-with-fade" alt="">
    </div>
    <div class="ml8">
        <div class="relative user-profile-card-box">
            <input type="hidden" class="user-card-container-index"> <!-- value will be initialized at run time by js, to identify each container with incremented index (go to depth.js file) -->
            <a href="{{ $user->profilelink }}" class="my4 fs16 bold no-underline blue user-profile-card-displayer">{{ $user->username }}</a>
            <!--@ include ('partials.user-profile-card', ['user'=>$user])-->
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
            <p class="fs11 gray my4">{{ __('Member since') . ': ' . $member_since }}</p>
        </div>
    </div>
</div>