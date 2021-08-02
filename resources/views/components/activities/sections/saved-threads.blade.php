<div class="activities-section activities-saved-threads-section">
    <div class="activities-section-content-header flex">
        <h3 class="move-to-middle forum-color flex align-center unselectable">
            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400,0H112A48,48,0,0,0,64,48V512L256,400,448,512V48A48,48,0,0,0,400,0Zm0,428.43-144-84-144,84V54a6,6,0,0,1,6-6H394a6,6,0,0,1,6,6Z"/></svg>
            {{ __('Saved threads') }} [<span class="current-section-thread-count mx4">{{ 10 * ($savedthreads->count() / 10) }}</span> / {{ $user->savedthreads->count() }} ]
        </h3>
    </div>
    <div class="activities-section-content">
        @foreach($savedthreads as $thread)
            <x-activities.activity-thread :thread="$thread" :user="$user"/>
        @endforeach
        @if($user->savedthreads->count() > 10)
        <div class="flex activity-section-load-more">
            <input type="hidden" class="section" value="saved-threads">
            <div class="flex align-center move-to-middle">
                <p class="bold no-margin mr8 fs15 blue">{{ __('Load More') }}</p>
                <div class="spinner size17 opacity0">
                    <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path fill="#2ca0ff" d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                </div>
            </div>
        </div>
        @endif
        @if(!$savedthreads->count())
            <div class="full-center">
                <div>
                    <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any saved threads for the moment !") }}</p>
                    <div class="flex">
                        <div class="flex align-center move-to-middle my4">
                            <p class="text-center">{{ __("Eplore other peoples' discussions and hit save to save discussions into your bookmark") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>