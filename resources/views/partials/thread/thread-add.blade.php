@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpush

@php
    $forums = \App\Models\Forum::all();
    $categories = $forums->first()->categories->where('slug', '<>', 'announcements');
    $category = $categories->first();
@endphp

<div id="thread-add-container-size">
    <div class="thread-add-container">
        <input type="hidden" class="forum" value="{{ $forums->first()->id }}">
        <input type="hidden" class="category" value="{{ $category->id }}">
        <div class="thread-add-header flex align-center">
            <div class="size28 rounded hidden-overflow mr4 relative">
                <img src="{{ auth()->user()->sizedavatar(36, '-l') }}" class="size28" alt="">
            </div>
            <div class="relative">
                <div>
                    <div class="flex align-center forum-color button-with-suboptions pointer thread-add-posted-to fs12">
                        <span class="mr4">{{ __('Forum') }}:</span>
                        <svg class="small-image-size thread-add-forum-icon mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M161.12,362.63c-8.69-8.69-4.16-6.24-25.12-11.85-9.51-2.55-17.87-7.45-25.43-13.32L65.2,448.7a16,16,0,0,0,15.43,22l52.69-2L169.56,507A16,16,0,0,0,196,502l52-127.62a71.76,71.76,0,0,1-86.92-11.79ZM446.8,448.7,401.43,337.46c-7.56,5.88-15.92,10.77-25.43,13.32-21.07,5.64-16.45,3.18-25.12,11.85A71.78,71.78,0,0,1,264,374.42L316,502a16,16,0,0,0,26.43,5l36.25-38.28,52.69,2A16,16,0,0,0,446.8,448.7ZM327,340c15.28-15.55,17-14.21,38.79-20.14a40.64,40.64,0,0,0,28.47-29c7.48-28.4,5.54-25,25.95-45.75a41.48,41.48,0,0,0,10.42-39.58c-7.47-28.38-7.48-24.42,0-52.83a41.48,41.48,0,0,0-10.42-39.58c-20.41-20.78-18.47-17.36-25.95-45.75a40.64,40.64,0,0,0-28.47-29c-27.88-7.61-24.52-5.62-45-26.41A39.79,39.79,0,0,0,282,1.39c-27.87,7.6-24,7.61-51.9,0A39.77,39.77,0,0,0,191.16,12c-20.41,20.78-17,18.8-44.94,26.41a40.64,40.64,0,0,0-28.47,29c-7.47,28.39-5.54,25-25.95,45.75a41.46,41.46,0,0,0-10.42,39.58c7.47,28.36,7.48,24.4,0,52.82A41.51,41.51,0,0,0,91.8,245.13c20.41,20.78,18.47,17.35,26,45.75a40.64,40.64,0,0,0,28.47,29C168.6,326,170.27,325,185,340a39.74,39.74,0,0,0,49.74,5.82,39.68,39.68,0,0,1,42.53,0A39.73,39.73,0,0,0,327,340ZM161.66,176c0-53,42.24-96,94.34-96s94.34,43,94.34,96S308.1,272,256,272s-94.34-43-94.34-96Z"/>
                        </svg>
                        <span class="thread-add-selected-forum">{{ $forums->first()->forum }}</span>
                        <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                    </div>
                    <div class="suboptions-container thread-add-suboptions-container">
                        @foreach($forums as $forum)
                            <div class="thread-add-suboption thread-add-forum flex align-center">
                                <svg class="small-image-size forum-ico mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    {!! $forum->icon !!}
                                </svg>
                                <span class="thread-add-forum-val">{{ $forum->forum }}</span>
                                <div class="loading-dots-anim ml4 none">•</div>
                                <input type="hidden" class="forum-id" value="{{ $forum->id }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <svg class="size12 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path d="M224.31,239l-136-136a23.9,23.9,0,0,0-33.9,0l-22.6,22.6a23.9,23.9,0,0,0,0,33.9l96.3,96.5-96.4,96.4a23.9,23.9,0,0,0,0,33.9L54.31,409a23.9,23.9,0,0,0,33.9,0l136-136a23.93,23.93,0,0,0,.1-34Z"/></svg>
            <div class="relative">
                <div>
                    <div class="flex align-center forum-color button-with-suboptions pointer thread-add-posted-to fs12">
                        <span class="mr4">{{ __('Category') }}:</span>
                        <span class="thread-add-selected-category">{{ $category->category }}</span>
                        <svg class="size7 mx4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 292.36 292.36"><path d="M286.93,69.38A17.52,17.52,0,0,0,274.09,64H18.27A17.56,17.56,0,0,0,5.42,69.38a17.93,17.93,0,0,0,0,25.69L133.33,223a17.92,17.92,0,0,0,25.7,0L286.93,95.07a17.91,17.91,0,0,0,0-25.69Z"/></svg>
                    </div>
                    <div class="suboptions-container thread-add-suboptions-container" style="width: 190px">
                        <div class="thread-add-categories-container">
                            @foreach($categories as $category)
                                <div class="thread-add-suboption thread-add-category flex align-center">
                                    <span class="thread-add-category-val">{{ $category->category }}</span>
                                    <input type="hidden" class="category-id" value="{{ $category->id }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative move-to-right">
                <div class="audience-button button-with-suboptions flex align-center pointer">
                    <p class="no-margin mr4 fs12 gray">{{__('Visibility')}}: </p>
                    <svg class="size18 thread thread-add-visibility-icon" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z"/></svg>
                    <input type="hidden" class="thread-add-visibility-slug" value="public">
                </div>
                <div class="suboptions-container thread-add-suboptions-container" style="right: 0; min-width: 156px">
                    <div class="thread-add-suboption thread-add-visibility flex align-center">
                        <svg class="size17 mr8" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z"/></svg>
                        <span class="thread-add-forum-val">{{ __('Public') }}</span>
                        <input type="hidden" class="thread-visibility" value="public">
                        <input type="hidden" class="selected-icon-path" value="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8ZM456,256a199.12,199.12,0,0,1-10.8,64.4H424.9a15.8,15.8,0,0,1-11.4-4.8l-32-32.6a11.92,11.92,0,0,1,.1-16.7l12.5-12.5v-8.7a11.36,11.36,0,0,0-3.3-8l-9.4-9.4a11.36,11.36,0,0,0-8-3.3h-16a11.31,11.31,0,0,1-8-19.3l9.4-9.4a11.36,11.36,0,0,1,8-3.3h32a11.35,11.35,0,0,0,11.3-11.3v-9.4a11.35,11.35,0,0,0-11.3-11.3H362.1a16,16,0,0,0-16,16v4.5a16,16,0,0,1-10.9,15.2l-31.6,10.5a8,8,0,0,0-5.5,7.6v2.2a8,8,0,0,1-8,8h-16a8,8,0,0,1-8-8,8,8,0,0,0-8-8H255a8.15,8.15,0,0,0-7.2,4.4l-9.4,18.7a15.92,15.92,0,0,1-14.3,8.8H202a16,16,0,0,1-16-16V199a16.06,16.06,0,0,1,4.7-11.3l20.1-20.1a24.74,24.74,0,0,0,7.2-17.5,8,8,0,0,1,5.5-7.6l40-13.3a11.64,11.64,0,0,0,4.4-2.7l26.8-26.8a11.31,11.31,0,0,0-8-19.3H266l-16,16v8a8,8,0,0,1-8,8H226a8,8,0,0,1-8-8v-20a8.05,8.05,0,0,1,3.2-6.4l28.9-21.7c1.9-.1,3.8-.3,5.7-.3C366.3,56,456,145.7,456,256ZM138.1,149.1a11.36,11.36,0,0,1,3.3-8l25.4-25.4a11.31,11.31,0,0,1,19.3,8v16a11.36,11.36,0,0,1-3.3,8l-9.4,9.4a11.36,11.36,0,0,1-8,3.3h-16A11.35,11.35,0,0,1,138.1,149.1Zm128,306.4v-7.1a16,16,0,0,0-16-16H229.9c-10.8,0-26.7-5.3-35.4-11.8l-22.2-16.7a45.42,45.42,0,0,1-18.2-36.4V343.6a45.44,45.44,0,0,1,22.1-39l42.9-25.7a46.1,46.1,0,0,1,23.4-6.5h31.2a45.62,45.62,0,0,1,29.6,10.9l43.2,37.1h18.3a31.94,31.94,0,0,1,22.6,9.4l17.3,17.3a18.32,18.32,0,0,0,12.9,5.3H431A199.64,199.64,0,0,1,266.1,455.5Z">
                    </div>
                    <div class="thread-add-suboption thread-add-visibility flex align-center">
                        <svg class="size17 mr8" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z"/></svg>
                        <span class="thread-add-forum-val">{{ __('Followers-only') }}</span>
                        <input type="hidden" class="thread-visibility" value="followers-only">
                        <input type="hidden" class="selected-icon-path" value="M234.07,471.13H60.39a20,20,0,0,1-19-26.09c19.73-61.34,79.91-104.19,146.34-104.19a149.32,149.32,0,0,1,85.84,26.92A20,20,0,0,0,296.4,335a189.62,189.62,0,0,0-39.82-21.26,101.61,101.61,0,0,0,33.05-67,150.31,150.31,0,0,1,190.54-15.57A20,20,0,1,0,503,198.4a189.62,189.62,0,0,0-39.82-21.26,101.81,101.81,0,1,0-137.1-.22c-2.78,1.07-5.55,2.21-8.29,3.42a188.79,188.79,0,0,0-35.17,20.18A101.8,101.8,0,1,0,119.3,313.38c-54.15,20.29-98,63.87-115.93,119.44a59.91,59.91,0,0,0,57,78.24H234.07a20,20,0,0,0,0-39.93Zm160.7-431.2a61.89,61.89,0,1,1-61.88,61.88A62,62,0,0,1,394.77,39.93ZM188.15,176.55a61.89,61.89,0,1,1-61.88,61.89A62,62,0,0,1,188.15,176.55ZM503.22,326.08a20,20,0,0,0-27.86,4.61L377,468.14a11.39,11.39,0,0,1-16.41.85l-63.7-61.17a20,20,0,0,0-27.66,28.8L333,497.85A51.48,51.48,0,0,0,368.37,512c1.13,0,2.26,0,3.39-.11a51.46,51.46,0,0,0,36.6-19.06c.23-.29.45-.59.67-.89l98.8-138A20,20,0,0,0,503.22,326.08Z">
                    </div>
                    <div class="thread-add-suboption thread-add-visibility flex align-center">
                        <svg class="size17 mr8" style="fill: #202020" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z"/></svg>
                        <span class="thread-add-forum-val">{{ __('Private') }}</span>
                        <input type="hidden" class="thread-visibility" value="private">
                        <input type="hidden" class="selected-icon-path" value="M412.45,245.72a26.43,26.43,0,0,0-19.42-8H383.9V182.91q0-52.53-37.68-90.22T256,55q-52.55,0-90.22,37.69t-37.69,90.22v54.82H119a27.28,27.28,0,0,0-27.41,27.41V429.59A27.28,27.28,0,0,0,119,457H393a27.28,27.28,0,0,0,27.41-27.41V265.14A26.4,26.4,0,0,0,412.45,245.72Zm-83.36-8H182.91V182.91q0-30.27,21.41-51.68T256,109.82q30.27,0,51.68,21.41t21.41,51.68Z">
                    </div>
                </div>
            </div>
        </div>
        <div class="px8 pt8 thread-add-error-container none">
            <div class="flex">
                <svg class="size14 mr4" style="min-width: 14px; margin-top: 1px" fill="rgb(228, 48, 48)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M501.61,384.6,320.54,51.26a75.09,75.09,0,0,0-129.12,0c-.1.18-.19.36-.29.53L10.66,384.08a75.06,75.06,0,0,0,64.55,113.4H435.75c27.35,0,52.74-14.18,66.27-38S515.26,407.57,501.61,384.6ZM226,167.15a30,30,0,0,1,60.06,0V287.27a30,30,0,0,1-60.06,0V167.15Zm30,270.27a45,45,0,1,1,45-45A45.1,45.1,0,0,1,256,437.42Z"/></svg>
                <span class="error fs13 bold no-margin thread-add-error"></span>
            </div>
        </div>
        <div class="px8 py8">
            <label for="subject" class="flex align-center bold forum-color mb4">{{ __('Title') }}<span class="error ml4 none">*</span></label>
            <input type="hidden" class="required-text" value="{{ __('Title field is required') }}">
            <input type="text" id="subject" name="subject" class="styled-input" required autocomplete="off" placeholder='{{ __("Be specific and imagine you’re asking a question to another person") }}'>
        </div>
        <div>
            <label for="content" class="flex align-center bold forum-color mx8 mb4">{{ __('Content') }}<span class="error ml4 none">*</span></label>
            <input type="hidden" class="required-text" value="{{ __('Content field is required') }}">
            <textarea name="content" id="content"></textarea>
            <script>
                var simplemde = new SimpleMDE({
                    placeholder: '{{ __("Add a discussion content here..") }}',
                    hideIcons: ["guide", "heading", "link", "image"],
                    spellChecker: false,
                });
                simplemde.value();

                function htmlDecode(input){
                    var e = document.createElement('textarea');
                    e.innerHTML = input;
                    // handle case of empty input
                    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
                }
            </script>
        </div>
        <div class="thread-add-media-section px8">
            <div class="thread-add-media-error px8 my8">
                <p class="error tame-image-type none">* {{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported') }}.</p>
                <p class="error tame-image-limit none">* {{ __('You could only upload 20 images max per post') }}.</p>
                <p class="error tame-video-type none">* {{ __('Only .MP4, .WEBM, .MPG, .MP2, .MPEG, .MPE, .MPV, .OGG, .M4P, .M4V, .AVI video formats are supported') }}.</p>
                <p class="error tame-video-limit none">* {{ __('You could only upload 4 videos max per post') }}.</p>
            </div>
            <div class="flex align-end">
                <div class="flex">
                    <div class="flex align-center thread-add-button-hover-style mr4 relative">
                        <svg class="size24" style="margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M395.3,76H116.72C94.26,76,76,95.47,76,119.46V392.59c0,24,18.26,43.41,40.72,43.41H395.3c22.46,0,40.7-19.45,40.7-43.41V119.46C436,95.47,417.76,76,395.3,76Zm-86.5,64.63c21.71,0,39.32,18.79,39.32,42s-17.61,42-39.32,42-39.33-18.79-39.33-42S287.07,140.63,308.8,140.63Zm73.73,255.22H135.1c-10.86,0-15.7-8.38-10.81-18.73l67.5-142.61c4.89-10.34,14.21-11.26,20.81-2.06l67.87,94.61c6.6,9.21,18.13,10,25.77,1.75l16.6-17.94c7.63-8.24,18.87-7.22,25.1,2.27l43,65.51C397.14,388.15,393.4,395.85,382.53,395.85Z" style="fill:#010002"/></svg>
                        <p class="no-margin fs13">Photos</p>
                        <input type="file" name="images[]" id="thread-photos" class="thread-add-file-input" multiple accept=".jpg,.jpeg,.png,.bmp,.gif">
                    </div>
                    <div class="flex align-center thread-add-button-hover-style relative">
                        <svg class="size24" style="margin-right: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,56C145.52,56,56,145.52,56,256s89.52,200,200,200,200-89.52,200-200S366.48,56,256,56Zm93.31,219.35L207.37,356.81a19.39,19.39,0,0,1-28.79-16.94V172.13a19.41,19.41,0,0,1,28.79-16.94l141.94,86.29C362.53,248.9,362.53,268,349.31,275.35Z"/></svg>
                        <p class="no-margin fs13">Videos</p>
                        <input type="file" name="videos[]" id="thread-videos" class="thread-add-file-input" multiple accept=".mp4,.webm,.mpg,.mp2,.mpeg,.mpe,.mpv,.ogg,.mp4,.m4p,.m4v,.avi">
                    </div>
                </div>
                <div class="progress-bar-box none full-width pb4" style="margin-left: 18px">
                    <input type="hidden" class="upload-finish-text" value="{{ __('Upload finishes ! Please wait') }}..">
                    <input type="hidden" class="uploading-text" value="{{ __('Uploading media to your discussion') }}..">
                    <p class="no-margin fs11 bold bblack mb2 text-above-progress-bar">{{ __('Uploading media to your discussion') }}..</p>
                    <div class="progress-bar-container relative flex align-center">
                        <span class="fs12 bold progress-bar-percentage"><span class="progress-bar-percentage-counter">0</span>%</span>
                        <div class="progress-bar flex align-center justify-center"></div>
                    </div>
                </div>
            </div>
            <!-- the following div will be used to clone uploaded images -->
            <div class="thread-add-uploaded-media relative none thread-add-uploaded-media-projection-model">
                <img src="" class="thread-add-uploaded-image move-to-middle none" alt="">
                <div class="close-thread-media-upload x-close-container-style remove">
                    <span class="x-close unselectable">✖</span>
                </div>
                <div class="thread-add-video-indicator full-center none">
                    <svg class="size36" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 271.95 271.95"><path d="M136,272A136,136,0,1,0,0,136,136,136,0,0,0,136,272ZM250.2,136A114.22,114.22,0,1,1,136,21.76,114.35,114.35,0,0,1,250.2,136ZM112.29,205a21.28,21.28,0,0,0,8.24,1.66,21.65,21.65,0,0,0,15.34-6.37l48.93-49a21.75,21.75,0,0,0,0-30.77L135.84,71.64a21.78,21.78,0,0,0-15.4-6.37,20.81,20.81,0,0,0-8.15,1.66A21.58,21.58,0,0,0,99,87v97.91A21.6,21.6,0,0,0,112.29,205Zm8.5-116.42V87l49,48.95-48.95,49Z"/></svg>
                </div>
                <input type="hidden" class="uploaded-media-index" value="-1">
                <input type="hidden" class="uploaded-media-genre" value="">
            </div>
            <div id="thread-uploads-wrapper" class="thread-add-uploaded-medias-container flex my4">
                <input type="hidden" class="uploaded-images-counter" value="0" autocomplete="off">
                <input type="hidden" class="uploaded-videos-counter" value="0" autocomplete="off">
            </div>
        </div>
        <div class="mb8 px8 flex">
            <input type="hidden" class="successful-share" value="{{ __('Your discussion is shared successfully to your timeline') }}">
            <input type="hidden" class="message-ing" value="{{ __('Sharing..') }}">
            <input type="hidden" class="message-no-ing" value="{{ __('Share') }}">
            <button class="thread-add-share">
                {{ __('Share') }}
            </button>
        </div>
        <style>
            .CodeMirror,
            .CodeMirror-scroll {
                max-height: {{ $editor_height }}px;
                min-height: {{ $editor_height }}px;
                border-radius: 0;
                border-left: none;
                border-right: none;
                border-color: #b9b9b9;
            }
            .CodeMirror-scroll:focus {
                border-color: #64ceff;
                box-shadow: 0 0 0px 3px #def2ff;
            }
            .editor-toolbar {
                padding: 0 4px;
                opacity: 0.8;
                height: 38px;
                border-radius: 0;
                border-left: none;
                border-right: none;
                border-top-color: #b9b9b9;
                background-color: rgb(244, 244, 244);

                display: flex;
                align-items: center;
            }
            .editor-toolbar .fa-arrows-alt {
                margin-left: auto;
                margin-right: 10px;
            }
            .editor-statusbar {
                border-radius: 0px;
            }
        </style>
    </div>
</div>