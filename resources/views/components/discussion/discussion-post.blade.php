<div class="flex post-container relative">
    <div id="{{ $post_id }}" class="absolute" style="top: -65px">

    </div>
    <div class="post-vote-container">
        <a href="" class="up-icon post-vote-button post-up-vote"></a>
        <p class="bold fs20 no-margin text-center">0</p>
        <a href="" class="down-icon post-vote-button post-down-vote"></a>
    </div>
    <div class="post-main-content">
        <p class="no-margin">{{ $post_content }}</p>
        <div class="flex">
            <div class="post-replied-by-container">
                <p class="no-margin fs11 gray">replied {{ $post_created_at }}</p>
                <div class="flex" style="margin-top: 2px">
                    <img src="{{ asset('avatar.jpg') }}" class="post-replied-by-avatar" alt="">
                    <div>
                        <a class="post-replied-by-username" href="">{{$post_owner_username}}</a>
                        <p class="post-reply-by-ach">{{ $post_owner_reputation }} rep</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>