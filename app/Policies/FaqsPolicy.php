<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqsPolicy
{
    use HandlesAuthorization;

    public function store(User $user) {
        // User could only post 8 question per day
        if($user->faqs()->whereDate('created_at', \Carbon\Carbon::today())->count() > 8) {
            return $this->deny(__('You could only ask 8 question per day.'));
        } else {
            return true;
        }
    }
}
