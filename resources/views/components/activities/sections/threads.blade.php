<div class="activities-section activities-threads-section">
    <h3 class="no-margin forum-color flex align-center unselectable mb8">
        <svg class="size4 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
        {{ __('Threads area') }} [<span class="current-thread-count mx4">{{ 6 * ($threads->count() / 6) }}</span> / {{ $user->threads->count() }} ]
    </h3>
    @foreach($threads as $thread)
        <x-activities.activity-thread :thread="$thread" :user="$user"/>
    @endforeach
    @if($user->threads->count() > 6)
    <div class="flex activity-section-load-more activity-threads-section-load-more">
        <div class="flex align-center move-to-middle">
            <p class="bold no-margin mr4 fs15 blue">{{ __('Load More') }}</p>
            <div class="spinner size20 opacity0">
                <svg class="size20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path fill="#2ca0ff" d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
            </div>
        </div>
    </div>
    @endif
    @if(!$threads->count())
        <div class="full-center">
            <div>
                <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("You don't have any discussions or question for the moment !") }}</p>
                <div class="flex">
                    <div class="flex align-center move-to-middle my4">
                        <p class="text-center">{{ __("To create a new discussion, click on the following button") }}</p>
                        <a href="{{ route('thread.add') }}" class="button-style-1 flex align-center ml8 width-max-content">
                            <svg class="size14 mr4" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 397.15 397.15"><path d="M390.88,12.37c-4.14-4.15-10.13-6.25-17.78-6.25-26.78,0-70.16,26-93.64,41.55l-1.91,1.27-5.28,41.68-14-28.34-4.81,3.52a763.05,763.05,0,0,0-85.75,73.26c-4.62,4.62-9.16,9.31-13.5,13.94l-.93,1-18.7,82.35-9.86-49.17L118,196.36c-3.84,5.26-7.46,10.53-10.78,15.65l-.62,1-8,62.92L86.17,250.56,82.63,263.1c-4.3,15.28-4.5,28.32-.67,38.5l-80,80a5.52,5.52,0,0,0-1.55,6.22A5.21,5.21,0,0,0,5.24,391a6.85,6.85,0,0,0,2.46-.49l36.94-14a15.23,15.23,0,0,0,5.11-3.41l49.61-52.77A44.27,44.27,0,0,0,118,324h0a82.94,82.94,0,0,0,22.18-3.4l12.54-3.54-25.33-12.49,62.92-8,.95-.62c5.12-3.31,10.39-6.94,15.66-10.79l9.19-6.7-49.17-9.86,82.34-18.71,1-.92c4.64-4.35,9.33-8.89,13.94-13.5,35.17-35.17,70.11-78.39,95.85-118.59l3-4.7L338.24,100,373,95.59l1.23-2.2C397.46,51.81,403.07,24.56,390.88,12.37Z"/></svg>
                            {{__('Start a discussion')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>