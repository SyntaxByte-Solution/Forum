<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{Thread, Follow};

class ViewerInfos extends Component
{

    public $thread;
    public $posts;
    public $owner_full_name;
    public $edit_link;
    public $owner_username;
    public $followed;
    public $tickedPost;

    public $posts_switch;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
        $this->owner_full_name = $thread->user->fullname;
        $this->owner_username = $thread->user->username;
        $this->edit_link = route('thread.edit', ['user'=>$thread->user->username, 'thread'=>$thread->id]);
        $this->posts__turn_off_switch = ($thread->replies_off) ? 'on' : 'off';
        $switch = ($thread->replies_off) ? 0 : 1;

        if(Auth::check()) {
            $this->followed = (bool)Follow::where('follower', auth()->user()->id)
            ->where('followable_id', $thread->user->id)
            ->where('followable_type', 'App\Models\User')
            ->count();
        } else {
            $this->followed = false;
        }

        $this->tickedPost = $tickedPost = $thread->tickedPost();
        if($tickedPost) {
            $this->posts = $thread->posts()->where('id', '<>', $tickedPost->id)->orderBy('created_at', 'desc')->take(5)->get();
        } else {
            $this->posts = $thread->posts()->orderBy('created_at', 'desc')->take(6)->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.thread.viewer-infos', $data);
    }
}
