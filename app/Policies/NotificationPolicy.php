<?php

namespace App\Policies;

use App\Models\{User, Notification};
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function disable(User $user, $notification_id) {
        return $this->shared_condition($user, $notification_id);
    }

    public function enable(User $user, $notification_id) {
        return $this->shared_condition($user, $notification_id);
    }

    public function delete(User $user, $notification_id) {
        return $this->shared_condition($user, $notification_id);
    }

    private function shared_condition($user, $notification_id) {
        $notifiable_id = Notification::where('id', $notification_id)->firstOrFail()->notifiable_id;
        return $notifiable_id == $user->id;
    }
}
