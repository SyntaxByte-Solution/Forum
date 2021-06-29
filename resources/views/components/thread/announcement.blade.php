<tr>
    <td>
        <div class="flex">
            <div class="forum-category-icon-container">
                <img src='{{ asset($announcement_icon) }}' class="forum-table-row-image" alt="">
            </div>
            <div>
                <h2 class="table-row-title"><a href="{{ $announcement->link }}" class="forum-style-link">{{ $announcement->slice }}</a></h2>
                <div class="flex align-center">
                    <p class="no-margin fs11 flex align-center">by [<a href="{{ route('user.profile', ['user'=>$owner->username]) }}" class="fs12 black-link">{{ $owner->username }}</a>] <span class="fs11" style="margin: 0 5px">>></span> {{ $at }}</p>
                </div>
            </div>
        </div>
    </td>
    <td class="fs13 bold" style="width: 100px">
        <a href="{{ $forum_link }}" class="link-path">{{ $forum_name }}</a>
    </td>
    <td class="fs13">{{ $views }}</td>
    <td style="width: 180px;" class="relative">
        @if($last_post_content)
        <div>
            <a href="{{ $last_post_url }}" class="block forum-style-link fs12 bold">{{ $last_post_content }}</a>
            <p class="no-margin fs11 grey">by <a href="{{ route('user.profile', ['user'=>$last_post_owner_username]) }}" class="bold forum-style-link fs11">{{ $last_post_owner_username }} </a></p>
            <div class="form-column-line-separator"></div>
            <p class="fs11 no-margin" style="margin-top: 3px">at: {{ $last_post_date }} </p>
        </div>
        @else
        <div>
            <p class="no-margin fs11">{{ __('The admin close replies for this announcement') }}</p>
        </div>
        @endif
    </td>
</tr>