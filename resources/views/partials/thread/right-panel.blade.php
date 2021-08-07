<div>
    <div>
        <div class="right-panel-header-container space-between">
            <div class="flex align-center">
                <svg class="small-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 397.15 397.15"><path d="M390.88,12.37c-4.14-4.15-10.13-6.25-17.78-6.25-26.78,0-70.16,26-93.64,41.55l-1.91,1.27-5.28,41.68-14-28.34-4.81,3.52a763.05,763.05,0,0,0-85.75,73.26c-4.62,4.62-9.16,9.31-13.5,13.94l-.93,1-18.7,82.35-9.86-49.17L118,196.36c-3.84,5.26-7.46,10.53-10.78,15.65l-.62,1-8,62.92L86.17,250.56,82.63,263.1c-4.3,15.28-4.5,28.32-.67,38.5l-80,80a5.52,5.52,0,0,0-1.55,6.22A5.21,5.21,0,0,0,5.24,391a6.85,6.85,0,0,0,2.46-.49l36.94-14a15.23,15.23,0,0,0,5.11-3.41l49.61-52.77A44.27,44.27,0,0,0,118,324h0a82.94,82.94,0,0,0,22.18-3.4l12.54-3.54-25.33-12.49,62.92-8,.95-.62c5.12-3.31,10.39-6.94,15.66-10.79l9.19-6.7-49.17-9.86,82.34-18.71,1-.92c4.64-4.35,9.33-8.89,13.94-13.5,35.17-35.17,70.11-78.39,95.85-118.59l3-4.7L338.24,100,373,95.59l1.23-2.2C397.46,51.81,403.07,24.56,390.88,12.37Z"/></svg>
                <p class="no-margin bold unselectable">Author</p>
            </div>
            <a href="{{ route('user.profile', ['user'=>$thread_owner->username]) }}" class="link-style">profile</a>
        </div>
        <div class="relative us-user-media-container mx8 my8">
            <div class="us-cover-container full-center" style="height: 90px">
                <img src="{{ $thread_owner->cover }}"  class="us-cover" alt="">
            </div>
            <div class="us-after-cover-section flex" style="margin-left: 20px; margin-top: -40px">
                <div style="padding: 6px; background-color: white;" class="rounded">
                    <a href="{{ route('user.profile', ['user'=>$thread_owner->username]) }}">
                        <div class="image-size-1 full-center rounded hidden-overflow">
                            <img src="{{ $thread_owner->sizedavatar(100) }}" class="handle-image-center-positioning" alt="">
                        </div>
                    </a>
                </div>
                <div class="ms-profile-infos-container" style="margin-top: 45px">
                    <h4 class="no-margin forum-color flex align-center">
                        {{ $thread_owner->firstname . ' ' . $thread_owner->lastname }}
                    </h4>
                    <p class="fs12 bold no-margin">[{{ $thread_owner->username }}]</p>
                </div>
            </div>
            <div class="my8">
                <p class="fs12 gray no-margin">Join Date: <span class="black">{{ (new \Carbon\Carbon($thread_owner->created_at))->toDayDateTimeString() }}</span></p>
                <div class="flex my8">
                    @php
                        $ustatus = Cache::has('user-is-online-' . $thread_owner->id) ? 'active' : 'inactive';
                    @endphp
                    <p class="fs12 gray no-margin mr4">Status:</p>
                    <div class="flex align-center">
                        <svg class="tiny-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            @if($ustatus == 'active')
                            <path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#25BD54"/>
                            @else
                            <path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#919191"/>
                            @endif
                        </svg>
                        <p class="fs12 no-margin">@if(Cache::has('user-is-online-' . $thread_owner->id)) Online @else Offline @endif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="border-box mt8">
            <div>
                <div class="right-panel-header-container">
                    <p class="bold no-margin fs15 blue">{{ __("Not the") }} {{ $thread_type }} {{ __("you're looking for ?") }}</p>
                </div>
                <div class="px8 mx8">
                    <p class="fs12"><span class="bold mr4">+</span>{{ __("Use the") }} <a href="" class="blue bold no-underline">{{ __('search feature') }}</a> {{ __("by specifying the forum and category (or select [all] option to search in all forums and categories)") }}.</p>
                    <p class="fs12"><span class="bold mr4">+</span>{{ __("Or") }} <a href="{{ route('thread.add') }}" class="blue bold no-underline">{{ __("create your own thread") }}</a></p>
                </div>
            </div>
        </div>
        <div class="mt8 py8">
            <div class="toggle-box">
                <div class="right-panel-header-container space-between">
                    <div class="flex align-center">
                        <p class="bold no-margin fs15 blue">{{ __('Posting Guidelines') }}</p>
                    </div>
                    <a href="" class="link-style fs12 toggle-container-button">see more</a>
                </div>
                <div class="mx8 px8">
                    <p class="fs12 my8"><strong>1. {{ __('Treat people with respect if you want to be respected') }}.</strong></p>
                    <p class="fs12 my8"><strong>2.</strong> {{ __('Stick to the topic when responding to posts created by others') }}.</p>
                    <p class="fs12 my8"><strong>3.</strong> {{ __('When creating your own post in the form of a topic, please choose the appropriate forum and give it a clear and concise title') }}.</p>
                    <p class="fs12 my8"><strong>4.</strong> {{ __('Due to the multinational nature of the forum, you are free to use any language(more preferable arabic(or darija =D), english or french). If you’d like to use a different language (by way of an external link, for example), consider providing a translation of the relevant portion in your topic/reply. It could even be a machine translation (Google Translate, for example), as long as the point comes across correctly') }}.</p>
                    <p class="fs12 my8"><strong>5.</strong> {{ __('When creating your own post in the form of a topic, please choose the appropriate forum and give it a clear and concise title') }}.</p>
                    <p class="fs12 my8"><strong>6.</strong> {{ __('Before creating a new topic, or asking a new question, consider using the Search function to see whether it has already been addressed. If it has, post your new topic only if the previous thread has already been closed. Note that if you believe that your topic is related to an existing one but with significant differences, feel free to create the new topic (but make sure to address the difference)') }}.</p>
                    <div class="flex">
                        <a href="/guidelines" class="move-to-right link-style">go to guidelines page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>