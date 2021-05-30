<tr>
    <td>
        <div class="flex">
            <div>
                <img src="{{ asset($forum_icon) }}" class="forum-table-row-image" alt="forum icon">
            </div>
            <div class="flex">
                <div class="forum-category-icon-container">
                    <img src="" class="forum-category-icon" alt="">
                </div>
                <div>
                    <h2 class="forum-category-link-header"><a href="{{ route('forum.misc', ['forum'=>$forum_slug]) }}" class="forum-style-link">{{ $forum_forum }}</a></h2>
                    <p class="forum-category-description">{{ $forum_description }}</p>
                </div>
            </div>
        </div>
    </td>
    <!-- number of both discussions and questions -->
    <td class="fs13">{{ $threads_count }}</td>
    <!-- number of views of both discussions and questions -->
    <td class="fs13">{{ $posts_count }}</td>
    <td>
        @if($last_thread_title)
        <div>
            <a href="{{ $last_thread_link }}" class="block forum-style-link fs11 bold">{{ $last_thread_title }}</a>
            <div class="form-column-line-separator"></div>
            <p class="no-margin fs11">by <a href="" class="bold forum-style-link fs11">{{ $last_thread_owner_username }}</a></p>
            <p class="fs11 no-margin" style="margin-top: 3px">{{ $last_thread_date }}</p>
        </div>
        @else
            <p class="gray fs11">No threads yet</p>
        @endif
    </td>
</tr>