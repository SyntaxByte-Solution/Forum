<?php

namespace App\View\Components\Thread;

use Illuminate\View\Component;
use App\Models\PollOption;

class PollOptionComponent extends Component
{
    public $option;
    /**
     * classes: Used to append extra classes to the current option component (e.g hide the options after the first 5 options 
     * and display a button to display more options
     */
    public $classes; 
    public $addedby;
    public $multiple_choice;
    public $poll_owner;
    public $allow_options_creation;
    public $voted;
    public $votescount;
    public $vote_percentage;
    public $int_voted;

    public function __construct(
        PollOption $option, 
        $multiplechoice, 
        $allowoptionscreation, 
        $totalpollvotes, 
        $pollownerid,
        $classes="") // look at declaration
        {
            $this->option = $option;
            $this->classes = $classes;
            $this->multiple_choice = $multiplechoice;
            $this->allow_options_creation = $allowoptionscreation;
            $this->poll_owner = auth()->user() && $pollownerid == auth()->user()->id;
            $optionuser = $option->user;
            $this->addedby = 
                ((auth()->user() && $optionuser->id == auth()->user()->id))
                ? __('you') 
                : '<a href="' . $optionuser->profilelink . '" class="blue no-underline stop-propagation underline-when-hover">' . $option->user->username . "</a>";

            $votedandvotescount = $option->votedandvotescount;
            $this->voted = $votedandvotescount['voted'];
            $this->votescount = $votedandvotescount['count'];
            
            if($totalpollvotes == 0)
                $this->vote_percentage = 0;
            else
                $this->vote_percentage = floor($votedandvotescount['count'] * 100 / $totalpollvotes);
            $this->int_voted = (int)$votedandvotescount['voted'];
    }

    public function render($data=[])
    {
        return view('components.thread.poll-option-component', $data);
    }
}
