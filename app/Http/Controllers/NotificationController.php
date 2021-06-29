<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\View\Components\User\Notification;
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

    public function notification_component_generate(Request $request) {
        $notification = $request->validate([
            'action_user'=>'required|exists:users,id',
            'action_takers'=>'required|min:2|max:60',
            'action_statement'=>'required|max:200',
            'resource_string_slice'=>'required|max:200',
            'action_date'=>'required|max:200',
            'action_resource_link'=>'required|max:400',
            'resource_action_icon'=>'required|max:400',
        ]);

        $notification_component = (new Notification($notification));
        
        $notification_component = $notification_component->render(get_object_vars($component))->render();
        
        return $component;
    } 
}
