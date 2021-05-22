<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ForumTableRow extends Component
{
    
    public $forum;
    public $disc_and_quest_count;
    public $replies_count;
    public $last_post_title;
    public $last_post_owner_username;
    public $last_post_date;

    public function __construct($forum)
    {
        $this->forum = $forum;
    }

    public function render()
    {
        return view('components.forum-table-row');
    }
}
