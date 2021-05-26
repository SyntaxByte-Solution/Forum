<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\{Thread, User};

class ThreadComponent extends Component
{
    public $thread_owner_avatar;
    public $thread_owner_username;
    public $thread_owner_reputation;
    public $thread_owner_posts_number;
    public $thread_owner_threads_number;
    public $thread_owner_joined_at;

    public $thread_subject;
    public $thread_created_at;
    public $thread_view_counter;
    public $thread_content;

    public function __construct(Thread $thread)
    {
        // Incrementing the view counter
        $thread->update([
            'view_count'=>$thread->view_count+1
        ]);

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
        $this->thread_content = $thread->content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.thread-component');
    }
}
