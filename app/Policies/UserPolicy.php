<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, $u)
    {
        return $user->id == $u->id;
    }

    public function update(User $user, $u)
    {
        if($user->isBanned()) {
            return $this->deny(__("You can't update your settings because you're currently banned"));
        }

        return $user->id == $u->id;
    }

    public function delete(User $user, User $model)
    {
        return $user->id == $model->id;
    }
}
