<div class="activities-section activities-liked-threads-section">
    <div class="activities-section-content-header flex">
        <h3 class="move-to-middle forum-color flex align-center unselectable">
            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M458.4,64.3C400.6,15.7,311.3,23,256,79.3,200.7,23,111.4,15.6,53.6,64.3-21.6,127.6-10.6,230.8,43,285.5L218.4,464.2a52.52,52.52,0,0,0,75.2.1L469,285.6C522.5,230.9,533.7,127.7,458.4,64.3ZM434.8,251.8,259.4,430.5c-2.4,2.4-4.4,2.4-6.8,0L77.2,251.8c-36.5-37.2-43.9-107.6,7.3-150.7,38.9-32.7,98.9-27.8,136.5,10.5l35,35.7,35-35.7c37.8-38.5,97.8-43.2,136.5-10.6,51.1,43.1,43.5,113.9,7.3,150.8Z"/></svg>
            {{ __('Liked threads') }} [<span class="current-section-thread-count mx4">{{ 10 * ($likedthreads->count() / 10) }}</span> / {{ $user->liked_threads()->count() }} ]
        </h3>
    </div>
    <div class="activities-section-content">
        @foreach($likedthreads as $thread)
            <x-activities.activity-thread :thread="$thread" :user="$user"/>
        @endforeach
        @if($user->liked_threads()->count() > 10)
        <div class="flex activity-section-load-more">
            <input type="hidden" class="section" value="liked-threads">
            <div class="flex align-center move-to-middle">
                <p class="bold no-margin mr8 fs15 blue">{{ __('Load More') }}</p>
                <div class="spinner size17 opacity0">
                    <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path fill="#2ca0ff" d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                </div>
            </div>
        </div>
        @endif
        @if(!$likedthreads->count())
            <div class="full-center">
                <div>
                    <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any liked threads for the moment !") }}</p>
                    <div class="flex">
                        <div class="flex align-center move-to-middle my4">
                            <p class="text-center">{{ __("Eplore other peoples' discussions and hit like button to interact with other people posts") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>