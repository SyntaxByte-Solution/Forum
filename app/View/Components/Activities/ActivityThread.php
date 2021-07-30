<?php

namespace App\View\Components\Activities;

use Illuminate\View\Component;
use App\Models\Thread;

class ActivityThread extends Component
{
    public $thread;
    public $is_ticked;
    public $forum;
    public $category;
    
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
        $this->is_ticked = $thread->posts->where('ticked', 1)->count();
        $this->forum = $thread->forum();
        $this->category = $thread->category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activities.activity-thread');
    }
}
