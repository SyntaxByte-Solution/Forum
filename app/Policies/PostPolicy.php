<?php

namespace App\Policies;

use App\Exceptions\UserBannedException;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function store(User $user)
    {
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        // The user should be: authenticated, not banned and post less than 280 posts per day.
        return $user->today_posts_count() < 280;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        //
    }
}
