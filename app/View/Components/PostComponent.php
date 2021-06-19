<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Post, User};
use Carbon\Carbon;
use Markdown;

class PostComponent extends Component
{

    public $post;
    public $post_id;
    public $post_votes;
    public $post_content;

    public $post_created_at;
    public $post_date;
    public $post_updated_at;
    public $post_update_date;

    public $post_owner;
    public $post_owner_avatar;
    public $post_owner_username;
    public $post_owner_reputation;

    public function __construct($post)
    {
        $post = $this->post = Post::find($post);
        $this->post_owner = $post_owner = User::find($post->user_id);

        $this->post_id = $post->id;
        $this->post_content = Markdown::parse($post->content);
        $this->post_created_at = (new Carbon($post->created_at))->toDayDateTimeString();
        if($post->created_at != $post->updated_at) {
            $this->post_updated_at = (new Carbon($post->updated_at))->toDayDateTimeString();
            $this->post_update_date = (new Carbon($post->updated_at))->diffForHumans();
        }
        $this->post_date = (new Carbon($post->created_at))->diffForHumans();

        $this->post_owner_avatar = $post_owner->avatar;
        $this->post_owner_username = $post_owner->username;
        $this->post_owner_reputation = $post_owner->reputation;

        $vote_count = 0;
        foreach($post->votes as $vote) {
            $vote_count += $vote->vote;
        }
        $this->post_votes = $vote_count;
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
