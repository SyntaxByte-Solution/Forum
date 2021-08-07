<div class="button-container button-container-style absolute">
    <div class="flex">
        <a href="{{ route('user.profile', ['user'=>$user->username]) }}">
            <img src="{{ $user->sizedavatar(100) }}" class="user-container-image mr8" alt="">
        </a>
        <div>
        @php
            $ustatus = Cache::has('user-is-online-' . $user->id) ? 'active' : 'inactive';
        @endphp
            <h2 class="no-margin fs16 black">Mouad Nassri [<a href="{{ route('user.profile', ['user'=>$user->username]) }}" class="user-container-username fs14">HOSTNAME47</a>]</h2>
            <div class="flex align-center">
                <svg class="tiny-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    @if($ustatus == 'active')
                    <path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#25BD54"/>
                    @else
                    <path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#919191"/>
                    @endif
                </svg>
                <p class="fs12 no-margin">@if(Cache::has('user-is-online-' . $user->id)) Online @else Offline @endif</p>
            </div>
        </div>
    </div>
    <div class="user-container-line-separator"></div>
    <div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 559.98 559.98"><path d="M280,0C125.6,0,0,125.6,0,280S125.6,560,280,560s280-125.6,280-280S434.38,0,280,0Zm0,498.78C159.35,498.78,61.2,400.63,61.2,280S159.35,61.2,280,61.2,498.78,159.35,498.78,280,400.63,498.78,280,498.78Zm24.24-218.45V163a23.72,23.72,0,0,0-47.44,0V287.9c0,.38.09.73.11,1.1a23.62,23.62,0,0,0,6.83,17.93l88.35,88.33a23.72,23.72,0,1,0,33.54-33.54Z"/></svg>
                    <p class="inline-block my4 fs13 black">Member since: </p><span class="fs13 ml8">{{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</span>
                </div>
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M384.72,275.71l-21.2,21.21-21.21-21.21,84.83-84.84-42.41-42.41,21.2-21.21,21.21,21.21,63.63-63.63L427.14,21.21,363.52,84.83,384.73,106l-21.21,21.21L321.1,84.83l-84.83,84.84-21.21-21.21,21.21-21.21L109,0,3,106,130.22,233.29l21.21-21.21,21.21,21.21-42.42,42.42,42.41,42.42-24.92,24.95a105.13,105.13,0,0,0-137.08,9.86L0,363.54l63.62,63.63-53,53L31.84,501.4l53-53L148.48,512l10.61-10.61a105.12,105.12,0,0,0,9.83-137.1l24.93-25,42.42,42.42,42.41-42.42,21.21,21.21-21.21,21.21L405.93,509,512,403ZM427.14,63.63l21.21,21.2L427.14,106,405.93,84.83ZM147.42,468.52,43.51,364.61A75,75,0,0,1,147.42,468.52Zm237.3-150.39,31.82,31.81-21.21,21.21-31.81-31.82ZM215.06,190.88l-21.21,21.2-21.21-21.2,21.21-21.21ZM109,42.42l31.81,31.81L119.62,95.44,87.81,63.63ZM45.39,106,66.6,84.83l31.81,31.82L77.2,137.86Zm84.83,84.84L98.41,159.06l21.21-21.21,31.81,31.82Zm42.42-42.42-31.81-31.81L162,95.44l31.81,31.81Zm63.63,190.87-63.63-63.62L321.1,127.25l63.63,63.63Zm63.62-21.2,21.21-21.21,21.21,21.21-21.21,21.2Zm21.21,63.62,21.21-21.21,31.81,31.81-21.21,21.21Zm84.83,84.83-31.81-31.81,21.21-21.21,31.81,31.82Zm10.61-74.23,21.2-21.2L469.56,403l-21.21,21.21Z"/></svg>
                    <p class="inline-block my4 fs13 black">Reach: </p><span class="fs15 bold ml8">{{ $user->reach }}</span>
                </div>
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                    <p class="inline-block my4 fs13 black">Threads: </p><span class="fs15 bold ml8">{{ $user->threads_count() }}</span>
                </div>
                @if($user->threads_count())
                <div class="fill-thin-line"></div>
                <span class="move-to-right">[<a href="{{ route('user.activities', ['user'=>$user->username]) }}" class="fs11 black-link">SEE</a>]</span>
                @endif
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                    <p class="inline-block my4 fs13 black">Replies: </p><span class="fs15 bold ml8">{{ $user->posts_count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>