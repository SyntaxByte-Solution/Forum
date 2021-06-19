<?php

namespace App\Policies;

use App\Exceptions\UserBannedException;
use App\Models\Post;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function store(User $user, $thread_id)
    {
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        if(Thread::find($thread_id)->status->id == 3) {
            return $this->deny("You can't post on this thread because the owner is turning off the replies");
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
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        return $post->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function destroy(User $user, Post $post)
    {
        if($user->isBanned()) {
            throw new UserBannedException();
        }

        return $post->user_id == $user->id;
    }
}
