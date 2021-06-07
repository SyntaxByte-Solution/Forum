<tr @can('update', $resource) style="background-color: rgb(240, 250, 255)" @endcan >
    <input type="hidden" class="thread-type" value="{{ $thread_type }}">
    <td>
        <div class="flex space-between">
            <div class="flex">
                <div class="forum-category-icon-container">
                    <img src='{{ asset($thread_icon) }}' class="forum-table-row-image" alt="">
                </div>
                <div>
                    <h2 class="table-row-title"><a href="{{ $thread_url }}" class="forum-style-link">{{ $thread_title }}</a></h2>
                    <div class="flex align-center">
                        <p class="no-margin fs11 flex align-center">by [<a href="" class="fs12 black-link bold">{{ $thread_owner }}</a>] <span class="fs11" style="margin: 0 5px">>></span> {{ $at }} [{{ $at_full }}]</p>
                    </div>
                </div>    
            </div>
            @can('update', $resource)
                <div>
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
    <td class="fs13"><a href="" class="link-without-underline-style">{{ $category }}</a></td>
    <td class="fs13">{{ $replies }}</td>
    <td class="fs13">{{ $views }}</td>
    <td>
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