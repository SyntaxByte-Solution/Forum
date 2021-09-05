<div class="activities-section activities-threads-section relative">
    <!-- this will be like a fixed header above the threads scrollable -->
    <div class="activities-section-content-header flex">
        <h3 class="move-to-middle forum-color flex align-center unselectable activity-section-head-counter">
            <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
            {{ __('Discussions') }} [<span class="current-section-thread-count mx4">{{ 6 * ($threads->count() / 6) }}</span> / {{ $user->threads->count() }} ]
        </h3>
    </div>

    <div class="activities-section-content">
        @foreach($threads as $thread)
            <x-activities.activity-thread :thread="$thread" :user="$user"/>
        @endforeach
        @if($user->threads->count() > 10)
        <div class="flex activity-section-load-more">
            <input type="hidden" class="section" value="threads">
            <div class="flex align-center move-to-middle">
                <p class="bold no-margin mr8 fs15 blue">{{ __('Load More') }}</p>
                <div class="spinner size17 opacity0">
                    <svg class="size17" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 197.21 197.21"><path fill="#2ca0ff" d="M182.21,83.61h-24a15,15,0,0,0,0,30h24a15,15,0,0,0,0-30ZM54,98.61a15,15,0,0,0-15-15H15a15,15,0,0,0,0,30H39A15,15,0,0,0,54,98.61ZM98.27,143.2a15,15,0,0,0-15,15v24a15,15,0,0,0,30,0v-24A15,15,0,0,0,98.27,143.2ZM98.27,0a15,15,0,0,0-15,15V39a15,15,0,1,0,30,0V15A15,15,0,0,0,98.27,0Zm53.08,130.14a15,15,0,0,0-21.21,21.21l17,17a15,15,0,1,0,21.21-21.21ZM50.1,28.88A15,15,0,0,0,28.88,50.09l17,17A15,15,0,0,0,67.07,45.86ZM45.86,130.14l-17,17a15,15,0,1,0,21.21,21.21l17-17a15,15,0,0,0-21.21-21.21Z"/></svg>
                </div>
            </div>
        </div>
        @endif
        @if(!$threads->count())
            <div class="full-center" style="margin-top: 46px">
                <div class="flex flex-column align-center">
                    <svg class="size48 my4" viewBox="0 0 442 442"><path d="M442,268.47V109.08a11.43,11.43,0,0,0-.1-1.42,2.51,2.51,0,0,0,0-.27,10.11,10.11,0,0,0-.29-1.3v0c-.1-.31-.21-.62-.34-.92l-.12-.26-.15-.32c-.17-.34-.36-.67-.56-1a.57.57,0,0,1-.08-.13,10.33,10.33,0,0,0-.81-1l-.17-.18a8,8,0,0,0-.84-.81l-.14-.12a9.65,9.65,0,0,0-1.05-.76l-.26-.15a8.61,8.61,0,0,0-1.05-.53.67.67,0,0,0-.12-.06l-236-99-.06,0-.28-.1a10,10,0,0,0-4.4-.61h-.08a10.59,10.59,0,0,0-1.94.39l-.12,0c-.27.09-.55.18-.82.29l0,0-69.22,29a10,10,0,0,0,0,18.44L186,74.73v88.16L6.13,238.37l-.36.17-.36.17c-.28.15-.55.31-.82.48l-.13.07s0,0,0,0a9.86,9.86,0,0,0-1,.72l-.09.08c-.25.23-.49.46-.72.71l-.2.22a8.19,8.19,0,0,0-.53.67c-.07.08-.13.17-.19.25-.18.27-.34.54-.5.81l-.09.15c-.17.33-.32.67-.46,1,0,.09-.07.19-.1.28-.09.26-.18.53-.25.79l-.09.35c-.06.28-.12.55-.16.83,0,.1,0,.19,0,.28A11.87,11.87,0,0,0,0,247.62V333a10,10,0,0,0,6.13,9.22l235.92,99a9.8,9.8,0,0,0,1.95.6l.19,0c.26.05.52.09.79.12s.66.05,1,.05.67,0,1-.05.53-.07.79-.12l.19,0a9.8,9.8,0,0,0,2-.6l186-78A10,10,0,0,0,442,354V268.47ZM330.23,300.4l-63.15-26.49a10,10,0,0,0-7.74,18.44l45,18.9L246,335.75,137.62,290.29l58.4-24.5,35.53,14.9a10,10,0,1,0,7.74-18.44l-33.27-14V184.58l200.13,84ZM186,248.29l-74.25,31.16L35.85,247.59l150.17-63v63.71ZM196,20.84,406.15,109l-43.37,18.2L200,58.89l-.09,0L152.65,39Zm162.82,126.4a10,10,0,0,0,7.81,0L422,124.05V253.51L206,162.89V83.13ZM20,262.63l216,90.62V417L20,326.34ZM422,347.3,256,417V353.25l166-69.66Z"/></svg>
                    @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->id == $user->id)
                        <p class="fs20 text-center bold my8">{{ __("You don't have any discussion for the moment") }} !</p>
                        <div class="flex">
                            <div class="flex align-center move-to-middle">
                                <p class="text-center">{{ __("To create a new discussion, click on the following button") }}</p>
                                <a href="{{ route('thread.add') }}" class="button-style-1 flex align-center ml8 width-max-content">
                                    <svg class="size14 mr4" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 397.15 397.15"><path d="M390.88,12.37c-4.14-4.15-10.13-6.25-17.78-6.25-26.78,0-70.16,26-93.64,41.55l-1.91,1.27-5.28,41.68-14-28.34-4.81,3.52a763.05,763.05,0,0,0-85.75,73.26c-4.62,4.62-9.16,9.31-13.5,13.94l-.93,1-18.7,82.35-9.86-49.17L118,196.36c-3.84,5.26-7.46,10.53-10.78,15.65l-.62,1-8,62.92L86.17,250.56,82.63,263.1c-4.3,15.28-4.5,28.32-.67,38.5l-80,80a5.52,5.52,0,0,0-1.55,6.22A5.21,5.21,0,0,0,5.24,391a6.85,6.85,0,0,0,2.46-.49l36.94-14a15.23,15.23,0,0,0,5.11-3.41l49.61-52.77A44.27,44.27,0,0,0,118,324h0a82.94,82.94,0,0,0,22.18-3.4l12.54-3.54-25.33-12.49,62.92-8,.95-.62c5.12-3.31,10.39-6.94,15.66-10.79l9.19-6.7-49.17-9.86,82.34-18.71,1-.92c4.64-4.35,9.33-8.89,13.94-13.5,35.17-35.17,70.11-78.39,95.85-118.59l3-4.7L338.24,100,373,95.59l1.23-2.2C397.46,51.81,403.07,24.56,390.88,12.37Z"/></svg>
                                    {{__('Start a discussion')}}
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="fs20 text-center bold my4">{{ __("This user has no discussions for the moment !") }}</p>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>