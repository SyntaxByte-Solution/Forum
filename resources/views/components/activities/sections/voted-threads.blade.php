<div class="activities-section activities-voted-threads-section">
    <div class="activities-section-content-header flex">
        <h3 class="move-to-middle forum-color flex align-center unselectable">
            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></svg>
            {{ __('Voted threads') }} [<span class="current-section-thread-count mx4">{{ 10 * ($votedthreads->count() / 10) }}</span> / {{ $user->voted_threads()->count() }} ]
        </h3>
    </div>
    <div class="activities-section-content">
        @foreach($votedthreads as $thread)
            <x-activities.activity-thread :thread="$thread" :user="$user"/>
        @endforeach
        @if($user->voted_threads()->count() > 10)
        <div class="flex activity-section-load-more">
            <input type="hidden" class="section" value="voted-threads">
            <div class="flex align-center move-to-middle">
                <p class="bold no-margin mr8 fs15 blue">{{ __('Load More') }}</p>
                <div class="spinner size17 opacity0">
                    <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path fill="#2ca0ff" d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                </div>
            </div>
        </div>
        @endif
        @if(!$votedthreads->count())
            <div class="full-center">
                <div>
                    <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You have not voted any discussions or question yet !") }}</p>
                    <div class="flex">
                        <div class="flex align-center move-to-middle my4">
                            <p class="text-center">{{ __("To vote a thread, click on the up and down buttons in the left side of thread component") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>