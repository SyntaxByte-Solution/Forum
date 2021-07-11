@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
@endpush

@php
    $forums = \App\Models\Forum::all();
    $categories = $forums->first()->categories->where('slug', '<>', 'announcements');
    $category = $categories->first();
@endphp

<div>
    <p class="no-margin mb8 bold">{{ __('Start a discussion / Ask a question') }}</p>
    <div class="thread-add-container">
        <input type="hidden" class="forum" value="{{ $forums->first()->id }}">
        <input type="hidden" class="category" value="{{ $category->id }}">
        <div class="thread-add-header flex align-center">
            <img src="{{ auth()->user()->avatar }}" class="size28 rounded mr4" alt="">
            <div class="relative">
                <div>
                    <div class="flex align-center forum-color button-with-suboptions pointer thread-add-posted-to fs12">
                        <span class="mr4">{{ __('Forum') }}:</span>
                        <span class="thread-add-selected-forum">{{ $forums->first()->forum }}</span>
                        <div class="size7 sprite sprite-2-size more7-icon mx4"></div>
                    </div>
                    <div class="suboptions-container thread-add-suboptions-container">
                        @foreach($forums as $forum)
                            <div class="thread-add-suboption thread-add-forum flex align-center">
                                <span class="thread-add-forum-val">{{ $forum->forum }}</span>
                                    <div class="loading-dots-anim ml4 none">.</div>
                                <input type="hidden" class="forum-id" value="{{ $forum->id }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="gray mx4">▸</div>
            <div class="relative">
                <div>
                    <div class="flex align-center forum-color button-with-suboptions pointer thread-add-posted-to fs12">
                        <span class="mr4">{{ __('Category') }}:</span>
                        <span class="thread-add-selected-category">{{ $category->category }}</span>
                        <div class="size7 sprite sprite-2-size more7-icon mx4"></div>
                    </div>
                    <div class="suboptions-container thread-add-suboptions-container" style="width: 190px">
                        <div class="thread-add-categories-container">
                            @foreach($categories as $category)
                                <div class="thread-add-suboption thread-add-category flex align-center">
                                    <span class="thread-add-category-val">{{ $category->category }}</span>
                                    <input type="hidden" class="category-id" value="{{ $category->id }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative move-to-right">
                <div class="audience-button button-with-suboptions flex align-center pointer">
                    <p class="no-margin mr4 fs12 gray">{{__('Visibility')}}: </p>
                    <div class="size18 sprite sprite-2-size thread-add-status-icon public18-icon" title="Public"></div>
                    <input type="hidden" class="thread-add-status-slug" value="live">
                </div>
                <div class="suboptions-container thread-add-suboptions-container" style="right: 0; min-width: 134px">
                    <div class="thread-add-suboption thread-add-status flex align-center">
                        <div class="size14 sprite sprite-2-size public14-icon mr4"></div>
                        <span class="thread-add-forum-val">{{ __('Public') }}</span>
                        <input type="hidden" class="thread-state" value="public">
                        <input type="hidden" class="icon-when-selected" value="public18-icon">
                    </div>
                    <div class="thread-add-suboption thread-add-status flex align-center">
                        <div class="size14 sprite sprite-2-size followers14-icon mr4"></div>
                        <span class="thread-add-forum-val">{{ __('Followers-only') }}</span>
                        <input type="hidden" class="thread-state" value="followers-only">
                        <input type="hidden" class="icon-when-selected" value="followers18-icon">
                    </div>
                    <div class="thread-add-suboption thread-add-status flex align-center">
                        <div class="size14 sprite sprite-2-size private14-icon mr4"></div>
                        <span class="thread-add-forum-val">{{ __('Private') }}</span>
                        <input type="hidden" class="thread-state" value="only-me">
                        <input type="hidden" class="icon-when-selected" value="private18-icon">
                    </div>
                </div>
            </div>
        </div>
        <div class="mx8 my8">
            <span class="fs13 error thread-add-error none"></span>
        </div>
        <div class="mx8 my8">
            <label for="subject" class="thread-add-label">{{ __('Title') }}<span class="error none">*</span></label>
            <input type="hidden" class="required-text" value="{{ __('Title field is required') }}">
            <input type="text" id="subject" name="subject" class="thread-add-input" required autocomplete="off" placeholder='{{ __("Be specific and imagine you’re asking a question to another person") }}'>
        </div>
        <div>
            <label for="content" class="thread-add-label mx8">{{ __('Content') }}<span class="error none">*</span></label>
            <input type="hidden" class="required-text" value="{{ __('Content field is required') }}">
            <textarea name="content" id="content"></textarea>
            <script>
                var simplemde = new SimpleMDE({
                    placeholder: '{{ __("Add a discussion content here..") }}',
                    hideIcons: ["guide", "heading", "link", "image"],
                    spellChecker: false,
                });
                simplemde.value();

                function htmlDecode(input){
                    var e = document.createElement('textarea');
                    e.innerHTML = input;
                    // handle case of empty input
                    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
                }
            </script>
        </div>
        <div class="thread-add-media-section px8">
            <div class="thread-add-media-error px8 my8">
                <p class="error tame-image-type none">* {{ __('Only JPG, PNG, JPEG, BMP and GIF image formats are supported') }}.</p>
                <p class="error tame-image-limit none">* {{ __('You couldonly upload 30 images max') }}.</p>
                <p class="error tame-video-type none">* {{ __('Only .mp4,.webm,.mpg,.mp2,.mpeg,.mpe,.mpv,.ogg,.mp4,.m4p,.m4v,.avi video formats are supported') }}.</p>
            </div>
            <div class="flex">
                <div class="flex align-center thread-add-button-hover-style mr8 relative">
                    <div class="size24 sprite sprite-2-size image24-icon mr4"></div>
                    <p class="no-margin fs13">Photos</p>
                    <input type="file" name="images[]" id="thread-photos" class="thread-add-file-input" multiple accept=".jpg,.jpeg,.png,.bmp,.gif">
                </div>
                <div class="flex align-center thread-add-button-hover-style relative">
                    <div class="size24 sprite sprite-2-size image24-icon mr4"></div>
                    <p class="no-margin fs13">Videos</p>
                    <input type="file" name="videos[]" id="thread-videos" class="thread-add-file-input" multiple accept=".mp4,.webm,.mpg,.mp2,.mpeg,.mpe,.mpv,.ogg,.mp4,.m4p,.m4v,.avi">
                </div>
            </div>
            <div class="thread-add-uploaded-medias-container flex flex-wrap my4">
                <input type="hidden" class="uploaded-medias-counter" value="0">
                <!-- the following div will be used to clone uploaded images -->
                <div class="thread-add-uploaded-media relative none thread-add-uploaded-media-projection-model">
                    <img src="" class="thread-add-uploaded-image move-to-middle none" alt="">
                    <div class="close-thread-media-upload x-close-container-style remove">
                        <span class="x-close">✖</span>
                    </div>
                    <div class="thread-add-more-shadowed none">
                        <p class="white no-margin fs20 bold">+<span class="thread-add-more-counter">0</span></p>
                    </div>
                    <input type="hidden" class="uploaded-media-index" value="-1">
                    <input type="hidden" class="uploaded-media-genre" value="">
                </div>
            </div>
        </div>
        <div class="mb8 px8 flex">
            <input type="hidden" class="message-ing" value="{{ __('Sharing..') }}">
            <input type="hidden" class="message-no-ing" value="{{ __('Share') }}">
            <input type="button" class="thread-add-share" value="{{ __('Share') }}">
        </div>
        <style>
            .CodeMirror,
            .CodeMirror-scroll {
                max-height: {{ $editor_height }}px;
                min-height: {{ $editor_height }}px;
                border-radius: 0;
                border-left: none;
                border-right: none;
                border-color: #dbdbdb;
            }
            .CodeMirror-scroll:focus {
                border-color: #64ceff;
                box-shadow: 0 0 0px 3px #def2ff;
            }
            .editor-toolbar {
                padding: 0 4px;
                opacity: 0.8;
                height: 38px;
                border-radius: 0;
                border-left: none;
                border-right: none;
                border-top-color: #dbdbdb;

                display: flex;
                align-items: center;
            }
            .editor-toolbar .fa-arrows-alt {
                margin-left: auto;
                margin-right: 10px;
            }
            .editor-statusbar {
                border-radius: 0px;
            }
        </style>
    </div>
</div>