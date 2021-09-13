<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Post};
use Carbon\Carbon;
use Markdown;

class PostComponent extends Component
{

    public $post;
    public $votes;
    public $post_content;
    public $tickedPost;

    public $post_created_at;
    public $post_date;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->post_content = Markdown::parse($post->content);
        $this->post_created_at = (new Carbon($post->created_at))->toDayDateTimeString();
        $this->post_date = (new Carbon($post->created_at))->diffForHumans();
        $this->votes = $post->votevalue;
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
