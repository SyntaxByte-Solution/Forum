<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;

class VotePolicy
{
    use HandlesAuthorization;

    public function store(User $user, $vote_value, $resource, $resource_name)
    {
        if ($resource->user->id == $user->id) {
            $message;
            if($vote_value == 1) {
                $message = __("You cannot upvote your own {$resource_name}s");
            } else {
                $message = __("You cannot downvote your own {$resource_name}s");
            }
            return $this->deny(__($message));
        }

        if ($user->isBanned()) {
            $this->deny("You cannot vote because you're currently banned !");
        }
        return true;
    }
}
