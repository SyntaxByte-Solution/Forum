<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowPolicy
{
    use HandlesAuthorization;

    public function follow_user(User $user, $u) {
        if ($user->isBanned())
            $this->deny(__("You cannot follow people because you're currently banned"));

        if ($u->isBanned())
            $this->deny(__("You can't follow this user because it is currently banned"));

        if($u->id == $user->id)
            $this->deny(__("You can't follow yourself"));

        if(!$u->has_status('active'))
            $this->deny(__("Something wrong happens"));

        return true;
    }
}
