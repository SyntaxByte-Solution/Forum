<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\Forum;

class ForumComponent extends Component
{
    public $forum;
    public $threads_count;
    public $posts_count;

    public function __construct(Forum $forum)
    {
        $this->forum = $forum;
        $this->threads_count = $forum->threads()->count();
        $posts_count = 0;
        foreach($forum->threads() as $thread) {
            $posts_count += $thread->posts->count();
        }
        $this->posts_count = $posts_count;
    }

    public function render()
    {
        return view('components.thread.forum-component');
    }
}
