<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Thread, User, Category, Forum};
use Carbon\Carbon;
use Markdown;

class IndexResource extends Component
{
    
    public $thread;
    public $forum;
    public $category;
    
    public $edit_link;
    public $category_threads_link;

    public $views;
    public $likes;
    public $replies;
    public $at;
    public $at_hummans;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
        $this->forum = Forum::find($thread->category->forum_id);
        $this->category = Category::find($thread->category_id);
        $forum = $this->forum->slug;

        $this->at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->at_hummans = (new Carbon($thread->created_at))->diffForHumans();
        $this->views = $thread->view_count;
        $this->replies = $thread->posts->count();
        $this->likes = $thread->likes->count();

        $this->edit_link = route('thread.edit', ['user'=>$thread->user->username, 'thread'=>$thread->id]);
        $this->category_threads_link = route('category.threads', ['forum'=>$this->forum->slug, 'category'=>$this->category->slug]);
    }

    function convert($number)
    {
        if($number < 1000) return $number;
        $suffix = ['','k','M','G','T','P','E','Z','Y'];
        $power = floor(log($number, 1000));
        return round($number/(1000**$power),1,PHP_ROUND_HALF_EVEN).$suffix[$power];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.thread.index-resource');
    }
}
