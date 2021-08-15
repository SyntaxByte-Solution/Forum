<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\{Thread, Forum, Category};
use Carbon\Carbon;

class Announcement extends Component
{
    public $announcement;
    public $at_hummans;
    public $forum;
    public $category;
    public $at;
    public $ay_humans;
    
    public function __construct(Thread $announcement)
    {
        $this->announcement = $announcement;
        $this->forum = Forum::find($announcement->category->forum_id);
        $this->category = Category::find($announcement->category_id);
        $this->at = (new Carbon($announcement->created_at))->toDayDateTimeString();
        $this->at_hummans = (new Carbon($announcement->created_at))->diffForHumans();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.thread.announcement');
    }
}
