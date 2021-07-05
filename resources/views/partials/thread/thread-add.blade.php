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

<div class="my8">
    <p class="my4 bold">{{ __('Start a discussion / Ask a question') }}</p>
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
                                    <div class="loading-dots-anim fs16 bold ml4 none">.</div>
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
                <div class="button-with-suboptions flex align-center pointer">
                    <p class="no-margin mr4 fs12 gray">Audience: </p>
                    <div class="size18 sprite sprite-2-size public18-icon" title="Public"></div>
                </div>
                <div class="suboptions-container thread-add-suboptions-container" style="right: 0; min-width: 134px">
                    <div class="thread-add-suboption thread-add-status flex align-center">
                        <div class="size14 sprite sprite-2-size public14-icon mr4"></div>
                        <span class="thread-add-forum-val">{{ __('Public') }}</span>
                        <input type="hidden" class="thread-state" value="public">
                    </div>
                    <div class="thread-add-suboption thread-add-status flex align-center">
                        <div class="size14 sprite sprite-2-size followers14-icon mr4"></div>
                        <span class="thread-add-forum-val">{{ __('Followers-only') }}</span>
                        <input type="hidden" class="thread-state" value="followers-only">
                    </div>
                    <div class="thread-add-suboption thread-add-status flex align-center">
                        <div class="size14 sprite sprite-2-size private14-icon mr4"></div>
                        <span class="thread-add-forum-val">{{ __('Private') }}</span>
                        <input type="hidden" class="thread-state" value="private">
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
                    placeholder: '{{ __("Add a discussion or question..") }}',
                    hideIcons: ["guide", "heading"],
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
        <div class="thread-add-media-section">
            
        </div>
        <div class="my4 px8 py4 flex">
            <input type="hidden" class="message-ing" value="{{ __('Sharing..') }}">
            <input type="hidden" class="message-no-ing" value="{{ __('Share') }}">
            <input type="button" class="thread-add-share" value="{{ __('Share') }}">
        </div>
        <style>
            .CodeMirror,
            .CodeMirror-scroll {
                max-height: 100px;
                min-height: 100px;
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