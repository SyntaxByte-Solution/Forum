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

    const POST_LIMIT = 260;

    public function store(User $user, $thread_id)
    {
        if ($user->isBanned()) {
            $this->deny(__("You cannot reply because you're currently banned"));
        }

        $thread = Thread::find($thread_id);
        if($thread->replies_off == 1) {
            return $this->deny(__("You can't reply on this thread because the owner is turning off the replies"));
        }
        
        if($thread->status->slug == 'closed') {
            return $this->deny(__("You can't reply on closed threads"));
        }

        if($thread->status->slug == 'temp.closed') {
            return $this->deny(__("You can't reply on temporarily closed threads"));
        }
        
        // The user should be: authenticated, not banned and post less than 280 posts per day.
        if($user->today_posts_count() > self::POST_LIMIT) {
            return $this->deny(__("You reached your replying limit allowed per day, try out later") . '. (' . self::POST_LIMIT . ' ' . 'replies' . ')');
        }
        return true;
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
        if ($user->isBanned()) {
            $this->deny(__("You cannot update replies because you're currently banned"));
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
    public function destroy(User $user, Post $post) {
        if ($user->isBanned()) {
            $this->deny(__("You cannot delete replies because you're currently banned"));
        }

        return $post->user_id == $user->id || $user->id == $post->thread->user->id;
    }

    public function fetch(User $user, Post $post) {
        if($user->isBanned()) {
            return $this->deny("You can't update your threads because you're currently banned");
        }
        
        return $post->user_id == $user->id;
    }

    public function tick(User $user, Post $post) {
        if($user->isBanned()) {
            return $this->deny("You can't tick replies because you're currently banned");
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
