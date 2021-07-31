<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\{User, Like, Thread};

class LikedThreads extends Component
{
    public $user;
    public $likedthreads;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->likedthreads = Thread::whereIn('id', 
        Like::where('user_id', $user->id)
        ->where('likable_type', 'App\Models\Thread')
        ->pluck('likable_id')
        )->orderBy('created_at', 'desc')->take(6)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.liked-threads', $data);
    }
}
