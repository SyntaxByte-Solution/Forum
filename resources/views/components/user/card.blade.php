

<!-- 
    the div wrapper is defined in faded card, so when the user hover over the displayer this component will be put into the card wrapper
    <div class="user-profile-card none opacity0"> 
-->
<div class="flex">
    <div class="relative us-user-media-container full-width">
        <div class="us-cover-container full-center" style="height: 74px; border-radius: 6px 6px 0 0">
            <img src="{{ $user->cover }}"  class="us-cover" alt="">
        </div>
        <div class="us-after-cover-section flex" style="margin-left: 20px; margin-top: -36px">
            <div style="padding: 6px; background-color: white;" class="rounded">
                <a href="{{ route('user.profile', ['user'=>$user->username]) }}">
                    <div class="size60 full-center rounded hidden-overflow">
                        <img src="{{ $user->sizedavatar(100) }}" class="handle-image-center-positioning card-user-avatar" alt="">
                    </div>
                </a>
            </div>
            <div class="ms-profile-infos-container" style="margin: 38px 0 0 6px;">
                <div class="flex align-center">
                    <a href="{{ $user->profilelink }}" class="no-underline blue">
                        <h4 class="no-margin flex align-center">
                            {{ $user->firstname . ' ' . $user->lastname }}
                        </h4>
                    </a>
                    <div class="ml4" title="@if($activestatus == 'active') {{ __('Online') }} @else {{ __('Offline') }} @endif">
                        @if($activestatus == 'active')
                        <svg class="tiny-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#25BD54"/></svg>
                        @else
                        <svg class="tiny-image mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Z" style="fill:#919191"/></svg>
                        @endif
                    </div>
                </div>
                <p class="fs12 bold no-margin">[{{ $user->username }}]</p>
            </div>
        </div>
        @if($user->about)
        <div>
            <div class="flex space-between mx4">
                <svg class="size20 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M141,512a7.49,7.49,0,0,1-7.49-7.49V464.08a7.49,7.49,0,1,1,15,0v40.43A7.48,7.48,0,0,1,141,512Zm0-70.38a7.49,7.49,0,0,1-7.49-7.49V348.92c-14.09,8.17-25.22,5.56-31.71-.93-5.53-5.53-7.31-13.34-5-22a43,43,0,0,1,5.9-12.6,43.81,43.81,0,0,1-12.83-4.57c-7.9-4.49-12.25-11.32-12.25-19.23s4.35-14.74,12.25-19.22a43.81,43.81,0,0,1,12.83-4.58,42.88,42.88,0,0,1-5.9-12.6,24.87,24.87,0,0,1-.26-12.87,66.82,66.82,0,0,0-6.24-8.06A69.19,69.19,0,0,1,1.41,212.71a7.5,7.5,0,0,1,3.15-11.27C41,186,83.09,197.39,106.06,227.93a20.78,20.78,0,0,1,7.5-2.5,7.49,7.49,0,0,1,2,14.85,5.18,5.18,0,0,0-3.18,1.53c-3.92,3.92-.51,13.05,8.28,22.64a104.17,104.17,0,0,1,16,1.6,107.23,107.23,0,0,1-1.64-19c0-11.29,2.07-20.9,6-27.78,4.49-7.9,11.31-12.26,19.22-12.26s14.74,4.36,19.23,12.26a43.74,43.74,0,0,1,4.57,12.82,43.09,43.09,0,0,1,12.62-5.9c8.64-2.3,16.44-.52,22,5s7.31,13.34,5,22a43.09,43.09,0,0,1-5.89,12.6,43.85,43.85,0,0,1,12.82,4.58c7.9,4.48,12.26,11.31,12.26,19.22s-4.36,14.74-12.26,19.23a43.84,43.84,0,0,1-12.82,4.57,43.21,43.21,0,0,1,5.89,12.6c2.31,8.65.53,16.46-5,22s-13.33,7.3-22,5a43.09,43.09,0,0,1-12.62-5.9,43.64,43.64,0,0,1-4.57,12.82c-4.49,7.91-11.31,12.26-19.22,12.26a20.11,20.11,0,0,1-11.71-3.7v65.66a7.49,7.49,0,0,1-7.48,7.49ZM147.26,295a7.49,7.49,0,0,1,7,10.25c-2.78,7-4.3,16.55-4.3,26.89,0,14.53,4.29,25.07,10.22,25.07s10.21-10.54,10.21-25.07c0-10.35-1.52-19.9-4.3-26.89a7.49,7.49,0,0,1,9.72-9.72c7,2.77,16.55,4.3,26.9,4.3,14.52,0,25.06-4.3,25.06-10.22s-10.54-10.22-25.06-10.22c-10.35,0-19.9,1.53-26.9,4.31a7.49,7.49,0,0,1-9.72-9.72c2.78-7,4.3-16.55,4.3-26.9,0-14.52-4.29-25.06-10.22-25.06s-10.21,10.54-10.21,25.06c0,10.35,1.52,19.9,4.3,26.9a7.49,7.49,0,0,1-9.72,9.72c-7-2.78-16.55-4.31-26.9-4.31-14.52,0-25.06,4.3-25.06,10.22s10.54,10.22,25.06,10.22c10.35,0,19.91-1.53,26.9-4.3a7.36,7.36,0,0,1,2.76-.53Zm38,34.12c9.59,8.8,18.72,12.21,22.64,8.29s.51-13-8.28-22.64a105.57,105.57,0,0,1-16-1.6A104.17,104.17,0,0,1,185.29,329.11Zm-50.31,0a105.44,105.44,0,0,1,1.6-15.95,105.44,105.44,0,0,1-16,1.6c-8.79,9.59-12.2,18.72-8.28,22.64s13,.51,22.64-8.28Zm50.31-79a104.3,104.3,0,0,1-1.6,16,104.3,104.3,0,0,1,16-1.6c8.79-9.59,12.2-18.73,8.28-22.65s-13.05-.5-22.64,8.29ZM20.51,211.79A54.33,54.33,0,0,0,78,221.6,71,71,0,0,0,20.51,211.79ZM289.6,242.7c-7.91,0-14.74-4.35-19.22-12.25a43.61,43.61,0,0,1-4.57-12.8c-15.46,10.31-27.66,7.8-34.59.87-5.53-5.53-7.31-13.34-5-22a43.33,43.33,0,0,1,5.89-12.6,43.74,43.74,0,0,1-12.82-4.57c-7.9-4.49-12.26-11.31-12.26-19.22s4.36-14.74,12.26-19.23a43.74,43.74,0,0,1,12.82-4.57,43.33,43.33,0,0,1-5.89-12.6c-1.76-6.6-1.15-12.71,1.7-17.69a82.3,82.3,0,0,1-10.48-9.43l-.23-.25a84.76,84.76,0,0,1-18.87-32.86,86.36,86.36,0,0,1,3.1-58.95,7.5,7.5,0,0,1,11.27-3.15c28,20.14,36.06,58.84,19.57,88.83a67.1,67.1,0,0,0,8,6.23c6.75-1.84,15.44-.57,25.51,6.15a43.71,43.71,0,0,1,4.57-12.8c4.48-7.9,11.31-12.25,19.22-12.25s14.74,4.35,19.23,12.25c3.9,6.89,6,16.49,6,27.79a107,107,0,0,1-1.64,19,105.44,105.44,0,0,1,15.95-1.6c8.8-9.59,12.21-18.72,8.29-22.64a5.26,5.26,0,0,0-3.19-1.53,7.49,7.49,0,1,1,2-14.84A20.34,20.34,0,0,1,348,101.75c5.53,5.53,7.3,13.34,5,22a40.4,40.4,0,0,1-4.12,9.72H504.51a7.49,7.49,0,1,1,0,15h-136a20.06,20.06,0,0,1,3.7,11.7c0,7.91-4.35,14.74-12.25,19.22a43.52,43.52,0,0,1-12.83,4.57,43,43,0,0,1,5.9,12.61c2.3,8.64.53,16.45-5,22s-13.34,7.31-22,5a43.3,43.3,0,0,1-12.61-5.9,44.13,44.13,0,0,1-4.57,12.82c-4.49,7.9-11.32,12.25-19.23,12.25Zm-12.87-77.18a7.5,7.5,0,0,1,7,10.25c-2.78,7-4.31,16.55-4.31,26.9,0,14.52,4.3,25.06,10.22,25.06s10.22-10.54,10.22-25.06c0-10.35-1.53-19.9-4.3-26.9a7.49,7.49,0,0,1,9.72-9.72c7,2.78,16.54,4.31,26.89,4.31,14.52,0,25.06-4.3,25.06-10.22s-10.54-10.22-25.06-10.22c-10.35,0-19.9,1.52-26.89,4.3a7.48,7.48,0,0,1-9.72-9.72c2.77-7,4.3-16.55,4.3-26.89,0-14.53-4.3-25.07-10.22-25.07s-10.22,10.54-10.22,25.07c0,10.34,1.53,19.89,4.31,26.89a7.49,7.49,0,0,1-9.72,9.72c-7-2.78-16.55-4.3-26.9-4.3-14.52,0-25.06,4.3-25.06,10.22s10.54,10.22,25.06,10.22c10.35,0,19.9-1.53,26.9-4.31a7.56,7.56,0,0,1,2.76-.53Zm38,34.13c9.59,8.79,18.72,12.2,22.64,8.28s.51-13.05-8.28-22.64a105.44,105.44,0,0,1-16-1.6A105.57,105.57,0,0,1,314.76,199.65Zm-64.67-14.36c-8.79,9.59-12.2,18.72-8.28,22.64s13.05.51,22.64-8.28a104.3,104.3,0,0,1,1.6-16,104.3,104.3,0,0,1-16,1.6Zm0-50.31a105.57,105.57,0,0,1,16,1.6,104.3,104.3,0,0,1-1.6-16c-9.59-8.79-18.73-12.2-22.65-8.28s-.5,13,8.29,22.64ZM211.81,20.53a71.61,71.61,0,0,0,9.83,57.36A54.35,54.35,0,0,0,211.81,20.53ZM123.39,206c-7.91,0-14.74-4.35-19.22-12.25a43.71,43.71,0,0,1-4.57-12.8c-15.46,10.31-27.66,7.8-34.59.87-5.53-5.53-7.31-13.34-5-22a43.33,43.33,0,0,1,5.89-12.6,43.74,43.74,0,0,1-12.82-4.57c-7.9-4.49-12.26-11.31-12.26-19.23s4.36-14.74,12.26-19.22A43.74,43.74,0,0,1,65.9,99.6,43.33,43.33,0,0,1,60,87c-2.31-8.65-.53-16.46,5-22,6.93-6.93,19.13-9.44,34.59.87a43.61,43.61,0,0,1,4.57-12.8c4.48-7.9,11.31-12.25,19.22-12.25s14.74,4.35,19.23,12.25a43.6,43.6,0,0,1,4.56,12.8c15.46-10.31,27.67-7.8,34.6-.87,5.53,5.53,7.3,13.34,5,22a43.11,43.11,0,0,1-5.9,12.6,43.81,43.81,0,0,1,12.83,4.57c7.9,4.48,12.25,11.31,12.25,19.22s-4.35,14.74-12.25,19.23a43.81,43.81,0,0,1-12.83,4.57,43,43,0,0,1,5.9,12.6c2.31,8.65.53,16.46-5,22-6.93,6.93-19.14,9.44-34.6-.87a43.71,43.71,0,0,1-4.56,12.8c-4.49,7.9-11.32,12.25-19.23,12.25Zm-12.87-77.18a7.49,7.49,0,0,1,7,10.25c-2.78,7-4.31,16.55-4.31,26.9,0,14.52,4.3,25.06,10.22,25.06s10.22-10.54,10.22-25.06c0-10.35-1.53-19.91-4.3-26.9a7.48,7.48,0,0,1,9.72-9.72c7,2.77,16.54,4.3,26.89,4.3,14.53,0,25.06-4.29,25.06-10.22s-10.54-10.22-25.06-10.22c-10.35,0-19.9,1.53-26.89,4.31a7.49,7.49,0,0,1-9.72-9.72c2.77-7,4.3-16.55,4.3-26.9,0-14.52-4.3-25.06-10.22-25.06s-10.22,10.54-10.22,25.06c0,10.35,1.53,19.9,4.31,26.9a7.49,7.49,0,0,1-9.72,9.72c-7-2.78-16.55-4.31-26.9-4.31-14.52,0-25.06,4.3-25.06,10.22s10.54,10.22,25.06,10.22c10.35,0,19.9-1.53,26.9-4.3A7.36,7.36,0,0,1,110.52,128.78ZM83.88,148.55c-8.79,9.59-12.2,18.72-8.28,22.64s13.05.51,22.64-8.28a104.3,104.3,0,0,1,1.6-16,105.57,105.57,0,0,1-16,1.6Zm64.67,14.36c9.59,8.79,18.72,12.2,22.64,8.28s.51-13.05-8.28-22.64a105.57,105.57,0,0,1-16-1.6,105.44,105.44,0,0,1,1.6,16Zm0-79a105.57,105.57,0,0,1-1.6,16,104.17,104.17,0,0,1,16-1.6c8.8-9.59,12.21-18.72,8.29-22.64S158.14,75.09,148.55,83.88ZM83.88,98.24a104.3,104.3,0,0,1,16,1.6,104.3,104.3,0,0,1-1.6-16c-9.59-8.79-18.72-12.2-22.65-8.28S75.09,88.65,83.88,98.24Z"/></svg>
                <svg class="size20 ml4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M371.05,512a7.49,7.49,0,0,0,7.49-7.49V464.08a7.49,7.49,0,0,0-15,0v40.43A7.49,7.49,0,0,0,371.05,512Zm0-70.38a7.49,7.49,0,0,0,7.49-7.49V348.92c14.09,8.17,25.22,5.56,31.71-.93,5.53-5.53,7.3-13.34,5-22a43,43,0,0,0-5.9-12.6,43.81,43.81,0,0,0,12.83-4.57c7.9-4.49,12.25-11.32,12.25-19.23s-4.35-14.74-12.25-19.22a43.81,43.81,0,0,0-12.83-4.58,42.88,42.88,0,0,0,5.9-12.6,24.87,24.87,0,0,0,.26-12.87,66.82,66.82,0,0,1,6.24-8.06,69.19,69.19,0,0,0,88.84-19.56,7.5,7.5,0,0,0-3.15-11.27C471,186,428.91,197.39,405.94,227.93a20.78,20.78,0,0,0-7.5-2.5,7.49,7.49,0,0,0-2,14.85,5.18,5.18,0,0,1,3.18,1.53c3.92,3.92.51,13.05-8.29,22.64a104,104,0,0,0-15.95,1.6,107.23,107.23,0,0,0,1.64-19c0-11.29-2.07-20.9-6-27.78-4.49-7.9-11.31-12.26-19.23-12.26s-14.74,4.36-19.22,12.26a43.74,43.74,0,0,0-4.57,12.82,43.09,43.09,0,0,0-12.62-5.9c-8.64-2.3-16.44-.52-22,5s-7.31,13.34-5,22a43.09,43.09,0,0,0,5.89,12.6,43.74,43.74,0,0,0-12.82,4.58c-7.9,4.48-12.26,11.31-12.26,19.22s4.36,14.74,12.26,19.23a43.74,43.74,0,0,0,12.82,4.57,43,43,0,0,0-5.89,12.6c-2.31,8.65-.53,16.46,5,22s13.33,7.3,22,5a43.09,43.09,0,0,0,12.62-5.9,43.64,43.64,0,0,0,4.57,12.82c4.48,7.91,11.31,12.26,19.22,12.26a20.11,20.11,0,0,0,11.71-3.7v65.66a7.48,7.48,0,0,0,7.48,7.49ZM364.74,295a7.48,7.48,0,0,0-7,10.25c2.77,7,4.3,16.55,4.3,26.89,0,14.53-4.3,25.07-10.22,25.07s-10.22-10.54-10.22-25.07c0-10.35,1.53-19.9,4.31-26.89a7.49,7.49,0,0,0-9.72-9.72c-7,2.77-16.55,4.3-26.9,4.3-14.52,0-25.06-4.3-25.06-10.22s10.54-10.22,25.06-10.22c10.35,0,19.9,1.53,26.9,4.31A7.49,7.49,0,0,0,346,274c-2.78-7-4.31-16.55-4.31-26.9,0-14.52,4.3-25.06,10.22-25.06s10.22,10.54,10.22,25.06c0,10.35-1.53,19.9-4.3,26.9a7.49,7.49,0,0,0,9.72,9.72c7-2.78,16.55-4.31,26.89-4.31,14.53,0,25.07,4.3,25.07,10.22s-10.54,10.22-25.07,10.22c-10.34,0-19.9-1.53-26.89-4.3a7.4,7.4,0,0,0-2.76-.53Zm-38,34.12c-9.59,8.8-18.72,12.21-22.64,8.29s-.51-13,8.28-22.64a105.57,105.57,0,0,0,16-1.6A104.17,104.17,0,0,0,326.71,329.11Zm50.31,0a105.44,105.44,0,0,0-1.6-15.95,105.31,105.31,0,0,0,15.95,1.6c8.8,9.59,12.21,18.72,8.29,22.64s-13.05.51-22.64-8.28Zm-50.31-79a104.3,104.3,0,0,0,1.6,16,104.3,104.3,0,0,0-16-1.6c-8.79-9.59-12.2-18.73-8.28-22.65s13.05-.5,22.64,8.29Zm164.78-38.3A54.33,54.33,0,0,1,434,221.6,71,71,0,0,1,491.49,211.79ZM222.4,242.7c7.91,0,14.74-4.35,19.22-12.25a43.89,43.89,0,0,0,4.57-12.8c15.46,10.31,27.66,7.8,34.59.87,5.53-5.53,7.31-13.34,5-22a43.11,43.11,0,0,0-5.9-12.6,43.81,43.81,0,0,0,12.83-4.57c7.9-4.49,12.26-11.31,12.26-19.22s-4.36-14.74-12.26-19.23a43.81,43.81,0,0,0-12.83-4.57,43.11,43.11,0,0,0,5.9-12.6c1.76-6.6,1.14-12.71-1.7-17.69a83,83,0,0,0,10.48-9.43l.23-.25a84.76,84.76,0,0,0,18.87-32.86,86.41,86.41,0,0,0-3.1-58.95,7.5,7.5,0,0,0-11.27-3.15c-28,20.14-36.06,58.84-19.57,88.83a67.1,67.1,0,0,1-8,6.23c-6.75-1.84-15.44-.57-25.51,6.15a43.71,43.71,0,0,0-4.57-12.8c-4.48-7.9-11.31-12.25-19.22-12.25s-14.74,4.35-19.23,12.25c-3.9,6.89-6,16.49-6,27.79a107,107,0,0,0,1.64,19,105.44,105.44,0,0,0-16-1.6c-8.79-9.59-12.2-18.72-8.28-22.64a5.23,5.23,0,0,1,3.18-1.53,7.48,7.48,0,1,0-2-14.84A20.34,20.34,0,0,0,164,101.75c-5.53,5.53-7.3,13.34-5,22a40.4,40.4,0,0,0,4.12,9.72H7.49a7.49,7.49,0,0,0,0,15h136a20,20,0,0,0-3.7,11.7c0,7.91,4.35,14.74,12.25,19.22a43.52,43.52,0,0,0,12.83,4.57,43,43,0,0,0-5.9,12.61c-2.31,8.64-.53,16.45,5,22s13.33,7.31,22,5a43.3,43.3,0,0,0,12.61-5.9,43.84,43.84,0,0,0,4.57,12.82c4.49,7.9,11.32,12.25,19.23,12.25Zm12.87-77.18a7.5,7.5,0,0,0-7,10.25c2.78,7,4.31,16.55,4.31,26.9,0,14.52-4.3,25.06-10.22,25.06s-10.22-10.54-10.22-25.06c0-10.35,1.53-19.9,4.3-26.9a7.49,7.49,0,0,0-9.72-9.72c-7,2.78-16.55,4.31-26.89,4.31-14.53,0-25.07-4.3-25.07-10.22s10.55-10.22,25.07-10.22c10.34,0,19.9,1.52,26.89,4.3a7.48,7.48,0,0,0,9.72-9.72c-2.77-7-4.3-16.55-4.3-26.89,0-14.53,4.3-25.07,10.22-25.07s10.22,10.54,10.22,25.07c0,10.34-1.53,19.89-4.31,26.89a7.49,7.49,0,0,0,9.72,9.72c7-2.78,16.55-4.3,26.9-4.3,14.52,0,25.06,4.3,25.06,10.22s-10.54,10.22-25.06,10.22c-10.35,0-19.9-1.53-26.9-4.31a7.56,7.56,0,0,0-2.76-.53Zm-38,34.13c-9.59,8.79-18.72,12.2-22.64,8.28s-.51-13.05,8.28-22.64a105.57,105.57,0,0,0,16-1.6A105.57,105.57,0,0,0,197.24,199.65Zm64.67-14.36c8.79,9.59,12.2,18.72,8.28,22.64s-13.05.51-22.64-8.28a104.3,104.3,0,0,0-1.6-16,104.3,104.3,0,0,0,16,1.6Zm0-50.31a105.57,105.57,0,0,0-16,1.6,104.3,104.3,0,0,0,1.6-16c9.59-8.79,18.72-12.2,22.64-8.28s.51,13-8.28,22.64ZM300.19,20.53a71.61,71.61,0,0,1-9.83,57.36A54.33,54.33,0,0,1,300.19,20.53ZM388.61,206c7.91,0,14.74-4.35,19.22-12.25a44,44,0,0,0,4.57-12.8c15.46,10.31,27.66,7.8,34.59.87,5.53-5.53,7.31-13.34,5-22a43.33,43.33,0,0,0-5.89-12.6,43.84,43.84,0,0,0,12.82-4.57c7.9-4.49,12.25-11.31,12.25-19.23s-4.35-14.74-12.25-19.22A43.84,43.84,0,0,0,446.1,99.6,43.33,43.33,0,0,0,452,87c2.31-8.65.53-16.46-5-22-6.93-6.93-19.14-9.44-34.59.87a43.89,43.89,0,0,0-4.57-12.8c-4.48-7.9-11.31-12.25-19.22-12.25s-14.74,4.35-19.23,12.25a43.89,43.89,0,0,0-4.57,12.8c-15.45-10.31-27.66-7.8-34.59-.87-5.53,5.53-7.31,13.34-5,22a43.11,43.11,0,0,0,5.9,12.6,43.81,43.81,0,0,0-12.83,4.57c-7.9,4.48-12.25,11.31-12.25,19.22s4.35,14.74,12.25,19.23a43.81,43.81,0,0,0,12.83,4.57,43,43,0,0,0-5.9,12.6c-2.31,8.65-.53,16.46,5,22,6.93,6.93,19.14,9.44,34.59-.87a44,44,0,0,0,4.57,12.8c4.49,7.9,11.31,12.25,19.23,12.25Zm12.87-77.18a7.49,7.49,0,0,0-7,10.25c2.78,7,4.31,16.55,4.31,26.9,0,14.52-4.3,25.06-10.22,25.06s-10.22-10.54-10.22-25.06c0-10.35,1.52-19.91,4.3-26.9a7.48,7.48,0,0,0-9.72-9.72c-7,2.77-16.55,4.3-26.89,4.3-14.53,0-25.07-4.29-25.07-10.22s10.54-10.22,25.07-10.22c10.34,0,19.9,1.53,26.89,4.31a7.49,7.49,0,0,0,9.72-9.72c-2.77-7-4.3-16.55-4.3-26.9,0-14.52,4.3-25.06,10.22-25.06s10.22,10.54,10.22,25.06c0,10.35-1.53,19.9-4.31,26.9a7.49,7.49,0,0,0,9.72,9.72c7-2.78,16.55-4.31,26.9-4.31,14.52,0,25.06,4.3,25.06,10.22s-10.54,10.22-25.06,10.22c-10.35,0-19.9-1.53-26.9-4.3A7.36,7.36,0,0,0,401.48,128.78Zm26.64,19.77c8.79,9.59,12.2,18.72,8.28,22.64s-13,.51-22.64-8.28a104.3,104.3,0,0,0-1.6-16,105.57,105.57,0,0,0,16,1.6Zm-64.67,14.36c-9.59,8.79-18.72,12.2-22.64,8.28s-.51-13.05,8.28-22.64a105.57,105.57,0,0,0,16-1.6,105.44,105.44,0,0,0-1.6,16Zm0-79a105.57,105.57,0,0,0,1.6,16,104.3,104.3,0,0,0-16-1.6c-8.79-9.59-12.2-18.72-8.28-22.64S353.86,75.09,363.45,83.88Zm64.67,14.36a104.3,104.3,0,0,0-16,1.6,104.3,104.3,0,0,0,1.6-16c9.59-8.79,18.72-12.2,22.64-8.28S436.91,88.65,428.12,98.24Z"/></svg>
            </div>
            <em class="block move-to-middle fs13 mb4 text-center" style="width: calc(100% - 50px); margin-top: -10px">{{ $user->aboutmin }}</em>
            <div class="gray full-center my4 fs10 unselectable">•</div>
        </div>
        @endif
        <div class="mt4 px8">
            <div class="flex align-center">
                <div class="flex align-center my4 fs12 black">
                    <span class="gray">{{ __('Member since') }}:</span>
                    <svg class="size14 ml4 mx8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 559.98 559.98"><path d="M280,0C125.6,0,0,125.6,0,280S125.6,560,280,560s280-125.6,280-280S434.38,0,280,0Zm0,498.78C159.35,498.78,61.2,400.63,61.2,280S159.35,61.2,280,61.2,498.78,159.35,498.78,280,400.63,498.78,280,498.78Zm24.24-218.45V163a23.72,23.72,0,0,0-47.44,0V287.9c0,.38.09.73.11,1.1a23.62,23.62,0,0,0,6.83,17.93l88.35,88.33a23.72,23.72,0,1,0,33.54-33.54Z"/></svg>
                    <span class="fs12">{{ (new \Carbon\Carbon($user->created_at))->toFormattedDateString() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="user-container-line-separator"></div>
<div class="px8 pb8">
    <div class="flex">
        <div class="half-width" style="margin-right: 14px">
            <div>
                <div class="flex align-center space-between">
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M384.72,275.71l-21.2,21.21-21.21-21.21,84.83-84.84-42.41-42.41,21.2-21.21,21.21,21.21,63.63-63.63L427.14,21.21,363.52,84.83,384.73,106l-21.21,21.21L321.1,84.83l-84.83,84.84-21.21-21.21,21.21-21.21L109,0,3,106,130.22,233.29l21.21-21.21,21.21,21.21-42.42,42.42,42.41,42.42-24.92,24.95a105.13,105.13,0,0,0-137.08,9.86L0,363.54l63.62,63.63-53,53L31.84,501.4l53-53L148.48,512l10.61-10.61a105.12,105.12,0,0,0,9.83-137.1l24.93-25,42.42,42.42,42.41-42.42,21.21,21.21-21.21,21.21L405.93,509,512,403ZM427.14,63.63l21.21,21.2L427.14,106,405.93,84.83ZM147.42,468.52,43.51,364.61A75,75,0,0,1,147.42,468.52Zm237.3-150.39,31.82,31.81-21.21,21.21-31.81-31.82ZM215.06,190.88l-21.21,21.2-21.21-21.2,21.21-21.21ZM109,42.42l31.81,31.81L119.62,95.44,87.81,63.63ZM45.39,106,66.6,84.83l31.81,31.82L77.2,137.86Zm84.83,84.84L98.41,159.06l21.21-21.21,31.81,31.82Zm42.42-42.42-31.81-31.81L162,95.44l31.81,31.81Zm63.63,190.87-63.63-63.62L321.1,127.25l63.63,63.63Zm63.62-21.2,21.21-21.21,21.21,21.21-21.21,21.2Zm21.21,63.62,21.21-21.21,31.81,31.81-21.21,21.21Zm84.83,84.83-31.81-31.81,21.21-21.21,31.81,31.82Zm10.61-74.23,21.2-21.2L469.56,403l-21.21,21.21Z"/></svg>
                        <p class="inline-block my4 fs13 black">{{__('Reach')}}: </p>
                    </div>
                    <span class="fs15 bold ml4">{{ $user->reachcount }}</span>
                </div>
            </div>
            <div class="mt4">
                <div class="flex align-center space-between">
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M492.21,3.82a21.45,21.45,0,0,0-22.79-1l-448,256a21.34,21.34,0,0,0,3.84,38.77L171.77,346.4l9.6,145.67a21.3,21.3,0,0,0,15.48,19.12,22,22,0,0,0,5.81.81,21.37,21.37,0,0,0,17.41-9l80.51-113.67,108.68,36.23a21,21,0,0,0,6.74,1.11,21.39,21.39,0,0,0,21.06-17.84l64-384A21.31,21.31,0,0,0,492.21,3.82ZM184.55,305.7,84,272.18,367.7,110.06ZM220,429.28,215.5,361l42.8,14.28Zm179.08-52.07-170-56.67L447.38,87.4Z"/></svg>
                        <p class="inline-block my4 fs13 black">{{ __('Discussions') }}: </p>
                    </div>
                    <span class="fs15 bold ml4">{{ $user->threads()->count() }}</span>
                </div>
            </div>
        </div>
        <div class="half-width">
            <div>
                <div class="flex align-center">
                    <svg class="size12 mr4" style="min-width: 14px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g id="Layer_1_copy" data-name="Layer 1 copy"><path d="M287.81,219.72h-238c-21.4,0-32.1-30.07-17-47.61l119-138.2c9.4-10.91,24.6-10.91,33.9,0l119,138.2C319.91,189.65,309.21,219.72,287.81,219.72ZM224.22,292l238,.56c21.4,0,32,30.26,16.92,47.83L359.89,478.86c-9.41,10.93-24.61,10.9-33.9-.08l-118.75-139C192.07,322.15,202.82,292,224.22,292Z" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:49px"/></g></svg>
                    <div class="flex align-center my4">
                        <div class="inline-block fs13 black width-max-content">{{ __('Votes') }}: </div>
                        <span class="fs15 bold ml4">{{ $user->threadsvotes()->count() }}</span>
                    </div>
                    <div class="fill-thin-line"></div>
                    <div class="relative size14" style="margin-left: auto">
                        <svg class="size14 pointer button-with-suboptions" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,0C114.5,0,0,114.51,0,256S114.51,512,256,512,512,397.49,512,256,397.49,0,256,0Zm0,472A216,216,0,1,1,472,256,215.88,215.88,0,0,1,256,472Zm0-257.67a20,20,0,0,0-20,20V363.12a20,20,0,0,0,40,0V234.33A20,20,0,0,0,256,214.33Zm0-78.49a27,27,0,1,1-27,27A27,27,0,0,1,256,135.84Z"/></svg>
                        <div class="suboptions-container simple-information-suboptions-container" style="width: 200px; top: unset; bottom: calc(100% + 4px); padding: 4px 25px 4px 5px">
                            <!-- container closer -->
                            <div class="closer-style fill-opacity-style hide-parent">
                                <svg class="size14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm0,448A200,200,0,1,1,456,256,199.94,199.94,0,0,1,256,456ZM357.8,193.8,295.6,256l62.2,62.2a12,12,0,0,1,0,17l-22.6,22.6a12,12,0,0,1-17,0L256,295.6l-62.2,62.2a12,12,0,0,1-17,0l-22.6-22.6a12,12,0,0,1,0-17L216.4,256l-62.2-62.2a12,12,0,0,1,0-17l22.6-22.6a12,12,0,0,1,17,0L256,216.4l62.2-62.2a12,12,0,0,1,17,0l22.6,22.6a12,12,0,0,1,0,17Z"/></svg>
                            </div>
                            <div class="flex align-center">
                                <svg class="mr4" style="width: 3px; height: 3px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.11 29.11"><image width="30" height="30" transform="translate(0 -0.89)" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsSAAALEgHS3X78AAAAp0lEQVRIS+2XQRaAIAhEB+5/Z1pRhmj2Etj0d/pyvsMqSUTwBiLqDogIed/OoBWxJ5uxcpGp+K3QMruAK/4qbBnJ2W7slALjvJt4t1Txck9xlFSx+d2oI2nlbDeySG0MXCW5oi1Q0FgpExOAf9Qp/OIURIRKxEBRYwDglf+jCNIba1FuF9G0nvTGyimObm3zb42j5F5uN+rd8lFe2EviqcD2t9OTUDkArQVWIcCC1LoAAAAASUVORK5CYII="/></svg>
                                <p class="no-margin fs13">{{ __('Votes include only thread votes') }}.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt4">
                <div class="flex align-center space-between">
                    <div class="flex align-center">
                        <svg class="size14 mr4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M221.09,253a23,23,0,1,1-23.27,23A23.13,23.13,0,0,1,221.09,253Zm93.09,0a23,23,0,1,1-23.27,23A23.12,23.12,0,0,1,314.18,253Zm93.09,0A23,23,0,1,1,384,276,23.13,23.13,0,0,1,407.27,253Zm62.84-137.94h-51.2V42.9c0-23.62-19.38-42.76-43.29-42.76H43.29C19.38.14,0,19.28,0,42.9V302.23C0,325.85,19.38,345,43.29,345h73.07v50.58c.13,22.81,18.81,41.26,41.89,41.39H332.33l16.76,52.18a32.66,32.66,0,0,0,26.07,23H381A32.4,32.4,0,0,0,408.9,496.5L431,437h39.1c23.08-.13,41.76-18.58,41.89-41.39V156.47C511.87,133.67,493.19,115.21,470.11,115.09ZM46.55,299V46.12H372.36v69H158.25c-23.08.12-41.76,18.58-41.89,41.38V299Zm418.9,92H397.5l-15.83,46-15.82-46H162.91V161.07H465.45Z"/></svg>
                        <p class="inline-block my4 fs13 black">{{__('Replies')}}: </p>
                    </div>
                    <span class="fs15 bold ml8">{{ $user->posts()->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>