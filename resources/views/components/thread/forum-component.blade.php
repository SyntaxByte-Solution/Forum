<tr class="forum-component-container">
    <td class="flex justify-center forum-component-icon-section-width justify-center">
        <svg class="forum-component-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            {!! $forum->icon !!}
        </svg>
    </td>
    <td class="forum-component-forum-section-width">
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="no-underline bold blue no-margin fs17 mb2">{{ __($forum->forum) }}</a>
        <p class="no-margin fs13">{{ __($forum->description) }}</p>
    </td>
    <td class="full-center fs15 bold bblack forum-component-threads-section-width">
        {{ $threads_count }}
    </td>
    <td class="full-center fs15 bold bblack forum-component-posts-section-width">
        {{ $posts_count }}
    </td>
    <td class="last-reply-container forum-component-last-reply-section-width">
        @if($last_thread)
        <a href="{{ $last_thread->link }}" class="block no-underline fs12 bold no-margin mb2" style="color: #236499">{{ $last_thread->slice }}</a>
        <div class="flex align-center">
            <span class="fs12" style="margin-top: 1px">{{ __('by') }} :</span>
            <div class="relative ml4 user-profile-card-box">
                <input type="hidden" class="user-card-container-index"> <!-- value will be initialized at run time by js, to identify each container with incremented index (go to depth.js file) -->
                <a href="{{ $last_thread->user->profilelink }}" class="no-underline fs12 bblack bold user-profile-card-displayer">{{ $last_thread->user->username }}</a>
            </div>
        </div>
        <div class="relative height-max-content">
            <p class="no-margin fs11 flex align-center tooltip-section gray" style="margin-top:1px">{{__('Shared') . ': ' . $at_hummans }}</p>
            <div class="tooltip tooltip-style-1">
                {{ $at }}
            </div>
        </div>
        @else
        <em class="fs12">{{ __('No discussions for the moment') }} !</em>
        @endif
    </td>
</tr>