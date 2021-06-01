<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use App\Exceptions\UserBannedException;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function create(User $user) {
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        return true;
    }

    public function edit(User $user, Thread $thread) {
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        return $thread->user_id == $user->id;
    }

    /**
     * Determine whether the user can store models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        // The user should be: authenticated, not banned and post less than 60 threads per day.
        return $user->threads()->today()->count() < 60;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Thread  $thread
     * @return mixed
     */
    public function update(User $user, Thread $thread)
    {
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        return $thread->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Thread  $thread
     * @return mixed
     */
    public function destroy(User $user, Thread $thread)
    {
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        return $thread->user_id == $user->id;
    }
}
