<div class="activities-section activities-saved-threads-section">
    <h3 class="no-margin forum-color flex align-center unselectable mb8">
        <svg class="size4 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
        {{ __('Saved threads') }} [<span class="current-section-thread-count mx4">{{ 10 * ($savedthreads->count() / 10) }}</span> / {{ $user->savedthreads->count() }} ]
    </h3>
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