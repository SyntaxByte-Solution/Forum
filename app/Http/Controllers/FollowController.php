<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Thread, Follow};

class FollowController extends Controller
{
    public function follow_user(User $user) {
        $current_user = auth()->user();

        $found = Follow::where('follower', $current_user->id)
            ->where('followable_id', $user->id)
            ->where('followable_type', 'App\Models\User');

        if($found->count()) {
            $found->first()->delete();
            return -1;
        }

        $follow = new Follow;
        $follow->follower = $current_user->id;
        $user->followers()->save($follow);

        return 1;
    }

    public function follow_thread(Thread $user) {
        
    }
}
