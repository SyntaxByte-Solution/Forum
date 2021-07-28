<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\View\Components\User\HeaderNotification;
use App\Models\{User, Notification, NotificationDisable, Thread, Post};

class NotificationController extends Controller
{
    public function notifications() {
        $user = auth()->user();

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return view('user.notifications')
            ->with(compact('user'));
    }

    public function mark_as_read() {
        $user = auth()->user();

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }

    public function notification_generate(Request $request) {
        $notification = $request->validate([
            'notif_id'=>'required|exists:notifications,id',
            'action_user'=>'required|exists:users,id',
            'action_statement'=>'sometimes|max:400',
            'resource_string_slice'=>'sometimes|max:400',
            'action_date'=>'required|max:400',
            'action_resource_link'=>'required|max:400',
            'resource_action_icon'=>'required|max:400',
            'action_type'=>'required|max:800'
        ]);

        $notification['action_user'] = User::find($notification['action_user']);
        $notification['action_takers'] = $notification['action_user']->minified_name;
        $notification['notif_read'] = false;

        $notification_component = (new HeaderNotification($notification));
        $notification_component = $notification_component->render(get_object_vars($notification_component))->render();
        
        return $notification_component;
    }

    public function notification_generate_range(Request $request) {
        $data = $request->validate([
            'range'=>'required|Numeric',
            'skip'=>'required|Numeric',
        ]);

        $notifs_to_return = auth()->user()->notifs->skip($data['skip'])->take($data['range']);

        $payload = "";

        foreach($notifs_to_return as $notification) {
            $notification_component = (new HeaderNotification($notification));
            $notification_component = $notification_component->render(get_object_vars($notification_component))->render();
            $payload .= $notification_component;
        }

        return [
            "hasNext"=> auth()->user()->notifs->skip(($data['skip']+1) * $data['range'])->count() > 0,
            "content"=>$payload,
            "count"=>$notifs_to_return->count()
        ];
    }

    public function disable(Request $request, $notification_id) {
        $this->authorize('disable', [Notification::class, $notification_id]);

        $notification = Notification::find($notification_id);
        $notification_data = \json_decode($notification->data);
        
        $current_user = auth()->user();
        $resource_id = $notification_data->action_resource_id;
        $resource_type = explode('-', $notification_data->action_type)[0];

        $disable = new NotificationDisable;
        $disable->user_id = $current_user->id;

        if($resource_type == "thread") {
            Thread::find($resource_id)->disables()->save($disable);
        } else if($resource_type == "reply") {
            Post::find($resource_id)->disables()->save($disable);
        }

        return 'disabled';
    }

    public function enable(Request $request, $notification_id) {
        $this->authorize('enable', [Notification::class, $notification_id]);

        $notification = Notification::find($notification_id);
        $notification_data = \json_decode($notification->data);
        
        $current_user = auth()->user();
        $resource_id = $notification_data->action_resource_id;
        $resource_type = explode('-', $notification_data->action_type)[0];

        $disable = new NotificationDisable;
        $disable->user_id = $current_user->id;

        if($resource_type == "thread") {
            NotificationDisable::where('disabled_id', $resource_id)
            ->where('disabled_type', 'App\Models\Thread')
            ->where('user_id', $current_user->id)
            ->delete();
        } else if($resource_type == "reply") {
            NotificationDisable::where('disabled_id', $resource_id)
            ->where('disabled_type', 'App\Models\Post')
            ->where('user_id', $current_user->id)
            ->delete();
        }


        return 'enabled';
    }

    public function destroy(Request $request, $notification_id) {
        $this->authorize('delete', [Notification::class, $notification_id]);

        $notification = Notification::find($notification_id);
        $notification_data = \json_decode($notification->data);
        $current_user = auth()->user();

        foreach($current_user->notifications as $notif) {
            if($notif->data['action_resource_id'] == $notification_data->action_resource_id && $notif->data['action_type'] == $notification_data->action_type) {
                $notif->delete();
            }
        }

        // Cleaning up notification disables related to this notification
        $notification_resource_id = $notification_data->action_resource_id;
        $notification_resource_type = explode('-', $notification_data->action_type)[0];
        $notifiable_user = $notification->notifiable_id;

        if($notification_resource_type == 'thread') {
            $notification_resource_type = "App\Models\Thread";
        } else if($notification_resource_type == 'post') {
            $notification_resource_type = "App\Models\Post";
        }

        NotificationDisable::where('user_id', $notifiable_user)
        ->where('disabled_type', $notification_resource_type)
        ->where('disabled_id', $notification_resource_id)
        ->delete();
    }
}
