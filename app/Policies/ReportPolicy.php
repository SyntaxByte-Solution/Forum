<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Thread;

class ReportPolicy
{
    use HandlesAuthorization;

    public function thread_report(User $user, $thread) {
        if($user->isBanned()) {
            return $this->deny("You can't report resources because you're currently banned");
        }

        // User can only report a resource once
        $thread = Thread::find($thread);
        $found = $thread->reports->where('user_id', $user->id)->where('reportable_id', $thread->id)->where('reportable_type', 'App\Models\Thread')->count();

        if($found) {
            return $this->deny("You can't report this resource because you already report it.");
        }

        return true;
    }
}
