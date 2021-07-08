<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowPolicy
{
    use HandlesAuthorization;

    public function follow_user(User $user, $u)
    {
        if ($user->isBanned()) {
            $this->deny("You cannot follow people because you're currently banned !");
        }
        
        if($u->id == auth()->user()->id) {
            $this->deny("You cannot follow people because you're currently banned !");
        }
        return true;
    }
}
