<div class="index-right-panel">
    <div class="flex align-center mx8">
        <div class="flex align-center">
            <img src="{{ asset('assets/images/icons/community.svg') }}" class="small-image mr4" alt="">
            <p class="bold my8 blue">{{ __('Forums') }}</p>
        </div>
        <div class="move-to-right">
            <a href="/forums" class="link-style">see all</a>
        </div>
    </div>
    <div class="simple-line-separator mb8"></div>
    <div class="ml8">
        @foreach($forums as $forum)
        <div class="my8 toggle-box">
            <div class="flex align-center bold toggle-container-button pointer">
                {{ $forum->forum }}
                <span class="toggle-arrow">▸</span>
                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="stop-propagation move-to-right link-style fs13 mr8">visit</a>
            </div>
            <div class="toggle-container ml8">
                @foreach($forum->categories as $category)
                <div class="my8">
                    <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="blue fs13 no-underline">{{ $category->category }}</a>
                </div>
                @endforeach
            </div>
        </div>    
        @endforeach
    </div>
</div>