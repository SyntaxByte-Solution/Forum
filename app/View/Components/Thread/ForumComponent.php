<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\{Forum, Thread};
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
        $this->forum = $forum;
        $forum_threads = $forum->threads()->without(['category.forum', 'category', 'likes','posts', 'visibility', 'status', 'votes', 'user.status']);
        $this->threads_count = $forum_threads->count();

        // $last_thread = Thread::without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->first();
        $last_thread = $forum_threads->orderBy('created_at', 'desc')->first();
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
