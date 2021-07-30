<div class="activity-thread-wrapper" style="@if($is_ticked) background-color: #cfffcf21; border: 1px solid #a7cca7bd; @endif">
    <div class="flex align-center mb8">
        <div class="flex align-center">
            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                {!! $forum->icon !!}
            </svg>
            <div class="flex align-center">
                <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                <svg class="size10 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
                <a href="{{ route('category.threads', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="fs11 black-link">{{ $category->category }}</a>
            </div>
            @if($is_ticked)
                <svg class="size20 ml8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/></svg>
            @endif
        </div>
        <div class="simple-border-container move-to-right">
            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><path class="cls-1" d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
            <p class="fs12 no-margin unselectable">{{ $thread->view_count }} {{ __('views') }}</p>
        </div>
    </div>
    <div class="flex">
        <div class="flex align-center height-max-content">
            <div class="flex flex-column align-center">
                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M431.34,379.05H80.7c-31.52,0-47.29-38.15-25-60.4L231,143.33a35.21,35.21,0,0,1,49.94,0L456.24,318.65C478.63,340.9,462.87,379.05,431.34,379.05Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:66px"/></svg>
                <span class="bold">{{ $thread->votes->count() }}</span>
                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M431.34,133H80.7c-31.52,0-47.29,38.15-25,60.4L231,368.67a35.21,35.21,0,0,0,49.94,0L456.24,193.35C478.63,171.1,462.87,133,431.34,133Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:66px"/></svg>
            </div>
            <div class="gray height-max-content mx4 fs10 unselectable">•</div>
        </div>
        <div>
            <div>
                <a href="{{ $thread->link }}" class="blue no-underline bold flex ml4 fs15">{{ $thread->subject }}</a>
            </div>
            <div class="flex align-center mt8">
                <div class="simple-border-container mr4">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.4,64.3C400.6,15.7,311.3,23,256,79.3,200.7,23,111.4,15.6,53.6,64.3-21.6,127.6-10.6,230.8,43,285.5L218.4,464.2a52.52,52.52,0,0,0,75.2.1L469,285.6C522.5,230.9,533.7,127.7,458.4,64.3ZM434.8,251.8,259.4,430.5c-2.4,2.4-4.4,2.4-6.8,0L77.2,251.8c-36.5-37.2-43.9-107.6,7.3-150.7,38.9-32.7,98.9-27.8,136.5,10.5l35,35.7,35-35.7c37.8-38.5,97.8-43.2,136.5-10.6,51.1,43.1,43.5,113.9,7.3,150.8Z"/></svg>
                    <p class="fs12 no-margin unselectable">{{ $thread->likes->count() }} likes</p>
                </div>
                <div class="simple-border-container mr4">
                    <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                    <p class="fs12 no-margin unselectable">{{ $thread->posts->count() }} replies</p>
                </div>
            </div>
        </div>
    </div>
</div>