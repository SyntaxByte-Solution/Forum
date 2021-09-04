<?php

namespace App\Policies;

use App\Models\{User, Thread, Category, CategoryStatus};
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use App\Exceptions\UserBannedException;

class ThreadPolicy
{
    use HandlesAuthorization;

    const THREADS_RATE_PER_DAY = 20;

    public function create(User $user) {
        if($user->isBanned()) {
            return $this->deny(__("You can't create new discussions because you're currently banned"));
        }

        return true;
    }

    public function edit(User $user, Thread $thread) {
        if($user->isBanned()) {
            return $this->deny(__("You can't edit your discussions because you're currently banned"));
        }

        return $thread->user_id == $user->id;
    }

    /**
     * Determine whether the user can store models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function store(User $user, $category_id)
    {
        if($user->isBanned()) {
            return $this->deny(__("You can't create new discussions because you're currently banned"));
        }
        
        // The user could only share 20 threads per day.
        if($user->threads()->today()->count() >= self::THREADS_RATE_PER_DAY)
            return $this->deny(__("You reached your discussions sharing limit allowed per day, try out later") . '. (' . self::THREADS_RATE_PER_DAY . ' ' . 'discussions' . ')');

        // Verify the category status
        $category_status_slug = CategoryStatus::find(Category::find($category_id)->status)->slug;
        if($category_status_slug == 'closed' || $category_status_slug == 'temp.closed') {
            return $this->deny(__("You could not share discussions on a closed category"));
        }
        
        // Verify category by preventing normal user to post on announcements
        // Note: these check normally should be in thread policy because we do want the admins to post announcements
        $announcements_ids = Category::where('slug', 'announcements')->pluck('id')->toArray();
        if(in_array($category_id, $announcements_ids)) {
            return $this->deny(__("You could not share announcements because you don't have the right privileges"));
        }

        return true;
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
            return $this->deny(__("You can't edit your discussions because you're currently banned"));
        }

        if($thread->status->slug == 'closed' || $thread->status->slug == 'temp.closed') {
            return $this->deny(__("You could not update a closed discussions"));
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
    public function delete(User $user, Thread $thread)
    {
        if($user->isBanned()) {
            return $this->deny(__("You can't delete your discussions because you're currently banned"));
        }

        return $thread->user_id == $user->id;
    }

    public function save(User $user, Thread $thread) {
        /**
         * 1. User should not be banned
         */
        if($user->isBanned()) {
            return $this->deny(__("You could not save discussions because you're currently banned"));
        }

        return true;
    }

    public function destroy(User $user, Thread $thread)
    {
        if($user->isBanned()) {
            return $this->deny(__("You can't delete your discussions because you're currently banned"));
        }

        return $thread->user_id == $user->id;
    }
}
