<?php

namespace App\View\Components\RightPanels;

use Illuminate\View\Component;
use App\Models\Thread;

class Recentthreads extends Component
{
    public $recent_threads;
    
    public function __construct()
    {
        $recent_threads = collect([]);
        $threads_count = 5;
        if($forum = request()->forum) {
            if($category = request()->category) {
                $this->recent_threads = $category->threads->sortByDesc('created_at')->take($threads_count);
            } else {
                $forum_categories_ids = \App\Models\forum::find($forum)->first()->categories->pluck('id');
                $this->recent_threads = Thread::whereIn('category_id', $forum_categories_ids)->orderBy('created_at', 'desc')->take($threads_count)->get();
            }
        } else {
            $this->recent_threads = Thread::orderBy('created_at', 'desc')->take($threads_count)->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.right-panels.recentthreads');
    }
}
