<tr>
    <input type="hidden" class="thread-type" value="{{ $thread_type }}">
    <td>
        <div class="flex">
            <div class="mr8">
                <a href="" class="up-icon thread-vote-button thread-up-vote"></a>
                <p class="bold fs17 no-margin text-center">0</p>
                <a href="" class="down-icon thread-vote-button thread-down-vote"></a>
            </div>
            <div class="flex">
                <div>
                    <div class="flex align-center">
                        <img src="{{ asset('assets/images/icns/' . $forum->icon) }}" class="small-image-2 mr4" alt="">
                        <div class="flex align-center">
                            <a href="{{ route('forum.misc', ['forum'=>$forum->slug]) }}" class="fs11 black-link">{{ $forum->forum }}</a>
                            <span class="mx4 fs13">▸</span>
                            <a href="{{ route('category.misc', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="fs11 black-link">{{ $category->category }}</a>
                        </div>
                    </div>
                    <div class="flex align-center my4">
                        <p class="fs15 bold no-margin"><a href="{{ $thread_url }}" class="forum-style-link dark-blue">{{ $thread_title }}</a></p>
                    </div>
                    <div class="fs15 my8">
                        <a href="{{ $thread_url }}" class="black no-underline">{{ $thread_content }}</a>
                    </div>
                    <div class="simple-half-line-separator"></div>
                    <div class="flex align-center">
                        <div class="flex align-center" style="margin-top: 2px">
                            <p class="no-margin fs11 flex align-center">posted by</p>
                            <a href="" class="black no-underline bold fs12 mx4">{{ $thread_owner }}</a>
                            <p class="no-margin mr4 fs11 flex align-center">{{__('at')}}: </p>
                            <div class="relative">
                                <p class="no-margin fs11 flex align-center tooltip-section">{{ $at }}</p>
                                <div class="tooltip tooltip-style-2">
                                    {{ $at_hummans }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="flex flex-column move-to-right">
                <a href="" class="fs11 no-margin link-style">{{ $type }}</a>
                @can('update', $thread)
                <div style="margin: 0 4px" class="move-to-right">
                    <div>
                        <a href="{{ $edit_link }}" target="_blank" class="table-row-button black-sprite-icon sprite-size bedit-icon"></a>
                    </div>
                    <div>
                        <a href="{{ $thread_url }}?action=thread-delete" target="_blank" class="table-row-button black-sprite-icon sprite-size bdelete-icon"></a>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </td>
    <td class="fs13" style="width: 106px">
        <div class="flex align-center">
            <img src="{{ asset('assets/images/icons/gray-eye.png') }}" class="small-image-2 mr4" alt="">
            <p class="no-margin fs12">{{ $views }} views</p>
        </div>
        <div class="flex align-center">
            <img src="{{ asset('assets/images/icons/gray-reply.png') }}" class="small-image-2 mr4" alt="">
            <p class="no-margin fs12">{{ $replies }} replies</p>
        </div>
    </td>
    <td style="width: 180px;" class="relative">
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
        <div class="absolute mr8 bottom0 right0">
            <a href="" class="flex align-center gray link-style">
                <img src="{{ asset('assets/images/icons/gray-reply.png') }}" class="small-image-2 mr4" alt="">
                <p>Reply</p>
            </a>
        </div>
    </td>
</tr>