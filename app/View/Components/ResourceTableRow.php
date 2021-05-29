<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Thread, User, Category, Forum};
use Carbon\Carbon;

class ResourceTableRow extends Component
{
    public $thread_id;
    public $thread_url;
    public $category;
    public $thread_title;
    public $views;
    public $thread_owner;
    public $replies;
    public $at;

    public $last_post_content;
    public $last_post_owner_username;
    public $last_post_date;

    public $hasLastPost;

    public function __construct(Thread $thread)
    {
        $forum = Forum::find($thread->category->forum_id)->slug;

        $this->thread_id = $thread->id;
        if(strlen($thread->subject) > 80) {
            $this->thread_title = substr($thread->subject, 0, 80) . '..';
        } else {
            $this->thread_title = $thread->subject;
        }

        $this->category = Category::find($thread->category_id)->category;
        $this->at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->views = $thread->view_count;
        $this->replies = $thread->posts->count();

        $this->hasLastPost = $last_post = $thread->posts->last();

        if($last_post) {
            $lpc = $last_post->content;
            $this->last_post_content = strlen($lpc) > 80 ? substr($lpc, 0, 80) : $lpc;
            $this->last_post_owner_username = User::find($last_post->user_id)->username;
            $this->last_post_date = $last_post->created_at;

            if($thread->thread_type == 1) {
                $this->thread_url = route('discussion.show', ['forum'=>$forum, 'thread'=>$thread->id, '#' . $last_post->id]);
            } else if($thread->thread_type == 2) {
                $this->thread_url = route('question.show', ['forum'=>$forum, 'thread'=>$thread->id]);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.resource-table-row');
    }
}
