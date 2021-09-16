<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\PollOption;

class PollOptionComponent extends Component
{
    public $option;
    public $addedby;
    public $multiple_choice;
    public $allow_options_creation;

    public function __construct(PollOption $option, $multiplechoice, $allowoptionscreation)
    {
        $this->option = $option;
        $this->multiple_choice = $multiplechoice;
        $this->allow_options_creation = $allowoptionscreation;
        $this->addedby = 
            ((auth()->user() && $option->user->id == auth()->user()->id) 
            ? __('you') 
            : $option->user->username);
    }

    public function render()
    {
        return view('components.thread.poll-option-component');
    }
}
