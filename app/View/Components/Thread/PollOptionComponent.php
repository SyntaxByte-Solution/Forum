<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\PollOption;

class PollOptionComponent extends Component
{
    public $option;
    public $addedby;
    public $multiple_choice;
    public $poll_owner;
    public $allow_options_creation;
    public $voted;
    public $int_voted;

    public function __construct(PollOption $option, $multiplechoice, $allowoptionscreation)
    {
        $this->option = $option;
        $this->multiple_choice = $multiplechoice;
        $this->allow_options_creation = $allowoptionscreation;
        $this->poll_owner = auth()->user() && $option->poll->thread->user->id == auth()->user()->id;
        $this->addedby = 
            ((auth()->user() && $option->user->id == auth()->user()->id) 
            ? __('you') 
            : $option->user->username);
        $this->voted = $option->voted;
        $this->int_voted = (int)$this->voted;
    }

    public function render()
    {
        return view('components.thread.poll-option-component');
    }
}
