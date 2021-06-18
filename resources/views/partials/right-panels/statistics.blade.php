<div class="index-right-panel mt8">
    <div class="flex align-center mx8">
        <img src="{{ asset('assets/images/icons/statistics.svg') }}" class="small-image mr4" style="margin-top: -3px" alt="">
        <p class="bold my8 blue">{{ __('Statistics') }}</p>
    </div>
    <div class="simple-line-separator my4"></div>
    <div class="flex">
        <img src="{{ asset('assets/images/icons/thread.svg') }}" class="small-image-2 mr4" alt="">
        <p class="my4 fs13">Total forums threads: {{ \App\Models\Thread::count() }}</p>
    </div>
    <div class="flex align-center my4">
        <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-2 mr4" alt="">
        <p class="my4 fs13">Total replies: {{ \App\Models\Post::count() }}</p>
    </div>
    <div class="mt8 my4">
        <div class="flex">
            <img src="{{ asset('assets/images/icons/user.svg') }}" class="small-image-2 mr4" alt="" style="margin-top:1px">
            <div>
                <p class="no-margin mt4 fs13">Total members: {{ \App\Models\User::count() }}</p>
                @php
                    $last_user_username = \App\Models\User::orderBy('created_at')->first()->username;
                @endphp
                <p class="fs11 no-margin">Our newest member: <a href="{{ route('user.profile', ['user'=>$last_user_username]) }}" class="link-style inline-block fs12 bold">{{$last_user_username}}</a></p>
            </div>
        </div>
    </div>
</div>