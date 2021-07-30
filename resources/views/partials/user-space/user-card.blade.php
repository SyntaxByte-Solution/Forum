<div class="ms-right-panel">
    @php
        $ustatus = Cache::has('user-is-online-' . $user->id) ? 'active' : 'inactive';
        $login_status = Cache::has('user-is-online-' . $user->id) ? 'online' : 'offline';
    @endphp
    <div class="flex px8 py8">
        <div class="small-image-1 br6 mr8 hidden-overflow">
            <img src="{{ $user->avatar }}" class="handle-image-center-positioning" alt="">
        </div>
        <div class="mr8">
            <h2 class="no-margin">{{ $user->firstname . ' ' . $user->lastname }}</h2>
            <p class="fs12 no-margin gray">Join Date: {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
            <div class="flex align-center">
                <div class="flex align-center">
                    @if($ustatus == 'active')
                    <svg class="tiny-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#25BD54"/></svg>
                    @else
                    <svg class="tiny-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#919191"/></svg>
                    @endif
                    <span class="fs13 gray">{{ $login_status }}</span>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div>
            <p class="bold fs12 gray" style="margin-bottom: 0">{{ __('IMPACT') }}</p>
            <div class="relative">
                <p class="fs17 bold inline-block my4 tooltip-section">~ {{ $user->reach }}</p>
                <div class="tooltip tooltip-style-2 left0">
                    {{ __('Estimated number of times people viewed your helpful posts
                    (based on page views of your questions
                    and questions where you wrote highly-ranked answers)') }}
                </div>
                <p class="fs12 gray no-margin">People reached</p>
            </div>
        </div>
        <div class="simple-line-separator my8"></div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                    <p class="inline-block my4 fs12">Threads: </p><span class="bold ml8">{{ $threads_count }}</span>
                </div>
                @if($threads_count)
                <div class="fill-thin-line"></div>
                <span class="move-to-right">[<a href="{{ route('user.activities', ['user'=>$user->username]) }}" class="fs11 black-link">SEE</a>]</span>
                @endif
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                    <p class="inline-block my4 fs12">Replies: </p><span class="bold ml8">{{ $user->posts_count() }}</span>
                </div>
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <svg class="mr4 size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><path class="cls-1" d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                    <p class="inline-block my4 fs12">Profile views: </p><span class="bold ml8">{{ $user->profile_views }}</span>
                </div>
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g id="Layer_1_copy" data-name="Layer 1 copy"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></g></svg>
                    <p class="inline-block my4 fs12">Votes casts: </p><span class="bold ml8">{{ $user->votes_count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>