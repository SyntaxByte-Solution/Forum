<tr>
    <td>
        <div class="flex">
            <div class="forum-category-icon-container">
                <img src='{{ asset($announcement_icon) }}' class="forum-table-row-image" alt="">
            </div>
            <div>
                <h2 class="table-row-title"><a href="{{ $thread_url }}" class="forum-style-link">{{ $announcement_title }}</a></h2>
                <div class="flex align-center">
                    <p class="no-margin fs11 flex align-center">by [<a href="" class="fs12 black-link">{{ $thread_owner }}</a>] <span class="fs11" style="margin: 0 5px">>></span> {{ $at }}</p>
                </div>
            </div>
        </div>
    </td>
    <td class="fs13">{{ $replies }}</td>
    <td class="fs13">{{ $views }}</td>
    <td>
        <p class="no-margin fs11">announced by <a href="" class="bold forum-style-link fs11">{{ $thread_owner }} </a></p>
        <p class="fs11 no-margin" style="margin-top: 3px">{{ $thread_date }} </p>
        @if($last_post_content)
        <div>
            <a href="{{ $last_post_url }}" class="block forum-style-link fs11 bold">{{ $last_post_content }}</a>
            <div class="form-column-line-separator"></div>
            <p class="no-margin fs11">by <a href="" class="bold forum-style-link fs11">{{ $last_post_owner_username }} </a></p>
            <p class="fs11 no-margin" style="margin-top: 3px">{{ $last_post_date }} </p>
        </div>
        @else
        <div>
            <p class="no-margin fs11">{{ __('No posts yet') }}</p>
        </div>
        @endif
    </td>
</tr>