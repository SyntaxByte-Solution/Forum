<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\{User, Like};

class LikedThreads extends Component
{
    public $user;
    public $likedthreads;

    public function __construct(User $user)
    {
        $this->user = $user;
        
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
