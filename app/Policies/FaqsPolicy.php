<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqsPolicy
{
    use HandlesAuthorization;

    const RATE_LIMIT = 8;

    public function store(User $user) {
        if($user->faqs()->today()->count() > self::RATE_LIMIT) {
            return $this->deny(__('You reach your limited number of questions to ask per day') . ' (' . self::RATE_LIMIT . ' ' . __('questions') . ')');
        } else {
            return true;
        }
    }
}
