<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;
use App\Models\User;

class SavedThreads extends Component
{
    public $user;
    public $savedthreads;

    public function __construct(User $user, $savedthreads)
    {
        $this->user = $user;
        $this->savedthreads = $savedthreads;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.activities.sections.saved-threads');
    }
}