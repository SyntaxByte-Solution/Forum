<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{PollOption, OptionVote};
use App\View\Components\Thread\PollOptionComponent;

class PollController extends Controller
{
    public function option_vote(Request $request) {
        $currenuser = auth()->user();
        /** 
         *  Before storing the vote we have to do some checks:
         *  We need to see If the poll of this option is allowing multiple choices or not;
         *       -> If YES; then we do one more check:
         *          ->If the current user already vote this poll; If so we also check if the voted option is the same as the
         *               current option; In that case if they match each other it means the same option and we have to delete
         *               that vote simply. Otherwise if the option voted is not the same as the current option we add the vote.
         *       -> If NO; we do the same checks as above but in case the user already vote the poll, and vote new option,
         *          we remove the previous voted option and save the new one; If the user vote an option and vote it again we simply
         *          remove the vote.
         */
        $optionvote = $request->validate([
            'option_id'=>'required|exists:polloptions,id'
        ]);
        //Authorization here

        $optionvote['user_id'] = $currenuser->id;

        $option = PollOption::find($optionvote['option_id']);
        $poll = $option->poll;

        if($poll->allow_multiple_choice) {
            // First check if the option is already voted by the same user
            if($option->voted) {
                // In this case we have to delete the vote
                $poll
                    ->votes()
                    ->where('optionsvotes.user_id', $currenuser->id)
                    ->where('optionsvotes.option_id', $option->id)
                    ->delete();
                return [
                    'diff'=>-1,
                    'type'=>'deleted'
                ];
            }
            OptionVote::create($optionvote);
            return [
                'diff'=>1,
                'type'=>'added'
            ];
        } else {
            // Here the poll owner disable multiple choices
            if($poll->voted) { // Delete user vote on the poll and add the new one if the user already vote the poll
                if($option->voted) {
                    $poll->votes()
                        ->where('optionsvotes.user_id', $currenuser->id)
                        ->where('optionsvotes.option_id', $option->id)
                        ->delete();
                    return [
                        'diff'=>-1,
                        'type'=>'deleted'
                    ];
                }
                else {
                    $poll->votes()
                    ->where('optionsvotes.user_id', $currenuser->id)
                    ->delete();
                    OptionVote::create($optionvote);
                    return [
                        'diff'=>1,
                        'type'=>'flipped'
                    ];
                }
            }
            
            OptionVote::create($optionvote);
            return [
                'diff'=>1,
                'type'=>'added'
            ];
        }
    }

    public function option_delete(PollOption $option) {
        // We need to delete the option votes first before deletin the option itself
        //Authorization here
        $option->delete();
    }

    public function add_option(Request $request) {
        $option = $request->validate([
            'poll_id'=>'required|exists:polls,id',
            'content'=>'required|min:1|max:400'
        ]);

        // Authorization here
        $option['user_id'] = auth()->user()->id;
        $option = PollOption::create($option);

        return $option->id;
    }

    public function get_poll_option_component(PollOption $option) {
        $poll = $option->poll;
        $option_component = (new PollOptionComponent($option, $poll->allow_multiple_choice, $poll->allow_choice_add));
        $option_component = $option_component->render(get_object_vars($option_component))->render();

        return $option_component;
    }
}
