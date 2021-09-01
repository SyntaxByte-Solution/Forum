<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    public function store(User $user, $resource, $type)
    {
        if ($user->isBanned()) {
            $this->deny(__("You cannot like this resource because you're currently banned"));
        }

        if($type == 'App\Models\Thread') {
            if($resource->status->slug == 'closed') {
                $this->deny(__("You cannot like closed discussions"));
            }
        }
             

        return true;
    }
}
