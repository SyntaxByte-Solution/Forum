<tr>
    <input type="hidden" class="thread-type" value="{{ $thread_type }}">
    <td>
        <div class="flex space-between">
            <div class="flex">
                <div>
                    <div>
                        <a href="{{ route('forum.misc', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ $forum->forum }} > </a>
                        <a href="{{ route('category.misc', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="fs11 black-link">{{ $category->category }}</a>
                    </div>
                    <div class="flex">
                        <img src='{{ asset($thread_icon) }}' class="small-image mr8" style="margin-top: 1px" alt="">
                        <p class="fs15 bold no-margin"><a href="{{ $thread_url }}" class="forum-style-link">{{ $thread_title }}</a></p>
                    </div>
                    <div class="flex align-center">
                        <p class="no-margin fs11 flex align-center">posted at <span class="fs11" style="margin: 0 5px">>></span> {{ $at }}</p>
                    </div>
                </div>    
            </div>
            @can('update', $thread)
            <div style="margin: 0 4px">
                <div>
                    <a href="{{ $edit_link }}" target="_blank" class="table-row-button black-sprite-icon sprite-size bedit-icon"></a>
                </div>
                <div>
                    <a href="{{ $thread_url }}?action=thread-delete" target="_blank" class="table-row-button black-sprite-icon sprite-size bdelete-icon"></a>
                </div>
            </div>
            @endcan
        </div>
    </td>
    <td class="fs13">{{ $replies }}</td>
    <td class="fs13">{{ $views }}</td>
    <td style="width: 160px;">
        @if($hasLastPost)
        <div>
            <a href="{{ $last_post_url }}" class="block forum-style-link fs11 bold">{{ $last_post_content }}</a>
            <div class="form-column-line-separator"></div>
            <p class="no-margin fs11">by <a href="" class="bold forum-style-link fs11">{{ $last_post_owner_username }}</a></p>
            <p class="fs11 no-margin" style="margin-top: 3px">{{ $last_post_date }} </p>
        </div>
        @else
            <p class="no-margin fs11">{{ __('No posts yet') }}</p>
        @endif
    </td>
</tr>