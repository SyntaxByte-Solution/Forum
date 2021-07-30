<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\User;

class Threads extends Component
{
    public $user;
    public $threads;

    public function __construct(User $user, $threads)
    {
        $this->user = $user;
        $this->threads = $threads;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activities.sections.threads');
    }
}
