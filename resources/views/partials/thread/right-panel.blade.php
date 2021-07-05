<div>
    <div>
        <div class="right-panel-header-container space-between">
            <div class="flex align-center">
                <div class="small-image-2 sprite sprite-2-size author17-icon mr4"></div>
                <p class="no-margin bold unselectable">Author</p>
            </div>
            <a href="{{ route('user.profile', ['user'=>$thread_owner->username]) }}" class="link-style">profile</a>
        </div>
        <div class="relative us-user-media-container mx8">
            <div class="us-cover-container full-center" style="height: 90px">
                <img src="{{ $thread_owner->cover }}"  class="us-cover" alt="">
            </div>
            <div class="us-after-cover-section flex" style="margin-left: 20px; margin-top: -40px">
                <div style="padding: 6px; background-color: white;" class="rounded">
                    <a href="{{ route('user.profile', ['user'=>$thread_owner->username]) }}">
                        <div class="image-size-1 full-center rounded hidden-overflow">
                            <img src="{{ $thread_owner->avatar }}" class="handle-image-center-positioning" alt="">
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
                        <img src='{{ asset("assets/images/icons/$ustatus.png") }}' class="tiny-image mr4" alt="">
                        <p class="fs12 no-margin">@if(Cache::has('user-is-online-' . $thread_owner->id)) Online @else Offline @endif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="index-right-panel-container border-box mt8">
            <div class="index-right-panel">
                <p class="bold no-margin mb8 fs15 blue">{{ __("Not the") }} {{ $thread_type }} {{ __("you're looking for ?") }}</p>
                <p class="fs12"><span class="bold mr4">+</span>{{ __("Use the") }} <a href="" class="blue bold no-underline">{{ __('search feature') }}</a> {{ __("by specifying the forum and category (or select [all] option to search in all forums and categories)") }}.</p>
                <p class="fs12"><span class="bold mr4">+</span>{{ __("Or") }} <a href="{{ route('thread.add', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="blue bold no-underline">{{ __("create your own thread") }}</a></p>
            </div>
        </div>
        <div class="index-right-panel-container border-box mt8">
            <div class="index-right-panel toggle-box">
                <div class="flex align-center space-between">
                    <p class="bold no-margin unselectable blue">{{ __('Posting Guidelines') }}</p>
                    <a href="" class="link-style fs12 toggle-container-button">see more</a>
                </div>
                <p class="fs12 my8"><strong>1. {{ __('Treat people with respect if you want to be respected') }}.</strong></p>
                <p class="fs12 my8"><strong>2.</strong> {{ __('Stick to the topic when responding to posts created by others') }}.</p>
                <p class="fs12 my8"><strong>3.</strong> {{ __('When creating your own post in the form of a topic, please choose the appropriate forum and give it a clear and concise title') }}.</p>
                <div class="toggle-container">
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