<tr>
    <td>
        <div class="flex">
            <div class="forum-category-icon-container">
                <img src='{{ asset($thread_icon) }}' class="forum-table-row-image" alt="">
            </div>
            <div>
                <h2 class="table-row-title"><a href="/{{ request('forum')->slug }}/discussions/{{ $thread_id }}" class="forum-style-link">{{ $thread_title }}</a></h2>
                <div class="flex align-center">
                    <p class="no-margin fs11 flex align-center">by [<a href="" class="fs12 black-link">{{ $thread_owner }}</a>] <span class="fs11" style="margin: 0 5px">>></span> {{ $at }}</p>
                </div>
            </div>
        </div>
    </td>
    <td class="fs13">{{ $category }}</td>
    <td class="fs13">{{ $replies }}</td>
    <td class="fs13">{{ $views }}</td>
    <td>
        @if($hasLastPost)
        <div>
            <a href="{{ $thread_url }}" class="block forum-style-link fs11 bold">{{ $last_post_content }}</a>
            <div class="form-column-line-separator"></div>
            <p class="no-margin fs11">by <a href="" class="bold forum-style-link fs11">{{ $last_post_owner_username }}</a></p>
            <p class="fs11 no-margin" style="margin-top: 3px">{{ $last_post_date }} </p>
        </div>
        @else
            <p class="no-margin fs11">{{ __('No posts yet') }}</p>
        @endif
    </td>
</tr>