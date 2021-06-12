<div class="ms-right-panel">
    <div class="flex px8 py8">
        <div>
            <img src="{{ $user->avatar }}" class="small-image-1 br6 mr8" alt="">
        </div>
        <div class="mr8">
            <h2 class="no-margin">{{ $user->firstname . ' ' . $user->lastname }}</h2>
            <p class="fs12 no-margin gray">Join Date: {{ (new \Carbon\Carbon($user->created_at))->toDayDateTimeString() }}</p>
        </div>
    </div>
    <div>
        <div>
            <p class="bold fs12 gray my8" style="margin-bottom: 0">{{ __('IMPACT') }}</p>
            <div class="relative">
                <p class="fs17 bold inline-block my4 tooltip-section">~ {{ $user->reach }}</p>
                <div class="tooltip tooltip-style-2 left0">
                    Estimated number of times people viewed your helpful posts
                    (based on page views of your questions
                    and questions where you wrote highly-ranked answers)
                </div>
                <p class="fs12 gray no-margin">People reached</p>
            </div>
        </div>
        <div class="simple-line-separator my8"></div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <img src="{{ asset('assets/images/icons/disc.png') }}" class="small-image-2 mr4" alt="">
                    <p class="inline-block my4 fs13">Discussions: </p><span class="fs15 bold ml8">{{ $discussions_count }}</span>
                </div>
                @if($discussions_count)
                <div class="fill-thin-line"></div>
                <span class="move-to-right">[<a href="{{ route('user.discussions', ['user'=>$user->username]) }}" class="fs11 black-link">SEE</a>]</span>
                @endif
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <img src="{{ asset('assets/images/icons/bqst.png') }}" class="small-image-2 mr4" alt="">
                    <p class="inline-block my4 fs13">Questions: </p><span class="fs15 bold ml8">{{ $questions_count }}</span>
                </div>
                @if($questions_count)
                <div class="fill-thin-line"></div>
                <span class="move-to-right">[<a href="{{ route('user.questions', ['user'=>$user->username]) }}" class="fs11 black-link">SEE</a>]</span>
                @endif
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-2 mr4" alt="">
                    <p class="inline-block my4 fs13">Replies: </p><span class="fs15 bold ml8">{{ $posts_count }}</span>
                </div>
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <img src="{{ asset('assets/images/icons/eye.png') }}" class="small-image-2 mr4" alt="">
                    <p class="inline-block my4 fs13">Profile views: </p><span class="fs15 bold ml8">{{ $user->profile_views }}</span>
                </div>
            </div>
        </div>
        <div class="my4">
            <div class="flex align-center">
                <div class="flex align-center">
                    <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image-2 mr4" alt="">
                    <p class="inline-block my4 fs13">Votes casts: </p><span class="fs15 bold ml8">20K</span>
                </div>
            </div>
        </div>
    </div>
</div>