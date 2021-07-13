<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\Thread;

class ViewerInfos extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Thread $thread)
    {
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.thread.viewer-infos', $data);
    }
}
