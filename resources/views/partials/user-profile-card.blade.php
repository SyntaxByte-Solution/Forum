<div class="button-container button-container-style absolute">
    <div class="flex">
        <a href="{{ route('user.profile', ['user'=>$user->username]) }}">
            <img src="{{ $user->avatar }}" class="user-container-image mr8" alt="">
        </a>
        <div>
        @php
            $ustatus = Cache::has('user-is-online-' . $user->id) ? 'active' : 'inactive';
        @endphp
            <h2 class="no-margin fs16 black">Mouad Nassri [<a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="user-container-username fs14">HOSTNAME47</a>]</h2>
            <div class="flex align-center">
                <img src='{{ asset("assets/images/icons/$ustatus.png") }}' class="tiny-image mr4" alt="">
                <p class="f11 no-margin">{{ $ustatus }}</p>
            </div>
        </div>
    </div>
    <div class="user-container-line-separator"></div>
    <div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                <img src="{{ asset('assets/images/icons/clock.svg') }}" class="small-image-2 mr4" alt="">
                    <p class="inline-block my4 fs13 black">Member since: </p><span class="fs13 ml8">{{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</span>
                </div>
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <img src="{{ asset('assets/images/icons/disc.png') }}" class="small-image-2 mr4" alt="">
                    <p class="inline-block my4 fs13 black">Threads: </p><span class="fs15 bold ml8">{{ $user->threads_count() }}</span>
                </div>
                @if($user->threads_count())
                <div class="fill-thin-line"></div>
                <span class="move-to-right">[<a href="{{ route('user.threads', ['user'=>$user->username]) }}" class="fs11 black-link">SEE</a>]</span>
                @endif
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-2 mr4" alt="">
                    <p class="inline-block my4 fs13 black">Replies: </p><span class="fs15 bold ml8">{{ $user->posts_count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>