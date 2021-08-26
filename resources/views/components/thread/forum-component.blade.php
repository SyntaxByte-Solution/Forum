<tr class="forum-component-container">
    <td class="flex justify-center forum-component-icon-section-width justify-center">
        <svg class="forum-component-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            {!! $forum->icon !!}
        </svg>
    </td>
    <td class="forum-component-forum-section-width">
        <a href="{{ route('forum.all.threads', ['forum'=>$forum->slug]) }}" class="no-underline bold blue no-margin fs17 mb2">{{ $forum->forum }}</a>
        <p class="no-margin fs13">{{ $forum->description }}</p>
    </td>
    <td class="full-center fs15 bold forum-component-threads-section-width">
        {{ $threads_count }}
    </td>
    <td class="full-center fs15 bold forum-component-posts-section-width">
        {{ $posts_count }}
    </td>
    <td class="last-reply-container forum-component-last-reply-section-width">
        
    </td>
</tr>