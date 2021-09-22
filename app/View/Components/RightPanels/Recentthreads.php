<?php

namespace App\View\Components\RightPanels;

use Illuminate\View\Component;
use App\Models\{Thread,Category,Forum};

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
                if(is_numeric($forum)) {
                    if(intval($forum) == 0) {
                        $this->recent_threads = Thread::without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->orderBy('created_at', 'desc')->take($threads_count)->get();            
                    }
                    $forum_categories_ids = Forum::find(intval($forum))->first()->categories()->pluck('id');
                    $this->recent_threads = Thread::without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->whereIn('category_id', $forum_categories_ids)->orderBy('created_at', 'desc')->take($threads_count)->get();
                } else if(is_string($forum)) {
                    $forum_categories_ids = Forum::where('slug', $forum)->first()->categories()->pluck('id');
                    $this->recent_threads = Thread::without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->whereIn('category_id', $forum_categories_ids)->orderBy('created_at', 'desc')->take($threads_count)->get();
                } else if($forum instanceof Forum) {
                    $forum_categories_ids = $forum->categories()->pluck('id');
                    $this->recent_threads = Thread::without(['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'])->whereIn('category_id', $forum_categories_ids)->orderBy('created_at', 'desc')->take($threads_count)->get();
                }
            }
        } else {
            $this->recent_threads = Thread::without(['visibility', 'status', 'user.status'])->orderBy('created_at', 'desc')->take($threads_count)->get();
        }

        if($this->recent_threads->count() < $threads_count) {
            $this->recent_threads = Thread::without(['visibility', 'status', 'user.status'])->orderBy('created_at', 'desc')->take($threads_count)->get();
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
