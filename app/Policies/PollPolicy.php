<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{OptionVote};

class PollPolicy
{
    use HandlesAuthorization;

    public function option_vote(User $user) {
        if ($user->isBanned())
            return $this->deny(__("Unauthorized action ! you're currently banned"));
    }
}
