<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\User;

class VotedThreads extends Component
{
    public $user;
    public $votedthreads;

    public function __construct(User $user, $votedthreads)
    {
        $this->user = $user;
        $this->votedthreads = $votedthreads;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activities.sections.voted-threads');
    }
}
