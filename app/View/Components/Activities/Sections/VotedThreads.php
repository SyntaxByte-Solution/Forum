<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\{User, Vote, Thread};

class VotedThreads extends Component
{
    public $user;
    public $votedthreads;

    public function __construct(User $user)
    {
        $this->user = $user;
        $voted_threads = collect([]);
        $c = 0;
        foreach(Vote::where('user_id', $user->id)->where('votable_type', 'App\Models\Thread')->get(['votable_id', 'vote']) as $votable) {
            if($c == 6) break;
            $voted_threads->push(Thread::find($votable['votable_id']));

            $c++;
        }
        $this->votedthreads = $voted_threads;
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
