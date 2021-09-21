<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use Carbon\Carbon;

class UserAction extends Notification implements ShouldBroadcast
{
    use Queueable;

    //public $afterCommit = true;
    public $action_user;
    public $action_statement;
    public $resource_string_slice;
    public $action_type;
    public $action_date;
    public $action_resource_id;
    public $action_resource_link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->action_user = $data['action_user'];
        $this->action_statement = __($data['action_statement']);
        $this->resource_string_slice = $data['resource_string_slice'];
        $this->action_type = $data['action_type'];
        $this->action_resource_id = $data['action_resource_id'];
        $this->action_resource_link = $data['action_resource_link'];
        $this->action_date = (new Carbon($data['action_date']))->diffForHumans();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable) {
        return [
            'action_user'=>$this->action_user,
            'action_statement'=>$this->action_statement,
            'resource_string_slice'=>$this->resource_string_slice,
            'action_type'=>$this->action_type,
            'action_resource_id'=>$this->action_resource_id,
            'action_resource_link'=>$this->action_resource_link,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        $action_type = $this->action_type;
        $resource_action_icon = '';

        if($action_type == 'thread-reply') {
            $resource_action_icon = 'resource24-reply-icon';
        } else if($action_type == 'thread-vote' || $action_type == 'reply-vote') {
            $resource_action_icon = 'resource24-vote-icon';
        } else if($action_type == 'reply-like' || $action_type == 'thread-like') {
            $resource_action_icon = 'resource24-like-icon';
        } else if($action_type == 'user-follow') {
            $resource_action_icon = 'followfilled24-icon';
        } else if($action_type == 'avatar-change') {
            $resource_action_icon = 'image24-icon';
        } else if($action_type == 'poll-add') {
            $resource_action_icon = 'poll24-icon';
        } else if($action_type == 'poll-vote') {
            $resource_action_icon = 'pollvote24-icon';
        } else if($action_type == 'poll-option-add') {
            $resource_action_icon = 'polloptionadd24-icon';
        } else {
            $resource_action_icon = 'notification24-icon';
        }

        return (new BroadcastMessage([
            "image"=>User::find($this->action_user)->sizedavatar(100),
            "action_user"=>$this->action_user,
            "action_taker_name"=>User::find($this->action_user)->minified_name,
            "action_statement"=>$this->action_statement,
            'resource_string_slice'=>$this->resource_string_slice,
            'resource_date'=>$this->action_date,
            'action_resource_link'=>$this->action_resource_link,
            'resource_action_icon'=>$resource_action_icon,
            'action_type'=>$this->action_type
        ]));
    }

    public function broadcastType()
    {
        return 'resource.reaction';
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
