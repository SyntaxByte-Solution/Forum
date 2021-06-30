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

    public function notification_generate(Request $request) {
        $notification = $request->validate([
            'action_user'=>'required|exists:users,id',
            'action_statement'=>'required|max:400',
            'resource_string_slice'=>'required|max:400',
            'action_date'=>'required|max:400',
            'action_resource_link'=>'required|max:400',
            'resource_action_icon'=>'required|max:400',
        ]);

        $notification['action_user'] = User::find($notification['action_user']);
        $notification['action_takers'] = User::find($notification['action_user'])->first()->minified_name;

        $notification_component = (new Notification($notification));
        $notification_component = $notification_component->render(get_object_vars($notification_component))->render();
        
        return $notification_component;
    }

    public function notification_generate_range(Request $request) {
        $data = $request->validate([
            'range'=>'required|Numeric',
            'state_counter'=>'required|Numeric',
        ]);

        $skipable_items = $data['state_counter'] * $data['range'];
        $notifs_to_return = auth()->user()->notifs->skip($skipable_items)->take($data['range']);

        $payload = "";

        foreach($notifs_to_return as $notification) {
            $notification_component = (new Notification($notification));
            $notification_component = $notification_component->render(get_object_vars($notification_component))->render();
            $payload .= $notification_component;
        }

        return $payload;
    }
}
