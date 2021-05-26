<tr>
    <td>
        <div class="flex">
            <div class="forum-category-icon-container">
                <img src='{{ asset("assets/images/icns/discussions.png") }}' class="forum-table-row-image" alt="">
            </div>
            <div>
                <h2 class="table-row-title"><a href="/{{ request('forum')->slug }}/discussions/{{ $discussion_id }}" class="forum-style-link">{{ $discussion_title }}</a></h2>
                <div class="flex align-center">
                    <p class="no-margin fs11 flex align-center">by [<a href="" class="fs12 black-link">{{ $thread_owner }}</a>] <span class="fs11" style="margin: 0 5px">>></span> {{ $at }}</p>
                </div>
            </div>
        </div>
    </td>
    <td class="fs13">{{ $replies }}</td>
    <td class="fs13">{{ $views }}</td>
    <td>
        <div>
            <p class="no-margin fs11">by <a href="" class="bold forum-style-link fs11">Hostname47 </a></p>
            <p class="fs11 no-margin" style="margin-top: 3px">Wed May 19, 2021 11:13 pm </p>
        </div>
    </td>
</tr>