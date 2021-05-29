<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Thread, User, Category};
use Carbon\Carbon;

class DiscussionTableRow extends Component
{
    public $discussion_id;
    public $discussion_icon;
    public $discussion_title;
    public $views;
    public $thread_owner;
    public $replies;
    public $at;
    public $last_post;

    public function __construct(Thread $discussion)
    {
        if(Category::find($discussion->category_id)->slug == 'announcements') {
            $this->discussion_icon = 'assets/images/icns/announcements.png';
        } else {
            $this->discussion_icon = 'assets/images/icns/discussions.png';
        }

        $this->discussion_id = $discussion->id;
        if(strlen($discussion->subject) > 80) {
            $this->discussion_title = substr($discussion->subject, 0, 80) . '..';
        } else {
            $this->discussion_title = $discussion->subject;
        }
        $this->at = (new Carbon($discussion->created_at))->toDayDateTimeString();
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
        return view('components.discussion.discussion-table-row');
    }
}
