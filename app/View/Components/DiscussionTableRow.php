<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Discussion;

class DiscussionTableRow extends Component
{
    public $discussion_title;
    public $views;
    public $replies;
    public $last_post;

    public function __construct()
    {
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.discussion-table-row');
    }
}
