<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function mark_as_read() {
        $user = auth()->user();
        $this->authorize('mark_as_read', $user);

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }
}
