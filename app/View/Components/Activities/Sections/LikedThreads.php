<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\User;

class LikedThreads extends Component
{
    public $user;
    public $likedthreads;

    public function __construct(User $user, $likedthreads)
    {
        $this->user = $user;
        $this->likedthreads = $likedthreads;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activities.sections.liked-threads');
    }
}
