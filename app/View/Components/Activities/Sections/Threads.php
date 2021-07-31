<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\User;

class Threads extends Component
{
    public $user;
    public $threads;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->threads = $user->threads->take(6);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.threads', $data);
    }
}
