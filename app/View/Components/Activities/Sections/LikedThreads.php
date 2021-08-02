<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\{User, Like};

class LikedThreads extends Component
{
    public $user;
    public $likedthreads;
    public $likedthreads_count;

    public function __construct(User $user)
    {
        $this->user = $user;
        /**
         * Here the thread owner could like some threads that are private or follower only visible, and the way how we retrieve
         * liked threads is to fetch threads based on likable_id's in likes table
         * So before fetching threads we have to check if the thread is null or not (we solve this problem 
         * by adding reject to map function User - liked_users method)
         */
        $this->likedthreads = $user->liked_threads()->take(10);
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
