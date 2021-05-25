<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Discussion, Thread, User};

class DiscussionTableRow extends Component
{
    public $discussion_title;
    public $views;
    public $thread_owner;
    public $replies;
    public $last_post;

    public function __construct(Thread $discussion)
    {
        if(strlen($discussion->subject) > 80) {
            $this->discussion_title = substr($discussion->subject, 0, 80) . '..';
        } else {
            $this->discussion_title = $discussion->subject;
        }
        $this->views = $discussion->view_count;
        $this->thread_owner = User::find($discussion->user_id)->username;
        $this->replies = $discussion->posts->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.discussion-table-row');
    }
}
