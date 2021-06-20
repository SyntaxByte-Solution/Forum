<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    public function store(User $user)
    {
        if ($user->isBanned()) {
            $this->deny("You cannot vote because you're currently banned !");
        }
        return true;
    }
}
