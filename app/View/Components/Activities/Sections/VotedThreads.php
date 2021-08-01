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

        $votedthreads = Thread::whereIn('id', 
        Vote::where('user_id', $user->id)
        ->where('votable_type', 'App\Models\Thread')
        ->orderBy('created_at', 'desc')
        ->pluck('votable_id')
        )->orderBy('created_at', 'desc');

        $this->votedthreads_count = $votedthreads->count();
        $this->votedthreads = $votedthreads->take(6)->get();
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
