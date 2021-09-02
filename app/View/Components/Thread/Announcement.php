<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\{Thread, Forum, Category};
use App\Scopes\{ExcludeAnnouncements};
use Carbon\Carbon;

class Announcement extends Component
{
    public $announcement;
    public $forum;
    public $category;
    public $at;
    public $at_hummans;
    
    public function __construct($announcid)
    {
        $announcement = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($announcid);
        $category = $announcement->category;
        $forum = $category->forum;
        
        $this->announcement = $announcement;
        $this->category = $category;
        $this->forum = $forum;
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
