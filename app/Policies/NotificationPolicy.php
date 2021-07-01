<?php

namespace App\Policies;

use App\Models\{User, Notification};
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, $notification_id) {
        $notifiable_id = Notification::where('id', $notification_id)->firstOrFail()->notifiable_id;
        return $notifiable_id == $user->id;
    }
}
