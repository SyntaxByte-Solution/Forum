<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Post};
use Carbon\Carbon;
use Markdown;

class PostComponent extends Component
{

    public $post;
    public $thread_owner;
    public $votes;
    public $post_content;
    public $canbeticked;

    public $already_reported;
    public $post_created_at;
    public $post_date;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->post_content = Markdown::parse($post->content);
        $this->post_created_at = (new Carbon($post->created_at))->toDayDateTimeString();
        $this->post_date = (new Carbon($post->created_at))->diffForHumans();
        $this->votes = $post->votevalue;
        $this->thread_owner = \DB::select("SELECT user_id as userid FROM threads where id IN (SELECT thread_id FROM posts WHERE id=$post->id)")[0]->userid;
        $this->canbeticked = \DB::select("SELECT COUNT(*) as tickexists FROM posts WHERE ticked=1 AND thread_id=$post->thread_id")[0]->tickexists > 0;
        $this->already_reported = ($post->already_reported) ? 1 : 0;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.post.post-component', $data);
    }
}
