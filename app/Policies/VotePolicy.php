<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;

class VotePolicy
{
    use HandlesAuthorization;

    const THREADS_VOTE_LIMIT = 200;
    const POSTS_VOTE_LIMIT = 300;

    public function store(User $user, $vote_value, $resource, $resource_name)
    {
        if($resource_name == 'thread') $resource_name = 'discussions';
        if($resource_name == 'post') $resource_name = 'replies';

        if ($user->isBanned()) {
            return $this->deny("You cannot vote because you're currently banned !");
        }

        if ($resource->user->id == $user->id) {
            return $this->deny(__("You cannot vote your own $resource_name"));
        }

        if($resource_name == 'discussions') {
            if($user->votes_on_threads() > self::THREADS_VOTE_LIMIT) {
                return $this->deny(__("You reached your discussions voting limit allowed per day, try out later") . '. (' . self::THREADS_VOTE_LIMIT . ' ' . 'votes' . ')');
            }
        } else if($resource_name == 'replies') {
            if($user->votes_on_posts() > self::THREADS_VOTE_LIMIT) {
                return $this->deny(__("You reached your replies voting limit allowed per day, try out later") . '. (' . self::POSTS_VOTE_LIMIT . ' ' . 'votes' . ')');
            }
        }

        return true;
    }
}
