<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Post, User};
use Carbon\Carbon;

class DiscussionPost extends Component
{

    public $post_votes;
    public $post_content;
    public $post_created_at;

    public $post_owner_avatar;
    public $post_owner_username;
    public $post_owner_reputation;

    public function __construct($post)
    {
        $post = Post::find($post);
        $post_owner = User::find(Post::find($post->user_id))->first();

        $this->post_content = $post->content;
        $this->post_created_at = (new Carbon($post->created_at))->toDayDateTimeString();

        $this->post_owner_avatar = $post_owner->avatar;
        $this->post_owner_username = $post_owner->username;
        $this->post_owner_reputation = $post_owner->reputation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.discussion.discussion-post', $data);
    }
}
