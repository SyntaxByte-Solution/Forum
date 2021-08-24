<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Thread, Post, Report};

class ReportPolicy
{
    use HandlesAuthorization;

    const THREAD_REPORT_ATTEMPTS = 20;
    const POST_REPORT_ATTEMPTS = 26;

    public function thread_report(User $user, $thread) {
        if($user->isBanned()) {
            return $this->deny(__("You can't report resources because you're currently banned"));
        }

        // User can only report a resource once
        $thread = Thread::find($thread);
        $found = $thread->reports->where('user_id', $user->id)->where('reportable_id', $thread->id)->where('reportable_type', 'App\Models\Thread')->count();

        if($found) {
            return $this->deny(__("You can't report this resource because you already report it."));
        }

        return true;
    }

    public function post_report(User $user, $post) {
        if($user->isBanned()) {
            return $this->deny(__("You can't report resources because you're currently banned"));
        }

        // User can only report a resource once
        $post = Post::find($post);
        $found = $post->reports->where('user_id', $user->id)->where('reportable_id', $post->id)->where('reportable_type', 'App\Models\Post')->count();

        if($found) {
            return $this->deny("You can't report this resource because you already report it.");
        }

        return true;
    }
}
