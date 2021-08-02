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
        <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 559.98 559.98"><path d="M280,0C125.6,0,0,125.6,0,280S125.6,560,280,560s280-125.6,280-280S434.38,0,280,0Zm0,498.78C159.35,498.78,61.2,400.63,61.2,280S159.35,61.2,280,61.2,498.78,159.35,498.78,280,400.63,498.78,280,498.78Zm24.24-218.45V163a23.72,23.72,0,0,0-47.44,0V287.9c0,.38.09.73.11,1.1a23.62,23.62,0,0,0,6.83,17.93l88.35,88.33a23.72,23.72,0,1,0,33.54-33.54Z"/></svg>
        <p class="bold no-margin fs16">{{ __('Recent threads') }}</p>
    </div>
    @foreach($recent_threads as $thread)
    <div class="my8 mx8">
        <div>
            <div class="flex align-center" style="margin-bottom: 2px">
                <a href="{{ route('forum.all.threads', ['forum'=>$thread->forum()->slug]) }}" class="blue no-underline fs11">{{ $thread->forum()->forum }}</a>
                <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                <a href="{{ route('category.threads', ['forum'=>$thread->forum()->slug, 'category'=>$thread->category->slug]) }}" class="blue no-underline fs11">{{ $thread->category->category }}</a>
            </div>
            <div class="flex">
                <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}" class="small-image-3 rounded mr4 hidden-overflow" style="min-width: 22px">
                    <img src="{{ $thread->user->sizedavatar(36, '-l') }}" class="small-image-3" alt="" loading="lazy">
                </a>
                <div class="full-width">
                    <a href="{{ $thread->link }}" class="no-margin bold no-underline forum-color fs13">{{ $thread->slice }}</a>
                    <div class="flex align-center mt4">
                        <div class="flex align-center">
                            <svg class="size17 mr4" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                            <p class="fs11 no-margin">{{ $thread->view_count }}</p>
                        </div>

                        <div class="flex align-center ml8">
                            <svg class="small-image-size mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                            <p class="fs11 no-margin">{{ $thread->posts->count() }}</p>
                        </div>

                        <div class="move-to-right flex">
                            <div class="flex align-center mr8">
                                <p class="fs11 no-margin" style="margin-right: 2px">{{ $thread->votevalue }}</p>
                                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 402 402"><path d="M73.09,179.72H328.9a18.17,18.17,0,0,0,12.85-31.12L213.85,20.69a17.94,17.94,0,0,0-25.7,0L60.24,148.6a18.27,18.27,0,0,0,12.85,31.12Zm255.81,42.1H73.09a18.17,18.17,0,0,0-12.85,31.12l127.91,127.9a17.92,17.92,0,0,0,25.7,0l127.9-127.9a18.27,18.27,0,0,0-12.85-31.12Z"/></svg>
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