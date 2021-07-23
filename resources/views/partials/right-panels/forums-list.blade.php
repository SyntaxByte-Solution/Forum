<div>
    <div class="right-panel-header-container">
        <div class="flex align-center">
            <div class="small-image-2 sprite sprite-2-size forums17-icon mr4"></div>
            <p class="no-margin bold fs16">{{ __('Forums') }}</p>
        </div>
        <div class="move-to-right">
            <a href="/forums" class="link-style">see all</a>
        </div>
    </div>
    <div class="ml8">
        @foreach($forums as $forum)
        <div class="my8 py4 toggle-box">
            <div class="px8 flex align-center toggle-container-button pointer fs13">
                {{ $forum->forum }}
                <span class="toggle-arrow">▸</span>
                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="stop-propagation move-to-right link-style fs13 mr8">visit</a>
            </div>
            <div class="toggle-container mx8 px8">
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