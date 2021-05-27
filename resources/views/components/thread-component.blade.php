<div style="margin: 20px 0">
    <h1 id="page-title" class="page-title-icon discussion-icon">{{ $thread_subject }}</h1>
    <div class="thread-container flex">
        <div class="thread-owner-section">
            <img src="{{ asset('avatar.jpg') }}" class="thread-owner-picture block" alt="{{ __('thread owner profile picture') }}">
            <p class="thread-owner-username text-center">{{ $thread_owner_username }}</p>
            <div class="thread-owner-badges">

            </div>
            <div class="thread-owner-infos-container">
                <p class="thread-owner-info"><span class="bold fs13">{{__('Reputation')}}</span>: {{ $thread_owner_reputation }}</p>
                <p class="thread-owner-info"><span class="bold fs13">{{__('Posts')}}</span>: {{ $thread_owner_posts_number }}</p>
                <p class="thread-owner-info"><span class="bold fs13">{{__('Threads')}}</span>: {{ $thread_owner_threads_number }}</p>
                <p class="thread-owner-info"><span class="bold fs13">{{__('Joined')}}</span>: {{ $thread_owner_joined_at }}</p>
            </div>
        </div>
        <div class="full-width thread-content-container relative">
            <div class="flex">
                <div class="thread-vote-container">
                    <a href="" class="up-icon thread-vote-button thread-up-vote"></a>
                    <p class="bold fs17 no-margin text-center">0</p>
                    <a href="" class="down-icon thread-vote-button thread-down-vote"></a>
                </div>
                <div>
                    <p class="no-margin fs12 pd4">posted at >> {{ $thread_created_at }}</p>
                    <p class="no-margin fs12 pd4">viewed >> {{ $thread_view_counter }} times</p>
                </div>
            </div>

            <p class="thread-content">
                {{ $thread_content }}
            </p>
            <div class="thread-bottom-strip">
                <div class="thread-l-sep"></div>
                <div class="flex">
                    <a href="" class="link-path" class="block" style="margin: 4px">Direct Link</a>
                    <div class="move-to-right flex">
                        <a href="" class="button-with-icon reply-icon">reply</a>
                        <a href="" class="button-with-only-icon report-icon"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>