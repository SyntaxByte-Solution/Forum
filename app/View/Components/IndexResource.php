<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\{Thread, User, Category, Forum};
use Carbon\Carbon;
use Markdown;

class IndexResource extends Component
{
    public $resource;
    public $edit_link;

    public $thread;
    public $thread_id;
    public $thread_icon;
    public $thread_url;
    public $category;

    public $forum;

    public $type;
    public $thread_type;
    public $thread_title;
    public $thread_content;
    public $views;
    public $thread_owner;
    public $replies;
    public $at;
    public $at_hummans;

    public $last_post_url;
    public $last_post_content;
    public $last_post_owner_username;
    public $last_post_date;

    public $hasLastPost;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
        $category_model = Category::find($thread->category_id);
        $this->resource = $thread;
        $this->thread_type = $thread->thread_type;
        $this->forum = Forum::find($thread->category->forum_id);
        $forum = $this->forum->slug;
        $this->thread_owner = User::find($thread->user_id)->username;
        
        $this->thread_id = $thread->id;
        if(strlen($thread->subject) > 80) {
            $this->thread_title = substr($thread->subject, 0, 80) . '..';
        } else {
            $this->thread_title = $thread->subject;
        }

        if(strlen($thread->content) > 100) {
            $this->thread_content = substr($thread->content, 0, 100) . '..';
        } else {
            $this->thread_content = $thread->content;
        }

        $this->category = Category::find($thread->category_id);
        $this->at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->at_hummans = (new Carbon($thread->created_at))->diffForHumans();
        $this->views = $thread->view_count;
        $this->replies = $thread->posts->count();

        $this->hasLastPost = $last_post = $thread->posts->last();

        if($thread->thread_type == 1) {
            $this->thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category_model->slug, 'thread'=>$thread->id]);
            $this->edit_link = route('discussion.edit', ['user'=>$this->thread_owner, 'thread'=>$thread->id]);
            $this->thread_icon = 'assets/images/icns/discussions.png';
            $this->type = "Discussion";
        } else if($thread->thread_type == 2) {
            $this->thread_url = route('thread.show', ['forum'=>$forum, 'category'=>$category_model->slug, 'thread'=>$thread->id]);
            $this->edit_link = route('question.edit', ['user'=>$this->thread_owner, 'thread'=>$thread->id]);
            $this->thread_icon = 'assets/images/icns/questions.png';
            $this->type = "Question";
        }

        if($last_post) {
            $lpc = strip_tags(Markdown::parse($last_post->content));
            $this->last_post_content = strlen($lpc) > 80 ? substr($lpc, 0, 80) . '..' : $lpc;
            $this->last_post_owner_username = User::find($last_post->user_id)->username;
            $this->last_post_date = $last_post->created_at;

            if($thread->thread_type == 1) {
                $this->last_post_url = route('thread.show', ['forum'=>$forum, 'category'=>$category_model->slug, 'thread'=>$thread->id, '#' . $last_post->id]);
            } else if($thread->thread_type == 2) {
                $this->last_post_url = route('thread.show', ['forum'=>$forum, 'category'=>$category_model->slug, 'thread'=>$thread->id, '#' . $last_post->id]);
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
        return view('components.index-resource');
    }
}
