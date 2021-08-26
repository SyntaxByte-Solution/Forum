<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\Forum;
use Carbon\Carbon;

class ForumComponent extends Component
{
    public $forum;
    public $threads_count;
    public $posts_count;
    // Last thread
    public $last_thread;
    public $at;
    public $at_hummans;

    public function __construct(Forum $forum)
    {
        $forum_threads = $forum->threads();

        $this->forum = $forum;
        $this->threads_count = $forum_threads->count();
        $posts_count = 0;
        foreach($forum_threads as $thread) {
            $posts_count += $thread->posts->count();
        }
        $this->posts_count = $posts_count;

        $last_thread = $forum_threads->sortBy('created_at')->last();
        if($last_thread) {
            $this->last_thread = $last_thread;
            $this->at = (new Carbon($last_thread->created_at))->toDayDateTimeString();
            $this->at_hummans = (new Carbon($last_thread->created_at))->diffForHumans();
        }
    }

    public function render()
    {
        return view('components.thread.forum-component');
    }
}
