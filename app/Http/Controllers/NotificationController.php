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
            "hasNext"=> auth()->user()->notifs->skip(($data['skip']+ $data['range']))->count() > 0,
            "content"=>$payload,
            "count"=>$notifs_to_return->count()
        ];
    }

    public function generate_header_notifications_bootstrap() {
        $payload = "";
        $user = auth()->user();

        $hasnotifs = false;
        // unique_notifications($skip, $take, $goover)
        foreach($user->unique_notifications(0, 6, 0) as $notification) {
            $hasnotifs = true;
            $notification_component = (new HeaderNotification($notification));
            $notification_component = $notification_component->render(get_object_vars($notification_component))->render();
            $payload .= $notification_component;
        }

        $none = "";
        if(!$hasnotifs) {
            $none="none";
        }

        $notif_empty = __('Notifications box is empty');
        $text_after_empty = __('Try to start discussions/questions or react to people posts');
        $payload .= 
            <<<EMPTY
            <div class="notification-empty-box my8 $none">
                <svg class="flex size28 move-to-middle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 438.53 438.53"><path d="M431.4,211l-68-157.6A25.47,25.47,0,0,0,353,41.4q-7.56-4.86-15-4.86H100.5q-7.43,0-15,4.86a25.52,25.52,0,0,0-10.42,12L7.14,211A91.85,91.85,0,0,0,0,246.1V383.72a17.59,17.59,0,0,0,5.42,12.85A17.61,17.61,0,0,0,18.27,402h402a18.51,18.51,0,0,0,18.26-18.27V246.1A91.84,91.84,0,0,0,431.4,211ZM292.07,237.54,265,292.36H173.59l-27.12-54.82H56.25a12.85,12.85,0,0,0,.71-2.28,13.71,13.71,0,0,1,.72-2.29L118.2,91.37H320.34L380.86,233c.2.58.43,1.34.71,2.29s.53,1.7.72,2.28Z"/></svg>
                <h3 class="my4 fs17 text-center">$notif_empty</h3>
                <p class="my4 fs13 gray text-center">$text_after_empty.</p>
            </div>
            EMPTY;
        if($c == 6) {
            $load_more = __('load more');
            $payload .=
                <<<AE
                    <input type='button' class="see-all-full-style notifications-load" value="$load_more">
                AE;
        }

        return $payload;
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
