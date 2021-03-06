<div class="mt8">
    <div class="right-panel-header-container">
        <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400,32H48A48,48,0,0,0,0,80V432a48,48,0,0,0,48,48H400a48,48,0,0,0,48-48V80A48,48,0,0,0,400,32ZM160,368a16,16,0,0,1-16,16H112a16,16,0,0,1-16-16V240a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H208a16,16,0,0,1-16-16V144a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Zm96,0a16,16,0,0,1-16,16H304a16,16,0,0,1-16-16V304a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16Z"/></svg>
        <p class="bold no-margin">{{ __('Statistics') }}</p>
    </div>
    <div class="mx8 py8">
        <p class="my4 bold flex align-center">
            <svg class="size4 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
            {{__('Forum Stats')}}
        </p>
        <div class="ml8">
            <div class="flex align-center">
                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                <p class="my4 fs13">{{ __('Total forums discussions') }}: {{ \DB::table('threads')->count() }}</p>
            </div>
            <div class="flex align-center my4">
                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                <p class="my4 fs13">{{ __('Total replies') }}: {{ \DB::table('posts')->count() }}</p>
            </div>
            <div class="mt8 my4">
                <div class="flex">
                    <svg class="size17 mr4" fill="#000000" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="currentColor" d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                    <div>
                        <p class="no-margin fs13">{{__('Total members')}}: {{ \DB::table('users')->count() }}</p>
                        @php
                            $last_user_username = \App\Models\User::orderBy('created_at')->first()->username;
                        @endphp
                        <p class="fs11 no-margin">{{ __('Our newest member') }}: <a href="{{ route('user.profile', ['user'=>$last_user_username]) }}" class="link-style inline-block fs12 bold">{{$last_user_username}}</a></p>
                    </div>
                </div>
            </div>
        </div>
        <p class="my4 bold flex align-center">
            <svg class="size4 mr4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>    
            {{ __('Today') }}
        </p>
        <div class="ml8">
            <div class="flex align-center">
                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                <p class="my4 fs13">{{__('Discussions')}}: {{ \App\Models\Thread::today()->count() }}</p>
            </div>
            <div class="flex my4">
                <svg class="size17 mr4" style="margin-top: 2px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                <div>
                    <p class="no-margin fs13">{{__('Replies')}}: {{ \App\Models\Post::today()->count() }}</p>
                    @php
                        $top_today_replier = \App\Models\Post::top_today_poster();
                    @endphp
                    @if($top_today_replier)
                    <p class="fs11 no-margin">{{ __('Top today replier') }}: <a href="{{ $top_today_replier->profilelink }}" class="link-style inline-block fs12 bold">{{ $top_today_replier->username }}</a></p>
                    @endif
                </div>
            </div>
            <div class="flex align-center my4">
                <svg class="size17 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g id="Layer_1_copy" data-name="Layer 1 copy"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></g></svg>
                <p class="my4 fs13">{{ __('Total vote casts') }}: {{ \App\Models\Vote::today()->count() }}</p>
            </div>
            <div class="mt8 my4">
                <div class="flex">
                    <svg class="size17 mr4" fill="#000000" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path fill="currentColor" d="M248 104c-53 0-96 43-96 96s43 96 96 96 96-43 96-96-43-96-96-96zm0 144c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm0-240C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 448c-49.7 0-95.1-18.3-130.1-48.4 14.9-23 40.4-38.6 69.6-39.5 20.8 6.4 40.6 9.6 60.5 9.6s39.7-3.1 60.5-9.6c29.2 1 54.7 16.5 69.6 39.5-35 30.1-80.4 48.4-130.1 48.4zm162.7-84.1c-24.4-31.4-62.1-51.9-105.1-51.9-10.2 0-26 9.6-57.6 9.6-31.5 0-47.4-9.6-57.6-9.6-42.9 0-80.6 20.5-105.1 51.9C61.9 339.2 48 299.2 48 256c0-110.3 89.7-200 200-200s200 89.7 200 200c0 43.2-13.9 83.2-37.3 115.9z"></path></svg>
                    <div>
                        <p class="no-margin fs13">{{__('New members')}}: {{ \App\Models\User::today()->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>