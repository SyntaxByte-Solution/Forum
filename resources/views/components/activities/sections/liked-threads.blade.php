<div class="activities-section activities-liked-threads-section">
    <h3 class="no-margin forum-color flex align-center unselectable mb8">
        <svg class="size4 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
        {{ __('Liked threads') }} [<span class="current-thread-count mx4">{{ 6 * ($likedthreads->count() / 6) }}</span> / {{ $user->liked_threads()->count() }} ]
    </h3>
    @foreach($likedthreads as $thread)
        <x-activities.activity-thread :thread="$thread" :user="$user"/>
    @endforeach
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