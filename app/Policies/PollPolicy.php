<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Poll,PollOption};

class PollPolicy
{
    use HandlesAuthorization;

    const MAX_OPTIONS_ENABLED = 30;
    const NONOWNER_OPTIONS_LIMIT = 1;

    public function option_vote(User $user) {
        if($user->isBanned())
            return $this->deny(__("Unauthorized action ! you're currently banned"));
        return true;
    }

    public function option_delete(User $user, PollOption $option) {
        if ($user->isBanned())
            return $this->deny(__("Unauthorized action ! you're currently banned"));
        
        if($option->poll->thread->id != $user->id)
            return $this->deny(__("Unauthorized action"));

        return true;
    }

    public function add_option(User $user, $pollid) {
        if ($user->isBanned())
            return $this->deny(__("Unauthorized action ! you're currently banned"));
        
        $poll = Poll::find($pollid);
        $poll_owner_id = \DB::select(
            "SELECT user_id FROM threads
            WHERE id IN 
                (SELECT thread_id FROM polls
                 WHERE id = $pollid)")[0]->user_id;

        if($user->id != $poll_owner_id) {
            // Only nonowners add option if allow_choice_add is enabled
            if($poll->allow_choice_add == 0) {
                return $this->deny(__("Poll owner disable choice adding"));
            } else {
                $alreadyadded = $poll->options()->where('user_id', $user->id)->count() > 0;
                if($alreadyadded) {
                    return $this->deny(__("You could only add 1 option to other people's polls"));
                } else {
                    if($poll->options()->count() == self::MAX_OPTIONS_ENABLED)
                        return $this->deny(__("Poll could have only 30 options max"));
                }
            }
        } else {
            if($poll->options()->count() == self::MAX_OPTIONS_ENABLED)
                return $this->deny(__("Poll could have only 30 options max"));
        }
        return true;
    }
}
