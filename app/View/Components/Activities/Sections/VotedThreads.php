<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\{User, Vote, Thread};

class VotedThreads extends Component
{
    public $user;
    public $votedthreads;
    public $votedthreads_count;

    public function __construct(User $user)
    {
        $this->user = $user;
        
        $this->votedthreads = $user->voted_threads()->take(10);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.voted-threads', $data);
    }
}
