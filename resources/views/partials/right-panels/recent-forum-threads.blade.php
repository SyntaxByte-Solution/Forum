@php
    $recent_threads = collect([]);
    if($forum = request()->forum) {
        if($category = request()->category) {
            $recent_threads = \App\Models\Category::find($category)->first()->threads->sortByDesc('created_at')->take(4);
        } else {
            $forum_categories_ids = \App\Models\forum::find($forum)->first()->categories->pluck('id');
            $recent_threads = \App\Models\Thread::whereIn('category_id', $forum_categories_ids)->orderBy('created_at', 'desc')->take(4)->get();
        }
    } else {
        $recent_threads = \App\Models\Thread::orderBy('created_at', 'desc')->take(4)->get();
    }
@endphp
@if($recent_threads->count())
<div>
    <div class="right-panel-header-container">
        <div class="small-image-2 sprite sprite-2-size clock17-icon mr4"></div>
        <p class="bold no-margin">{{ __('Recent threads') }}</p>
    </div>
    @foreach($recent_threads as $thread)
    <div class="my8 mx8">
        <div>
            <div class="flex align-center">
                <a href="{{ route('forum.all.threads', ['forum'=>$thread->forum()->slug]) }}" class="blue no-underline fs11">{{ $thread->forum()->forum }}</a>
                <span class="mx4 bold fs12">▸</span>
                <a href="{{ route('category.threads', ['forum'=>$thread->forum()->slug, 'category'=>$thread->category->slug]) }}" class="blue no-underline fs11">{{ $thread->category->category }}</a>
            </div>
            <div class="flex">
                <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}">
                    <img src="{{ $thread->user->avatar }}" class="small-image-3 rounded mr4" alt="">
                </a>
                <div class="full-width">
                    <a href="{{ $thread->link }}" class="no-margin bold no-underline forum-color fs13">{{ $thread->slice }}</a>
                    <div class="flex align-center mt4">
                        <div class="flex align-center">
                            <img src="{{ asset('assets/images/icons/eye.png') }}" class="small-image-size mr4" alt="">
                            <p class="fs11 no-margin">{{ $thread->view_count }}</p>
                        </div>

                        <div class="flex align-center ml8">
                            <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-size mr4" alt="">
                            <p class="fs11 no-margin">{{ $thread->posts->count() }}</p>
                        </div>

                        <div class="move-to-right flex">
                            <div class="flex align-center mr8">
                                <p class="fs11 no-margin" style="margin-right: 2px">{{ $thread->votevalue }}</p>
                                <div class="size14 sprite sprite-2-size votes14-icon"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    @if(!$loop->last)
        <div class="simple-line-separator my8"></div>
    @endif
    @endforeach
</div>
@endif