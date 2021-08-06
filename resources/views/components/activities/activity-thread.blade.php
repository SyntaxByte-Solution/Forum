<div class="activity-thread-wrapper thread-container-box relative" style="@if($is_ticked) background-color: #cfffcf21; border: 1px solid #a7cca7bd; @endif">
    <div class="absolute full-shadowed zi12 thread-permanent-deletion-dialog br6">
        <svg class="size14 simple-button-style rounded hide-parent" style="position: absolute; top: 6px; right: 6px" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 95.94 95.94"><path d="M62.82,48,95.35,15.44a2,2,0,0,0,0-2.83l-12-12A2,2,0,0,0,81.92,0,2,2,0,0,0,80.5.59L48,33.12,15.44.59a2.06,2.06,0,0,0-2.83,0l-12,12a2,2,0,0,0,0,2.83L33.12,48,.59,80.5a2,2,0,0,0,0,2.83l12,12a2,2,0,0,0,2.82,0L48,62.82,80.51,95.35a2,2,0,0,0,2.82,0l12-12a2,2,0,0,0,0-2.83Z"/></svg>
        <div class="white px8 py8 full-height flex flex-column justify-center border-box">
            <h2 class="no-margin fs18">{{ __('Please make sure you want to delete permanently the thread !') }}</h2>
            <p class="fs12 no-margin" style="width: 75%">{{ __('This will remove the thread permanently. By removing the thread, everything related to it will be deleted (replies, votes ..)') }}</p>
            <div class="my8 mx4 flex space-between">
                <form action="{{ route('thread.destroy', ['thread'=>$thread->id]) }}" class="delete-permanent-form" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="simple-white-button mr8" value='{{ __("Delete permanently") }}'>
                </form>
            </div>
        </div>
    </div>
    <div class="hidden-thread-section none px8 py8">
        <p class="my4 fs12">Thread hidden. If you want to show it again <span class="pointer blue thread-display-button">click here</span></p>
    </div>
    <div class="thread-component">
        <div class="full-width">
            <div class="flex align-center space-between mb8">
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
                <div class="flex align-center move-to-right">
                    <div class="simple-border-container">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><path class="cls-1" d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                        <p class="fs12 no-margin unselectable">{{ $thread->view_count }} {{ __('views') }}</p>
                    </div>
                    <div class="relative ml8">
                        <svg class="pointer button-with-suboptions size20 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                        <div class="suboptions-container suboptions-container-right-style">
                            @if(is_null($thread->deleted_at))
                                <a href="{{ $thread->link }}" target="_blank" class="no-underline simple-suboption flex align-center">
                                    <svg class="mr4 size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><path class="cls-1" d="M1,12S5,4,12,4s11,8,11,8-4,8-11,8S1,12,1,12ZM12,9a3,3,0,1,1-3,3A3,3,0,0,1,12,9Z"/></svg>
                                    <div class="black">{{ __('See thread') }}</div>
                                </a>
                                <a href="{{ $edit_link }}" target="_blank" class="no-underline simple-suboption flex align-center">
                                    <div class="small-image-2 sprite sprite-2-size pen17-icon mr4"></div>
                                    <div class="black">{{ __('Edit thread') }}</div>
                                </a>
                            @else
                                <div class="no-underline simple-suboption flex align-center">
                                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 448"><path d="M234.67,138.67V245.33L326,299.52l15.36-25.92-74.66-44.27V138.67ZM255.89,32C149.76,32,64,118,64,224H0l83.09,83.09,1.5,3.1L170.67,224h-64a149.68,149.68,0,1,1,43.84,105.49l-30.19,30.19A190.8,190.8,0,0,0,255.89,416C362,416,448,330,448,224S362,32,255.89,32Z"/></svg>
                                    <div class="black">{{ __('Restore thread') }}</div>
                                </div>
                                <div class="thread-permanent-delete no-underline simple-suboption flex align-center" style="background-color: #ffa3a3">
                                    <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                    <div class="black">{{ __('Delete permanently') }}</div>
                                </div>
                            @endif
                            <div class="pointer simple-suboption thread-display-button flex align-center">
                                <div class="small-image-2 sprite sprite-2-size eyecrossed17-icon mr4"></div>
                                <div>{{ __('Hide thread') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="flex align-center height-max-content mr8">
                    <div class="flex flex-column align-center">
                        <div class="size24 rounded hidden-overflow mb4" style="min-width: 24px">
                            <a href="{{ $thread->user->link }}">
                                <img src="{{ asset($thread->user->sizedavatar(36, '-l')) }}" class="activity-thread-user-image handle-image-center-positioning" alt="">
                            </a>
                        </div>
                        <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M431.34,379.05H80.7c-31.52,0-47.29-38.15-25-60.4L231,143.33a35.21,35.21,0,0,1,49.94,0L456.24,318.65C478.63,340.9,462.87,379.05,431.34,379.05Z" style="@if($thread->voted_by($activity_user, 'up')) fill: #2ca0ff; stroke: #2ca0ff; @else fill:none; stroke:#000; @endif stroke-miterlimit:10;stroke-width:66px"/></svg>
                        <span class="bold">{{ $thread->votes->count() }}</span>
                        <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M431.34,133H80.7c-31.52,0-47.29,38.15-25,60.4L231,368.67a35.21,35.21,0,0,0,49.94,0L456.24,193.35C478.63,171.1,462.87,133,431.34,133Z" style="@if($thread->voted_by($activity_user, 'down')) fill: #2ca0ff; stroke: #2ca0ff; @else fill:none; stroke:#000; @endif stroke-miterlimit:10;stroke-width:66px"/></svg>
                    </div>
                </div>
                <div>
                    <div>
                        <a href="{{ $thread->link }}" class="blue no-underline bold flex fs15">{{ $thread->subject }}</a>
                        <div class="relative flex align-center" style="margin-top: 2px">
                            <div class="size14" title="{{ $thread->visibility->visibility }}">
                                <svg class="size14 thread-resource-visibility-icon" style="fill: #202020; margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    {!! $thread->visibility->icon !!}
                                </svg>
                            </div>
                            <span class="fs10 gray" style="margin: 2px 4px">•</span>
                            <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{ __('Posted') }}: {{ $at_hummans }}</p>
                            <div class="tooltip tooltip-style-1">
                                {{ $at }}
                            </div>
                        </div>
                    </div>
                    <div class="flex align-center mt8">
                        <div class="simple-border-container mr4">
                            @if($thread->liked_by($activity_user))
                            <svg class="size14 mr4" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path style="fill: #D7443E;" d="M462.3,62.6C407.5,15.9,326,24.3,275.7,76.2L256,96.5,236.3,76.2C186.1,24.3,104.5,15.9,49.7,62.6c-62.8,53.6-66.1,149.8-9.9,207.9L233.3,470.3a31.35,31.35,0,0,0,45.3,0L472.1,270.5c56.3-58.1,53-154.3-9.8-207.9Z"/></svg>
                            @else
                            <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.4,64.3C400.6,15.7,311.3,23,256,79.3,200.7,23,111.4,15.6,53.6,64.3-21.6,127.6-10.6,230.8,43,285.5L218.4,464.2a52.52,52.52,0,0,0,75.2.1L469,285.6C522.5,230.9,533.7,127.7,458.4,64.3ZM434.8,251.8,259.4,430.5c-2.4,2.4-4.4,2.4-6.8,0L77.2,251.8c-36.5-37.2-43.9-107.6,7.3-150.7,38.9-32.7,98.9-27.8,136.5,10.5l35,35.7,35-35.7c37.8-38.5,97.8-43.2,136.5-10.6,51.1,43.1,43.5,113.9,7.3,150.8Z"/></svg>
                            @endif
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
    </div>
</div>