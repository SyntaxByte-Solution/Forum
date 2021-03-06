<?php

namespace App\View\Components\Activities\Sections;

use Illuminate\View\Component;

class ArchivedThreads extends Component
{
    public $user;
    public $archivedthreads;
    
    public function __construct()
    {
        $user = auth()->user();

        $this->user = $user;
        $this->archivedthreads = $user->archivedthreads->without(['posts', 'likes', 'votes'])->orderBy('deleted_at', 'desc')->take(10)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.activities.sections.archived-threads', $data);
    }
}
