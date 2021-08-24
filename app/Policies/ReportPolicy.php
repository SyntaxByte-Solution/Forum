<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\{Thread, Post, Report};

class ReportPolicy
{
    use HandlesAuthorization;

    const THREAD_REPORT_ATTEMPTS = 20;
    const POST_REPORT_ATTEMPTS = 36;

    public function thread_report(User $user, $thread) {
        if($user->isBanned()) {
            return $this->deny(__("You can't report resources because you're currently banned"));
        }
        $thread = Thread::find($thread);
        
        // User could report threads with a limited number per day (THREAD_REPORT_ATTEMPTS)
        $number_of_thread_reports = Report::today()->where('reportable_type', 'App\Models\Thread')->where('user_id', $user->id)->count();
        if($number_of_thread_reports >= self::THREAD_REPORT_ATTEMPTS) {
            return $this->deny(__("You reach the limited thread reporting attempts allowed per day"));
        }

        // User can only report a resource once
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
        $post = Post::find($post);

        // User could report threads with a limited number per day (THREAD_REPORT_ATTEMPTS)
        $number_of_post_reports = Report::today()->where('reportable_type', 'App\Models\Post')->where('user_id', $user->id)->count();
        if($number_of_post_reports >= self::POST_REPORT_ATTEMPTS) {
            return $this->deny(__("You reach the limited thread reporting attempts allowed per day"));
        }
        // User can only report a resource once
        $found = $post->reports->where('user_id', $user->id)->where('reportable_id', $post->id)->where('reportable_type', 'App\Models\Post')->count();
        if($found) {
            return $this->deny("You can't report this resource because you already report it.");
        }

        return true;
    }
}
