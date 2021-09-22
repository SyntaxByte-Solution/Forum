<div id="thread-delete-viewer" class="global-viewer flex justify-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-1">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color">{{ __('Delete Post') }}</span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div style="padding: 14px">
            <h2 class="no-margin fs18 forum-color">{{ __('Please make sure you want to delete the post') }} !</h2>
            <p class="fs13 no-margin mt8" style="line-height: 1.5">{{ __('This will throw your post to the archive in case you decide to restore It. You can either restore it or delete it permanently later by going to your activities -> archive !') }}.</p>
            <div class="flex" style="margin-top: 14px">
                <div class="move-to-right">
                    <div class="flex align-center">
                        <button id="move-thread-to-trash" class="relative button-style mr8">
                            <input type="hidden" class="thread-id">
                            <svg class="size17 mr4" style="fill:#fff" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                            <div class="btn-text">{{ __('Move to trash') }}</div>
                            <div class="spinner size17 ml8 opacity0 absolute" style="right: 8px">
                                <svg class="size17" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                            </div>
                            <input type="hidden" class="btn-text-no-ing" value="{{ __('Move to trash') }}">
                            <input type="hidden" class="btn-text-ing" value="{{ __('Moving to trash') }}..">
                            <input type="hidden" class="moved-successfully" value="{{ __('Your discussion is moved successfully to trash') }}.">
                            <input type="hidden" class="go-to-archive" value="{{ __('Go to archive') }}.">
                        </button>
                        <div class="pointer close-global-viewer bblack bold">{{ __('Cancel') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>