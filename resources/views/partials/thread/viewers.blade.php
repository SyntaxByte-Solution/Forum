<div id="thread-replies-switch-viewer" class="global-viewer flex justify-center none">
    <input type="hidden" class="switch-to" autocomplete="off">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-1 vbs-margin-1">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color flex align-center">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                {{ __('Poste replies enable/disable') }}
            </span>
            <div class="pointer fs20 close-global-viewer unselectable">✖</div>
        </div>
        <div style="padding: 14px">
            <div class="thread-replies-switched-on none">
                <h2 class="no-margin fs18 forum-color">{{ __('If you turn off replies, no one could reply to your post') }} !</h2>
                <p class="fs13 no-margin mt8" style="line-height: 1.5">{{ __('If there are already some replies, they will not disappeared') }}.</p>
            </div>
            <div class="thread-replies-switched-off none">
                <h2 class="no-margin fs18 forum-color">{{ __('Turn on replies on this post') }} !</h2>
            </div>
            <div class="flex" style="margin-top: 14px">
                <div class="move-to-right">
                    <div class="flex align-center">
                        <button id="thread-replies-switcher" class="relative button-style mr8">
                            <input type="hidden" class="thread-id" autocomplete="off">
                            <span class="button-text fs13"></span>
                            <div class="spinner size17 ml8 opacity0 absolute" style="right: 8px">
                                <svg class="size17" xmlns="http://www.w3.org/2000/svg" fill="#fff" viewBox="0 0 197.21 197.21"><path d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                            </div>
                            <input type="hidden" class="turn-on-label" value="{{ __('Turn on replies') }}">
                            <input type="hidden" class="turn-off-label" value="{{ __('Turn off replies') }}">
                            <input type="hidden" class="turn-on-message" value="{{ __('Replies are enabled on this post') }}">
                            <input type="hidden" class="turn-off-message" value="{{ __('Replies are disabled on this post') }}">
                            <input type="hidden" class="button-text-ing" value="{{ __('Please wait') }}..">
                        </button>
                        <div class="pointer close-global-viewer bblack bold">{{ __('Cancel') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="thread-delete-viewer" class="global-viewer flex justify-center none">
    <div class="close-button-style-1 close-global-viewer unselectable">✖</div>
    <div class="global-viewer-content-box viewer-box-style-1 vbs-margin-1">        
        <div class="flex align-center space-between light-gray-border-bottom" style="padding: 14px;">
            <span class="fs20 bold forum-color flex align-center">
                <svg class="size20 mr8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M300,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H300a12,12,0,0,0-12,12V404A12,12,0,0,0,300,416ZM464,80H381.59l-34-56.7A48,48,0,0,0,306.41,0H205.59a48,48,0,0,0-41.16,23.3l-34,56.7H48A16,16,0,0,0,32,96v16a16,16,0,0,0,16,16H64V464a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48h0V128h16a16,16,0,0,0,16-16V96A16,16,0,0,0,464,80ZM203.84,50.91A6,6,0,0,1,209,48h94a6,6,0,0,1,5.15,2.91L325.61,80H186.39ZM400,464H112V128H400ZM188,416h24a12,12,0,0,0,12-12V188a12,12,0,0,0-12-12H188a12,12,0,0,0-12,12V404A12,12,0,0,0,188,416Z"/></svg>
                {{ __('Delete post') }}
            </span>
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
<div id="thread-media-viewer" class="none">
    <div class="thread-media-viewer-content-section relative has-fade">
        <div class="close-thread-media-viewer unselectable">✖</div>
        <div class="thread-viewer-medias-indicator unselectable block-click none"><span class="thread-counter-current-index"></span>/<span class="thread-counter-total-medias"></span></div>
        <div class="thread-viewer-nav thread-viewer-left unselectable fs18 none">◄</div>
        <div class="thread-viewer-nav thread-viewer-right unselectable fs18 none">►</div>

        <img src="" id="thread-viewer-media-image" class="image-that-fade-wait" alt="">
        <video id="thread-viewer-media-video" style="width: calc(100% - 128px);" controls class="none full-height">
            {{__('Your browser does not support the video tag')}}.
        </video>
    </div>
    <div class="thread-media-viewer-infos-section">
        <div class="thread-media-viewer-infos-header-pattern">
            <div class="thread-media-viewer-infos-header">
                <div class="flex">
                    <div class="relative hidden-overflow rounded">
                        <div class="fade-loading"></div>
                        <div class="size48 rounded"></div>
                    </div>
                    <div class="ml8">
                        <div class="flex relative mb4 hidden-overflow">
                            <div class="relative hidden-overflow br4">
                                <div class="fade-loading"></div>
                                <a href="" class="bold no-underline blue fs15">Mouad Nassri</a>
                            </div>
                            <div class="relative height-max-content hidden-overflow br4 ml4">
                                <div class="fade-loading"></div>
                                <p class="no-margin gray fs12">FOLLOW</p>
                            </div>
                        </div>
                        <div class="relative width-max-content hidden-overflow br4">
                            <div class="fade-loading"></div>
                            <p class="no-margin gray fs12">grotto_47</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="relative hidden-overflow rounded">
                        <div class="fade-loading"></div>
                        <div class="size28 rounded"></div>
                    </div>
                </div>
            </div>
            <div class="thread-media-viewer-infos-content px8 py8">
                <div class="relative hidden-overflow br4 width-max-content mb8">
                    <div class="fade-loading"></div>
                    <a href="" class="bold no-underline blue fs15">Lorem ipsum dolor sit amet consectetur</a>
                </div>
                <div class="relative hidden-overflow br4 mb8">
                    <div class="fade-loading"></div>
                    <a href="" class="bold no-underline blue fs15">lorem</a>
                </div>
                <div class="relative hidden-overflow br4 mb8" style="height: 100px">
                    <div class="fade-loading"></div>
                    <a href="" class="bold no-underline blue fs15">lorem</a>
                </div>
                <div class="relative hidden-overflow br4 mb8">
                    <div class="fade-loading"></div>
                    <a href="" class="bold no-underline blue fs15">lorem</a>
                </div>
                <div class="relative hidden-overflow br4 mb8">
                    <div class="fade-loading"></div>
                    <a href="" class="bold no-underline blue fs15">lorem</a>
                </div>
                <div class="relative hidden-overflow br4" style="height: 100%">
                    <div class="fade-loading"></div>
                    <a href="" class="bold no-underline blue fs15">lorem</a>
                </div>
            </div>
        </div>
        <div class="tmvisc">
            
        </div>
    </div>
</div>