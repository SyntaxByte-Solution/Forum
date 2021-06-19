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

    public function tick(User $user, Post $post) {
        if($user->isBanned()) {
            return $this->deny("You can't update your threads because you're currently banned");
        }

        /**
         * 1. verify if the user is the owner of the thread where the post is attached to
         * 2. verify if the thread is closed
         * 2. verify if the thread has already a ticked post [different than the curren one because
         * the owner could make it ticked and then click on it to remove the tick]; 
         * If we found one, we can't make the fetched post ticked otherwise we continue
         */

        if($post->thread->user->id != $user->id) {
            return $this->deny("You can't tick a post attached to a thread you don't own");
        }

        if($post->thread->isClosed()) {
            return $this->deny("You can't tick a post attached to a closed thread");
        }

        foreach($post->thread->posts as $p) {
            if($p->ticked && $p->id != $post->id) {
                return $this->deny("This thread has already a ticked reply");
                break;
            }
        }

        return true;
    }
}
