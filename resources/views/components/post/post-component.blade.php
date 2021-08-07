<div class="relative post-container resource-container" id="@if($post->ticked){{'ticked-post'}}@endif">
    <input type="hidden" class="post-id" value="{{ $post->id }}">
    <input type="hidden" class="likable-type" value="post">
    <input type="hidden" class="likable-id" value="{{ $post->id }}">
    <div class="absolute full-shadowed br6" style="z-index: 1">
        @can('destroy', $post)
        <div class="full-center full-width full-height">
            <div class="flex align-center">
                <input type="button" class="simple-white-button pointer delete-post delete-from-outside-viewer" value="Delete">
                <a href="" class="simple-link close-shadowed-view-button" style="text-decoration: none; margin-left: 6px; font-size: 10px">CANCEL</a>
                <input type="hidden" class="post-id" value="{{ $post->id }}">
                <input type="hidden" class="button-ing-text" value="{{ __('Deleting') }}..">
            </div>
        </div>
        @endcan
    </div>
    <div class="show-post-container fs11">
        <div class="line-separator"></div>
        {{ __('Reply hidden') }} [<a href="" class="show-post show-post-from-outside-viewer black-link bold">{{ __('click here to show it') }}</a>]
        <div class="line-separator"></div>
    </div>
    <div class="flex post-main-component relative" style="@if($post->ticked) border-color: #28882678; @endif">
        <div id="{{ $post->id }}" class="absolute" style="top: -65px"></div>
        <div class="vote-section post-vs relative">
            <div class="vote-box relative">
                <input type="hidden" class="votable-id" value="{{ $post->id }}">
                <input type="hidden" class="votable-type" value="post">
                <div class="informer-message-container absolute zi1" style="left: calc(100% + 8px); top: 10px;">
                    <div class="left-middle-triangle"></div>
                    <div class="flex align-center">
                        <p class="informer-message"></p>
                        <img src="http://127.0.0.1:8000/assets/images/icons/wx.png" class="remove-informer-message-container rounded pointer" alt="">
                    </div>
                </div>
                <div class="pointer @auth votable-up-vote @endauth @guest login-signin-button @endguest">
                    <div class="small-image sprite sprite-2-size vote-icon @upvoted($post, 'App\Models\Post') upvotefilled20-icon @else upvote20-icon @endupvoted"></div>
                </div>
                <p class="bold fs16 no-margin text-center votable-count">{{ $post_votes }}</p>
                <div class="pointer @auth votable-down-vote @endauth @guest login-signin-button @endguest">
                    <div class="small-image sprite sprite-2-size vote-icon @downvoted($post, 'App\Models\Post') downvotefilled20-icon @else downvote20-icon @enddownvoted"></div>
                </div>
            </div>

            <div class="mt8 relative informer-box tick-post-container">
                @can('update', $post->thread)
                <div class="informer-message-container absolute zi1" style="left: 126%; top: -10px">
                    <div>
                        <p class="informer-message"></p>
                    </div>
                </div>
                <a href="" class="hover-informer-display-element">
                    <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="size20 green-tick @if(!$post->ticked) none @endif" alt="">
                    <img src="{{ asset('assets/images/icons/grey-tick.png') }}" class="size20 grey-tick @if($post->ticked) none @endif" alt="">
                </a>
                <input type="hidden" value="{{ $post->id }}" class="post-id">
                @else
                    @if($post->ticked)
                        <div class="sprite sprite-2-size size20 greentick20-icon" alt="{{ __('This is the best reply') }}"></div>
                    @endif
                @endcan
            </div>
        </div>
        <div class="post-main-section" style="@if($post->ticked) background-color: #e1ffe438; @endif">
            <div class="flex align-center space-between px8 py8">
                <div>
                    <div class="no-margin fs12 gray">
                        <div class="inline-block relative">
                            <div class="flex">
                                <div class="relative">
                                    <a href="{{ route('user.profile', ['user'=>$post->user->username]) }}" class="button-with-container forum-style-link fs12 flex">
                                        <img src="{{ $post_owner->sizedavatar(36) }}" class="size28 mr4 rounded" alt="">
                                    </a>
                                    
                                    @include('partials.user-profile-card', ['user'=>$post_owner])
                                </div>
                                <div>
                                    <a href="{{ route('user.profile', ['user'=>$post->user->username]) }}" class="bold link-path">{{ $post_owner_username }}</a>
                                    <span class="relative block">
                                        <span class="tooltip-section">{{ __('replied') }}: {{ $post_date }}</span>
                                        <span class="tooltip tooltip-style-1">{{ $post_created_at }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span class="@if(!$post->is_updated) none @endif post-updated-date">({{ __('edited') }})</span>
                    </div>
                </div>
                <div class="flex align-center relative height-max-content">
                    <div class="thread-react-hover @auth like-resource like-resource-from-outside-viewer @endauth @guest login-signin-button @endguest">
                        <input type="hidden" class="likable-id" value="{{ $post->id }}">
                        <input type="hidden" class="likable-type" value="post">
                        <div class="small-image-2 sprite sprite-2-size like-icon @auth @if($post->liked_by(auth()->user())) resource17-like-ricon @else resource17-like-gicon @endif @endauth @guest resource17-like-gicon @endguest"></div>
                        <p class="no-margin mx4 fs13 resource-likes-counter">{{ $post->likes->count() }}</p>
                    </div>
                    <p class="best-reply-ticket unselectable @if(!$post->ticked) none @endif">{{ __('BEST REPLY') }}</p>
                    <div>
                        <svg class="pointer button-with-suboptions size20 mr4" style="margin-top: 1px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                        <div class="suboptions-container suboptions-container-right-style">
                            <div class="simple-suboption hide-post hide-post-from-outside-viewer flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.03 490.03"><path d="M435.67,54.31a18,18,0,0,0-25.5,0l-64,64c-79.3-36-163.9-27.2-244.6,25.5C41.47,183,5,232.31,3.47,234.41a18.16,18.16,0,0,0,.5,22c34.2,42,70,74.7,106.6,97.5l-56.3,56.3a18,18,0,1,0,25.4,25.5l356-355.9A18.11,18.11,0,0,0,435.67,54.31ZM200.47,264a46.82,46.82,0,0,1-3.9-19,48.47,48.47,0,0,1,67.5-44.6Zm90.2-90.1a84.37,84.37,0,0,0-116.6,116.6L137,327.61c-32.5-18.8-64.5-46.6-95.6-82.9,13.3-15.6,41.4-45.7,79.9-70.8,66.6-43.4,132.9-52.8,197.5-28.1Zm195.4,59.7c-24.7-30.4-50.3-56-76.3-76.3a18.05,18.05,0,1,0-22.3,28.4c20.6,16.1,41.2,36.1,61.2,59.5a394.59,394.59,0,0,1-66,61.3c-60.1,43.7-120.8,59.5-180.3,46.9a18,18,0,0,0-7.4,35.2,224.08,224.08,0,0,0,46.8,4.9,237.92,237.92,0,0,0,71.1-11.1c31.1-9.7,62-25.7,91.9-47.5,50.4-36.9,80.5-77.6,81.8-79.3A18.16,18.16,0,0,0,486.07,233.61Z"/></svg>
                                {{ __('Hide reply') }}
                            </div>
                            @can('update', $post)
                            <div class="simple-suboption edit-post edit-post-from-outside-viewer flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"/></svg>
                                {{ __('Edit reply') }}
                                <div style="width: 8px">
                                    <div class="loading-dots-anim ml4 none">•</div>
                                </div>
                            </div>
                            @endcan
                            @can('destroy', $post)
                            <div class="simple-suboption delete-post-button flex align-center">
                                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                                {{ __('Delete reply') }}
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-line-separator mb4"></div>
            <div class="post-content px8">
                {{ $post->parsed_content }}
            </div>
            @can('update', $post)
            <div class="post-edit-container px8 py8 none">
                <div class="flex align-center space-between">
                    <p class="fs12 bold my8">{{ __('EDIT YOUR POST') }} <span class="error fs13"></span></p>
                    <div class="flex align-center">
                        <a href="" class="simple-white-button save-edit-post" style="background-color: #a8d8ff">{{ __('Save') }}</a>
                        <a href="" class="simple-white-button exit-edit-post ml4">✖</a>
                    </div>
                </div>
                <textarea name="content" class="reply-content" id="post-edit-content-{{ $post->id }}"></textarea>
                <input type="hidden" class="post_id" value="{{ $post->id }}">
            </div>
            @endcan
        </div>
    </div>
</div>