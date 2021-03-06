<div class="relative viewer-thread-reply my8 @if($post->ticked) viewer-ticked-reply @endif">
    <input type="hidden" class="post-id" value="{{ $post->id }}">
    <input type="hidden" class="votable-type" value="post">
    <input type="hidden" class="votable-id" value="{{ $post->id }}">

    @can('destroy', $post)
    <div class="absolute full-shadowed br6" style="z-index: 1">
        @can('destroy', $post)
        <div class="full-center full-width full-height">
            <div class="flex align-center">
                <button class="simple-white-button pointer delete-post delete-from-viewer">
                    <span class="btn-text">{{ __('Delete') }}</span>
                    <input type="hidden" class="button-ing-no-text" value="{{ __('Delete') }}">
                    <input type="hidden" class="button-ing-text" value="{{ __('Deleting') }}..">
                    <input type="hidden" class="message-when-delete" value="{{ __('Your reply deleted successfully') }}.">
                </button>
                <button class="simple-link close-shadowed-view-button" style="background: unset; border: unset; cursor: pointer; margin-left: 6px; font-size: 10px; font-weight: bold">{{ __('Cancel') }}</button>
                <input type="hidden" class="post-id" value="{{ $post->id }}">
            </div>
        </div>
        @endcan
    </div>
    @endcan

    <div class="show-post-container fs11 mx4 my4">
        {{ __('Reply hidden') }} [<a href="" class="show-post show-post-from-viewer black-link bold">{{ __('click here to show it') }}</a>]
    </div>

    <div class="viewer-post-main-component">
        <div class="viewer-thread-reply-header flex space-between">
            <div class="flex">
                <a href="{{ $post->user->profilelink }}" class="button-with-container forum-style-link fs12 flex">
                    <img src="{{ $post->user->sizedavatar(36) }}" class="size36 mr8 rounded" alt="">
                </a>
                <div>
                    <a href="{{ $post->user->profilelink }}" class="no-margin bold blue no-underline">{{ $post->user->fullname }}</a>
                    <div class="flex align-center">
                        <p class="no-margin fs12" style="margin-top: 1px">{{ $post->user->username }}</p>
                        <span class="fs10 gray mx4 unselectable">???</span>
                        <span class="relative block" style="padding-bottom: 1px">
                            <span class="tooltip-section fs11 gray">{{ $post->creation_date_humans }}</span>
                            <span class="tooltip tooltip-style-1">{{ $post->creation_date }}</span>
                        </span>
                        <span class="@if(!$post->is_updated) none @endif gray fs11 ml4 post-updated-date">({{ __('edited') }})</span>
                    </div>
                </div>
            </div>
            <div class="flex">
                <p class="best-reply-ticket unselectable height-max-content @if(!$post->ticked) none @endif" style="margin-right: 4px; padding: 6px; font-size: 11px">{{ __('BEST REPLY') }}</p>
                <div class="relative size17">
                    <svg class="pointer button-with-suboptions size17 mr4" style="margin-top: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M320,256a64,64,0,1,1-64-64A64.06,64.06,0,0,1,320,256Zm-192,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,128,256Zm384,0a64,64,0,1,1-64-64A64.06,64.06,0,0,1,512,256Z"/></svg>
                    <div class="suboptions-container suboptions-container-right-style">
                        <div class="simple-suboption pointer hide-post hide-post-from-viewer flex align-center">
                            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 490.03 490.03"><path d="M435.67,54.31a18,18,0,0,0-25.5,0l-64,64c-79.3-36-163.9-27.2-244.6,25.5C41.47,183,5,232.31,3.47,234.41a18.16,18.16,0,0,0,.5,22c34.2,42,70,74.7,106.6,97.5l-56.3,56.3a18,18,0,1,0,25.4,25.5l356-355.9A18.11,18.11,0,0,0,435.67,54.31ZM200.47,264a46.82,46.82,0,0,1-3.9-19,48.47,48.47,0,0,1,67.5-44.6Zm90.2-90.1a84.37,84.37,0,0,0-116.6,116.6L137,327.61c-32.5-18.8-64.5-46.6-95.6-82.9,13.3-15.6,41.4-45.7,79.9-70.8,66.6-43.4,132.9-52.8,197.5-28.1Zm195.4,59.7c-24.7-30.4-50.3-56-76.3-76.3a18.05,18.05,0,1,0-22.3,28.4c20.6,16.1,41.2,36.1,61.2,59.5a394.59,394.59,0,0,1-66,61.3c-60.1,43.7-120.8,59.5-180.3,46.9a18,18,0,0,0-7.4,35.2,224.08,224.08,0,0,0,46.8,4.9,237.92,237.92,0,0,0,71.1-11.1c31.1-9.7,62-25.7,91.9-47.5,50.4-36.9,80.5-77.6,81.8-79.3A18.16,18.16,0,0,0,486.07,233.61Z"/></svg>
                            {{ __('Hide reply') }}
                        </div>
                        @can('update', $post)
                        <div class="simple-suboption pointer edit-post edit-post-from-viewer flex align-center">
                            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M357.51,334.33l28.28-28.27a7.1,7.1,0,0,1,12.11,5V439.58A42.43,42.43,0,0,1,355.48,482H44.42A42.43,42.43,0,0,1,2,439.58V128.52A42.43,42.43,0,0,1,44.42,86.1H286.11a7.12,7.12,0,0,1,5,12.11l-28.28,28.28a7,7,0,0,1-5,2H44.42V439.58H355.48V339.28A7,7,0,0,1,357.51,334.33ZM495.9,156,263.84,388.06,184,396.9a36.5,36.5,0,0,1-40.29-40.3l8.83-79.88L384.55,44.66a51.58,51.58,0,0,1,73.09,0l38.17,38.17A51.76,51.76,0,0,1,495.9,156Zm-87.31,27.31L357.25,132,193.06,296.25,186.6,354l57.71-6.45Zm57.26-70.43L427.68,74.7a9.23,9.23,0,0,0-13.08,0L387.29,102l51.35,51.34,27.3-27.3A9.41,9.41,0,0,0,465.85,112.88Z"/></svg>
                            {{ __('Edit reply') }}
                            <div style="width: 8px">
                                <div class="loading-dots-anim ml4 none">???</div>
                            </div>
                        </div>
                        @endcan
                        @can('destroy', $post)
                        <div class="simple-suboption pointer delete-post-button flex align-center">
                            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            {{ __('Delete reply') }}
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="flex">
            <div style="width: 44px" class="flex justify-center">
                @if($post->ticked)
                <svg class="size20 mt8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <title>{{ __('Has best reply') }}</title>
                    <path d="M433.73,49.92,178.23,305.37,78.91,206.08.82,284.17,178.23,461.56,511.82,128Z" style="fill:#52c563"/>
                </svg>
                @endif
            </div>
            <div class="border-box full-width">
                <div class="thread-viewer-reply-content post-content">
                    {{ $post->parsed_content }}
                </div>
                @can('update', $post)
                <div class="post-edit-container px8 py8 none">
                    <div class="flex align-center space-between mb4">
                        <p class="fs12 bold no-margin">{{ __('Edit your reply') }} <span class="error fs13"></span></p>
                        <div class="flex align-center">
                            <button class="button-style-2 save-edit-post save-edit-post-from-viewer" style="font-size: 12px">
                                <span class="btn-text">{{ __('Save') }}</span>
                                <input type="hidden" class="btn-text-ing" value="{{ __('Saving') }}..">
                                <input type="hidden" class="btn-text-no-ing" value="{{ __('Save') }}">
                                <input type="hidden" class="message-when-save" value="{{ __('Your reply has been saved successfully') }} !">
                            </button>
                            <button class="button-style-2 exit-edit-post ml4" style="font-size: 10px !important">
                                ???
                            </button>
                        </div>
                    </div>
                    <textarea name="content" class="reply-content" id="post-edit-content-{{ $post->id }}"></textarea>
                    <input type="hidden" class="post_id" value="{{ $post->id }}">
                    <input type="hidden" class="edited-text" value="({{ __('edited') }})">
                </div>
                @endcan
                <div class="flex align-center" style="margin-top: 2px">
                    <div class="flex align-center mr8 vote-box relative">
                        <input type="hidden" class="votable-type" value="post">
                        <input type="hidden" class="votable-id" value="{{ $post->id }}">

                        <svg class="size14 pointer @auth votable-up-vote inside-viewer @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                            <title>{{ __('UP') }}</title>
                            <path class="up-vote-filled @unlessupvoted($post, 'App\Models\Post') none @endupvoted" d="M63.89,55.78v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58H68.21a7.56,7.56,0,0,0,7.53-7.58V55.78ZM97.8,53.5,57.85,7.29A10.28,10.28,0,0,0,50,3.92a10.25,10.25,0,0,0-7.87,3.37L2.23,53.52A6.9,6.9,0,0,0,1,61.14c1.46,3.19,5,5.25,9.09,5.25h14V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53a1.61,1.61,0,0,1,.26,1.75,1.83,1.83,0,0,1-1.67,1H75.74v10.6H89.88c4.05,0,7.61-2.06,9.08-5.24A6.92,6.92,0,0,0,97.8,53.5Zm-16,1.24a1.83,1.83,0,0,1-1.67,1H63.89v28.3h-28V55.78H19.83a1.83,1.83,0,0,1-1.67-1A1.61,1.61,0,0,1,18.42,53L48.61,18a1.9,1.9,0,0,1,2.78.05L81.57,53A1.61,1.61,0,0,1,81.83,54.74Z" style="fill:#28b1e7"/>
                            <path class="up-vote @upvoted($post, 'App\Models\Post') none @endupvoted" d="M10.11,66.39c-4.06,0-7.63-2.06-9.09-5.25a6.9,6.9,0,0,1,1.21-7.62L42.11,7.29A10.25,10.25,0,0,1,50,3.92a10.28,10.28,0,0,1,7.87,3.37L97.8,53.5A6.92,6.92,0,0,1,99,61.13c-1.47,3.18-5,5.24-9.08,5.24H75.74V55.77h4.42a1.83,1.83,0,0,0,1.67-1A1.61,1.61,0,0,0,81.57,53L51.39,18A1.9,1.9,0,0,0,48.61,18L18.42,53a1.61,1.61,0,0,0-.26,1.75,1.83,1.83,0,0,0,1.67,1h4.26V66.39Zm58.1,29.69a7.56,7.56,0,0,0,7.53-7.58V55.78H63.89v28.3h-28V55.78H24.09V88.5a7.56,7.56,0,0,0,7.53,7.58Z" style="fill:#1c1c1c"/>
                        </svg>
                        <div class="fs10 gray" style="margin: 0 2px">???</div>
                        <svg class="size14 pointer @auth votable-down-vote inside-viewer @endauth @guest login-signin-button @endguest" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                            <title>{{ __('DOWN') }}</title>
                            <path class="down-vote-filled @unlessdownvoted($post, 'App\Models\Post') none @enddownvoted" d="M63.89,44.22V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58H68.21a7.56,7.56,0,0,1,7.53,7.58V44.22ZM97.8,46.5,57.85,92.71A10.28,10.28,0,0,1,50,96.08a10.25,10.25,0,0,1-7.87-3.37L2.23,46.48A6.9,6.9,0,0,1,1,38.86c1.46-3.19,5-5.25,9.09-5.25h14V44.22H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47a1.61,1.61,0,0,0,.26-1.75,1.83,1.83,0,0,0-1.67-1H75.74V33.63H89.88c4.05,0,7.61,2.06,9.08,5.24A6.92,6.92,0,0,1,97.8,46.5Zm-16-1.24a1.83,1.83,0,0,0-1.67-1H63.89V15.92h-28v28.3H19.83a1.83,1.83,0,0,0-1.67,1A1.61,1.61,0,0,0,18.42,47L48.61,82a1.9,1.9,0,0,0,2.78,0L81.57,47A1.61,1.61,0,0,0,81.83,45.26Z" style="fill:#28b1e7"/>
                            <path class="down-vote @downvoted($post, 'App\Models\Post') none @enddownvoted" d="M10.11,33.61c-4.06,0-7.63,2.06-9.09,5.25a6.9,6.9,0,0,0,1.21,7.62L42.11,92.71A10.25,10.25,0,0,0,50,96.08a10.28,10.28,0,0,0,7.87-3.37L97.8,46.5A6.92,6.92,0,0,0,99,38.87c-1.47-3.18-5-5.24-9.08-5.24H75.74v10.6h4.42a1.83,1.83,0,0,1,1.67,1A1.61,1.61,0,0,1,81.57,47L51.39,82a1.9,1.9,0,0,1-2.78,0L18.42,47a1.61,1.61,0,0,1-.26-1.75,1.83,1.83,0,0,1,1.67-1h4.26V33.61ZM68.21,3.92a7.56,7.56,0,0,1,7.53,7.58V44.22H63.89V15.92h-28v28.3H24.09V11.5a7.56,7.56,0,0,1,7.53-7.58Z" style="fill:#1c1c1c"/>
                        </svg>
                        <p class="fs12 no-margin text-center bold ml4">(<span class="votable-count">{{ $post->votevalue }}</span>)</p>
                    </div>
                    <div>
                        <div class="thread-react-hover @auth like-resource like-resource-from-viewer @endauth @guest login-signin-button @endguest">
                            <input type="hidden" class="likable-type" value="post">
                            <input type="hidden" class="likable-id" value="{{ $post->id }}">
                            <svg class="size17 like-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 391.84 391.84">
                                <path class="red-like @auth @if(!$post->liked_by(auth()->user())) none @endif @else none @endauth" d="M285.26,35.53A107.1,107.1,0,0,1,391.84,142.11c0,107.62-195.92,214.2-195.92,214.2S0,248.16,0,142.11A106.58,106.58,0,0,1,106.58,35.53h0a105.54,105.54,0,0,1,89.34,48.06A106.57,106.57,0,0,1,285.26,35.53Z" style="fill:#d7453d"/>
                                <path class="grey-like @auth @if($post->liked_by(auth()->user())) none @endif @endauth" d="M273.52,56.75A92.93,92.93,0,0,1,366,149.23c0,93.38-170,185.86-170,185.86S26,241.25,26,149.23A92.72,92.72,0,0,1,185.3,84.94a14.87,14.87,0,0,0,21.47,0A92.52,92.52,0,0,1,273.52,56.75Z" style="fill:none;stroke:#1c1c1c;stroke-miterlimit:10;stroke-width:45px"/>
                            </svg>
                            <p class="no-margin mx4 fs13 resource-likes-counter">{{ $post->likes->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>