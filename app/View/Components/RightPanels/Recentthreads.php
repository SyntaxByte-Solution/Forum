<?php

namespace App\View\Components\RightPanels;

use Illuminate\View\Component;
use App\Models\{Thread,Category};

class Recentthreads extends Component
{
    public $recent_threads;
    
    public function __construct()
    {
        $recent_threads = collect([]);
        $threads_count = 5;
        if($forum = request()->forum) {
            if($category = request()->category) {
                if(is_numeric($category))
                    $this->recent_threads = Category::find((int)$category)->threads()->without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->orderBy('created_at', 'desc')->take($threads_count)->get();
                else
                    $this->recent_threads = $category->threads()->without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->orderBy('created_at', 'desc')->take($threads_count)->get();
            } else {
                $forum_categories_ids = \App\Models\forum::find($forum)->first()->categories->pluck('id');
                $this->recent_threads = Thread::without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->whereIn('category_id', $forum_categories_ids)->orderBy('created_at', 'desc')->take($threads_count)->get();
            }
        } else {
            $this->recent_threads = Thread::without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->orderBy('created_at', 'desc')->take($threads_count)->get();
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
