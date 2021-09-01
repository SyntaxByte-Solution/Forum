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
            return $this->deny("You can't update your settings because you're currently banned");
        }

        return $user->id == $u->id;
    }

    public function activate_account(User $user)
    {
        // If an admin ban the current user then the user could not active or deactive his account and then if he visit activation page we prevent him
        if($user->isBanned()) {
            return $this->deny("Unauthorized action. You are currently banned !");
        }
        if(!$user->account_deactivated()) {
            return redirect('/')->with('message', __("You can't access account activation page because your account is already activated"));
        }
        return $user->id == $u->id;
    }

    public function delete(User $user, User $model)
    {
        return $user->id == $model->id;
    }
}
