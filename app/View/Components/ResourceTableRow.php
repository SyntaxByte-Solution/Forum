<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Thread, User, Category};
use Carbon\Carbon;

class ResourceTableRow extends Component
{
    public $thread_id;
    public $category;
    public $thread_title;
    public $views;
    public $thread_owner;
    public $replies;
    public $at;
    public $last_post;

    public function __construct(Thread $thread)
    {
        $this->thread_id = $thread->id;
        if(strlen($thread->subject) > 80) {
            $this->thread_title = substr($thread->subject, 0, 80) . '..';
        } else {
            $this->thread_title = $thread->subject;
        }

        $this->category = Category::find($thread->category_id)->category;
        $this->at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->views = $thread->view_count;
        $this->thread_owner = User::find($thread->user_id)->username;
        $this->replies = $thread->posts->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.resource-table-row');
    }
}
