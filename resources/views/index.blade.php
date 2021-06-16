@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/left-panel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/right-panel.css') }}" rel="stylesheet">
@endpush

@section('header')
    @guest
        @include('partials.hidden-login-viewer')
    @endguest
    
    @include('partials.header')
@endsection

@section('content')
    @include('partials.left-panel', ['page' => 'home'])
    <div id="middle-container" class="middle-padding-1 flex">
        <div class="full-width">
            <div class="full-center">
                <img src="{{ asset('assets/images/logos/b-large-logo.png') }}" class="half-width" alt="">
            </div>
            <div>
                <div class="flex space-between align-end">
                    <div>
                        <h2 class="my8 fs20 forum-color">TOP Questions & Discussions</h2>
                        <p class="fs12 no-margin mt8" style="margin-bottom: 2px">{{ __('Search for everything (users, threads, questions, posts ..)') }}</p>
                        <div class="flex align-center">
                            <div>
                                <form action="" method='get'>
                                    <input type="text" name="k" class="input-style-2" placeholder="Search everything .." required>
                                    <input type="submit" value="" class="search-forum-button" style="margin-left: -8px">
                                </form>
                            </div>
                            <a href="" class="ml4">
                                <img src="{{ asset('assets/images/icons/bsettings.png') }}" class="adv-search-button" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="mr8">
                        <div class="flex align-center">
                            <a href="/" class="pagination-item pag-active @if(!request()->has('tab')) pagination-item-selected @endif bold">Interesting</a>
                            <a href="?tab=today" class="pagination-item pag-active bold @if($t = request()->has('tab')) @if(request()->get('tab') == 'today') pagination-item-selected @endif @endif">Today</a>
                            <a href="?tab=thisweek" class="pagination-item pag-active bold @if($t = request()->has('tab')) @if(request()->get('tab') == 'thisweek') pagination-item-selected @endif @endif">This week</a>
                        </div>
                        <div class="simple-half-line-separator my4 move-to-right"></div>
                        <div class="flex">
                            <div class="move-to-right">
                                {{ $threads->onEachSide(0)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <table class="forums-table">
                    <tr>
                        <th class="table-col-header">
                            <div class="flex align-center">
                                {{ __('THREADS') }} ({{$threads->count()}} {{__('in total')}})
                                <div class="inline-block move-to-right mr4">
                                    <div class="flex align-center">
                                        <div class="flex align-center mr8">
                                            <p class="gray fs11 no-margin mr4">Forum: </p>
                                            <div class="relative">
                                                <a href="{{ route('forum.misc', ['forum'=>'general']) }}" class="mr4 button-right-icon more-icon button-with-suboptions">{{ __('All') }}</a>
                                                <div class="suboptions-container suboptions-buttons-b-style" style="top: 16px">
                                                    @foreach($forums as $forum)
                                                        <a href="{{ route('forum.misc', ['forum'=>$forum->slug]) }}" class="suboption-b-style">{{ $forum->forum }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex align-center">
                                            <span>rows: </span>
                                            <select name="" class="small-dropdown row-num-changer">
                                                <option value="10" @if($pagesize == 10) selected @endif>10</option>
                                                <option value="20" @if($pagesize == 20) selected @endif>20</option>
                                                <option value="50" @if($pagesize == 50) selected @endif>50</option>
                                                <option value="100" @if($pagesize == 100) selected @endif>50</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th class="table-col-header table-numbered-column">{{ __('REPLIES/VIEWS') }}</th>
                        <th class="table-col-header table-last-post">{{ __('LAST POST') }}</th>
                    </tr>
                    @foreach($threads as $thread)
                        <x-index-resource :thread="$thread"/>
                    @endforeach
                </table>
                @if(!$threads->count())
                    <div class="full-center">
                        <div>
                            <p class="fs20 bold gray" style="margin-bottom: 2px">{{ __("There are no threads for the moment try out later !") }}</p>
                            <p class="my4 text-center">{{ __("Try to create a ") }} <a href="{{ route('discussion.add', ['forum'=>'general']) }}" class="link-path">{{__('discussion')}}</a> / <a href="{{ route('question.add', ['forum'=>'general']) }}" class="link-path">{{__('question')}}</a></p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="flex my8">
                <div class="move-to-right">
                    {{ $threads->onEachSide(0)->links() }}
                </div>
            </div>
        </div>
        <div class="index-right-panel-container border-box">
            <div class="index-right-panel">
                <div class="flex align-center mx8">
                    <div class="flex align-center">
                        <img src="{{ asset('assets/images/icons/community.svg') }}" class="small-image mr4" alt="">
                        <p class="bold my8">{{ __('Forums') }}</p>
                    </div>
                    <div class="move-to-right">
                        <a href="/forums" class="link-style">see all</a>
                    </div>
                </div>
                <div class="simple-line-separator mb8"></div>
                <div class="ml8">
                    @foreach($forums as $forum)
                    <div class="my8">
                        <div class="flex align-center bold toggle-container-button pointer">
                            {{ $forum->forum }}
                            <span class="toggle-arrow">▸</span>
                            <a href="{{ route('forum.misc', ['forum'=>$forum->slug]) }}" class="stop-propagation move-to-right link-style fs13 mr8">visit</a>
                        </div>
                        <div class="toggle-container ml8">
                            @foreach($forum->categories as $category)
                            <div class="my8">
                                <a href="{{ route('category.misc', ['forum'=>$forum->slug, 'category'=>$category->slug]) }}" class="blue fs13 no-underline">{{ $category->category }}</a>
                            </div>
                            @endforeach
                        </div>
                    </div>    
                    @endforeach
                </div>
            </div>
            <div class="index-right-panel mt8">
                <div class="flex align-center mx8">
                    <img src="{{ asset('assets/images/icons/clock.svg') }}" class="small-image mr4" alt="">
                    <p class="bold my8">{{ __('Recent threads') }}</p>
                </div>
                <div class="simple-line-separator my8"></div>
                @foreach($recent_threads as $thread)
                <div class="my8">
                    <div>
                        <div class="flex align-center">
                            <a href="{{ route('forum.misc', ['forum'=>$thread->forum()->slug]) }}" class="blue no-underline fs11">{{ $thread->forum()->forum }}</a>
                            <span class="mx4 bold fs12">▸</span>
                            <a href="{{ route('category.misc', ['forum'=>$thread->forum()->slug, 'category'=>$thread->category->slug]) }}" class="blue no-underline fs11">{{ $thread->category->category }}</a>
                        </div>
                        <div class="flex">
                            <a href="{{ route('user.profile', ['user'=>$thread->user->username]) }}">
                                <img src="{{ $thread->user->avatar }}" class="small-image-3 rounded mr4" alt="">
                            </a>
                            <div class="full-width">
                                <a href="{{ route('thread.show', ['forum'=>$thread->forum()->slug, 'category'=>$thread->category->slug, 'thread'=>$thread->id]) }}" class="no-margin bold no-underline forum-color fs13">{{ $thread->subject }}</a>
                                <div class="flex align-center mt4">
                                    <div class="flex align-center">
                                        <img src="{{ asset('assets/images/icons/eye.png') }}" class="small-image-size mr4" alt="">
                                        <p class="fs11 no-margin">{{ $thread->view_count }}</p>
                                    </div>

                                    <div class="flex align-center ml8">
                                        <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-size mr4" alt="">
                                        <p class="fs11 no-margin">{{ $thread->posts->count() }}</p>
                                    </div>

                                    <div class="move-to-right flex">
                                        <div class="flex align-center mr8">
                                            <p class="fs11 no-margin" style="margin-right: 2px">0</p>
                                            <img src="{{ asset('assets/images/icons/up-arrow.png') }}" class="small-image-size" alt="">
                                        </div>

                                        <div class="flex align-center">
                                            <p class="fs11 no-margin" style="margin-right: 2px">0</p>
                                            <img src="{{ asset('assets/images/icons/down-arrow.png') }}" class="small-image-size" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                @if(!$loop->last)
                    <div class="simple-half-line-separator my8"></div>
                @endif
                @endforeach
            </div>
            <div class="sticky" style="top: 70px">
                <div class="index-right-panel mt8">
                    <div class="flex align-center mx8">
                        <img src="{{ asset('assets/images/icons/bfeedback.png') }}" class="small-image mr4" style="margin-top: -3px" alt="">
                        <p class="bold my8">{{ __('Feedback') }}</p>
                    </div>
                    @canemoji
                    <div class="full-center">
                        <a href="" class="mx4 emoji-button">
                            <img src="{{ asset('assets/images/icons/emoji-sad.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" alt="">
                            <img src="{{ asset('assets/images/icons/emoji-sad-filled.png') }}" class="mx4 rounded-style-1 none emoji-filled" alt="">
                            <input type="hidden" class="feedback-emoji-state" value="sad">
                        </a>
                        <a href="" class="mx4 emoji-button">
                            <img src="{{ asset('assets/images/icons/emoji-thinking.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" alt="">
                            <img src="{{ asset('assets/images/icons/emoji-thinking-filled.png') }}" class="mx4 rounded-style-1 none emoji-filled" alt="">
                            <input type="hidden" class="feedback-emoji-state" value="sceptic">
                        </a>
                        <a href="" class="mx4 emoji-button">
                            <img src="{{ asset('assets/images/icons/emoji-sceptic.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" alt="">
                            <img src="{{ asset('assets/images/icons/emoji-sceptic-filled.png') }}" class="mx4 rounded-style-1 none emoji-filled" alt="">
                            <input type="hidden" class="feedback-emoji-state" value="so-so">
                        </a>
                        <a href="" class="mx4 emoji-button">
                            <img src="{{ asset('assets/images/icons/emoji-happy.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" alt="">
                            <img src="{{ asset('assets/images/icons/emoji-happy-filled.png') }}" class="mx4 rounded-style-1 none emoji-filled" alt="">
                            <input type="hidden" class="feedback-emoji-state" value="happy">
                        </a>
                        <a href="" class="mx4 emoji-button">
                            <img src="{{ asset('assets/images/icons/emoji-veryhappy.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" alt="">
                            <img src="{{ asset('assets/images/icons/emoji-veryhappy-filled.png') }}" class="mx4 rounded-style-1 none emoji-filled" alt="">
                            <input type="hidden" class="feedback-emoji-state" value="veryhappy">
                        </a>
                    </div>
                    @else
                        @php
                            $feedback_state = \App\Models\EmojiFeedback::where('ip', request()->ip())->orderBy('created_at', 'desc')->first()->emoji_feedback;
                        @endphp
                    <div class="full-center">
                        <a href="" class="mx4 block-click">
                            @if($feedback_state == 'sad')
                                <img src="{{ asset('assets/images/icons/emoji-sad-filled.png') }}" class="mx4 rounded-style-1 emoji-filled" alt="">
                            @else
                                <img src="{{ asset('assets/images/icons/emoji-sad.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" style="opacity: 0.5" alt="">
                            @endif
                        </a>
                        <a href="" class="mx4 block-click">
                            @if($feedback_state == 'sceptic')
                                <img src="{{ asset('assets/images/icons/emoji-thinking-filled.png') }}" class="mx4 rounded-style-1 emoji-filled" alt="">
                            @else
                                <img src="{{ asset('assets/images/icons/emoji-thinking.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" style="opacity: 0.5" alt="">
                            @endif
                        </a>
                        <a href="" class="mx4 block-click">
                            @if($feedback_state == 'so-so')
                                <img src="{{ asset('assets/images/icons/emoji-sceptic-filled.png') }}" class="mx4 rounded-style-1 emoji-filled" alt="">
                            @else
                                <img src="{{ asset('assets/images/icons/emoji-sceptic.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" style="opacity: 0.5" alt="">
                            @endif
                        </a>
                        <a href="" class="mx4 block-click">
                            @if($feedback_state == 'happy')
                                <img src="{{ asset('assets/images/icons/emoji-happy-filled.png') }}" class="mx4 rounded-style-1 emoji-filled" alt="">
                            @else
                                <img src="{{ asset('assets/images/icons/emoji-happy.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" style="opacity: 0.5" alt="">
                            @endif
                        </a>
                        <a href="" class="mx4 block-click">
                            @if($feedback_state == 'veryhappy')
                                <img src="{{ asset('assets/images/icons/emoji-veryhappy-filled.png') }}" class="mx4 rounded-style-1 emoji-filled" alt="">
                            @else
                                <img src="{{ asset('assets/images/icons/emoji-veryhappy.svg') }}" class="mx4 rounded-style-1 emoji-unfilled" style="opacity: 0.5" alt="">
                            @endif
                        </a>
                    </div>
                    @endcanemoji
                    <p class="fs12 my8">We are here to anwser any questions you may have about us or any feedback you have about the website. Reach out to us using below form, and we'll respond as soon as we can.</p>
                    <div class="feedback-container">
                        <div class="feedback-sent-success-container green-message-container none">
                            <img src="{{ asset('assets/images/icons/green-tick.png') }}" class="small-image move-to-middle" alt="">
                            <p class="fs13 no-margin text-center green-message">{{ __('Your feedback is sent successfully.') }}</p>
                        </div>
                        <div class="feedback-sec">
                            <p class="no-margin my4 none error"></p>
                            @guest
                            <div class="input-container">
                                <label for="subject" class="label-style-1 fs13">{{ __('Email') }} @error('email') <span class="error mr4">*</span> @enderror</label>
                                <input type="email" id="email" name="email" class="full-width border-box input-style-2" value="{{ @old('email') }}" required placeholder="Your email">
                                @error('email')
                                    <p class="error" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                            @endguest
                            <div class="input-container">
                                <label for="feedback" class="label-style-1 fs13">{{ __('Your feedback') }} @error('feedback') <span class="error mr4">*</span> @enderror</label>
                                <textarea name="feedback" id="feedback" class="feedback-textarea" placeholder="{{ __('What do you think about this website ..') }}"></textarea>
                                @error('feedback')
                                    <p class="error" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex">
                                <input type="button" value="send" class="move-to-right button-style-1 send-feedback">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="index-right-panel mt8">
                    <div class="flex align-center mx8">
                        <img src="{{ asset('assets/images/icons/statistics.svg') }}" class="small-image mr4" style="margin-top: -3px" alt="">
                        <p class="bold my8">{{ __('Statistics') }}</p>
                    </div>
                    <div class="simple-line-separator my4"></div>
                    <div class="flex">
                        <img src="{{ asset('assets/images/icons/thread.svg') }}" class="small-image-2 mr4" alt="">
                        <p class="my4 fs13">Total forums threads: {{ \App\Models\Thread::count() }}</p>
                    </div>
                    <div class="flex align-center my4">
                        <img src="{{ asset('assets/images/icons/discussions.png') }}" class="small-image-2 mr4" alt="">
                        <p class="my4 fs13">Total replies: {{ \App\Models\Post::count() }}</p>
                    </div>
                    <div class="mt8 my4">
                        <div class="flex">
                            <img src="{{ asset('assets/images/icons/user.svg') }}" class="small-image-2 mr4" alt="" style="margin-top:1px">
                            <div>
                                <p class="no-margin mt4 fs13">Total members: {{ \App\Models\User::count() }}</p>
                                @php
                                    $last_user_username = \App\Models\User::orderBy('created_at')->first()->username;
                                @endphp
                                <p class="fs11 no-margin">Our newest member: <a href="{{ route('user.profile', ['user'=>$last_user_username]) }}" class="link-style inline-block fs12 bold">{{$last_user_username}}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection