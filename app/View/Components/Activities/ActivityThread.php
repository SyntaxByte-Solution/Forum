<?php

namespace App\View\Components\Activities;

use Illuminate\View\Component;
use App\Models\{Thread, User};
use Carbon\Carbon;

class ActivityThread extends Component
{
    public $activity_user;
    public $thread;
    public $is_ticked;
    public $forum;
    public $category;
    public $edit_link;

    public $at;
    public $at_hummans;
    
    public function __construct(Thread $thread, User $user)
    {
        $this->activity_user = $user;
        $this->thread = $thread;
        $this->edit_link = route('thread.edit', ['user'=>$thread->user->username, 'thread'=>$thread->id]);
        $this->is_ticked = $thread->posts->where('ticked', 1)->count();
        $this->forum = $thread->category->forum;
        $this->category = $thread->category;

        $this->at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->at_hummans = (new Carbon($thread->created_at))->diffForHumans();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.activity-thread', $data);
    }
}
