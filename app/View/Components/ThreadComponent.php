<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\{Forum, Category, Thread, User};
use Markdown;

class ThreadComponent extends Component
{
    public $thread_owner_avatar;
    public $thread_owner_username;
    public $thread_owner_reputation;
    public $thread_owner_posts_number;
    public $thread_owner_threads_number;
    public $thread_owner_joined_at;

    public $thread_url;
    public $thread_subject;
    public $thread_created_at;
    public $thread_view_counter;
    public $thread_content;
    public $thread_replies_num;

    public function __construct(Thread $thread)
    {
        // Incrementing the view counter
        $thread->update([
            'view_count'=>$thread->view_count+1
        ]);

        $forum = Forum::find($thread->category->forum_id)->slug;
        $category = Category::find($thread->category_id);

        if($thread->thread_type == 1) {
            $this->thread_url = route('discussion.show', ['forum'=>$forum, 'category'=>$category->slug,'thread'=>$thread->id]);
        } else if($thread->thread_type == 2) {
            $this->thread_url = route('question.show', ['forum'=>$forum, 'category'=>$category->slug, 'thread'=>$thread->id]);
        }
        
        $this->thread_replies_num = $thread->posts->count();
        $thread_owner = User::find($thread->user_id);
        $this->thread_owner_avatar = $thread_owner->avatar;
        $this->thread_owner_username = $thread_owner->username;
        $this->thread_owner_reputation = $thread_owner->reputation;
        $this->thread_owner_threads_number = $thread_owner->threads->count();
        $this->thread_owner_posts_number = $thread_owner->posts_count();
        $this->thread_owner_joined_at = (new Carbon($thread_owner->created_at))->toDayDateTimeString();
        
        $this->thread_subject = $thread->subject;
        $this->thread_created_at = (new Carbon($thread->created_at))->toDayDateTimeString();
        $this->thread_view_counter = $thread->view_count;
        $this->thread_content = strip_tags(Markdown::parse($thread->content));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.thread.thread-component');
    }
}
