<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserAction extends Notification// implements ShouldQueue
{
    use Queueable;

    //public $afterCommit = true;
    public $action_user;
    public $action_statement;
    public $resource_string_slice;
    public $action_type;
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
        $this->action_statement = $data['action_statement'];
        $this->resource_string_slice = $data['resource_string_slice'];
        $this->action_type = $data['action_type'];
        $this->action_resource_id = $data['action_resource_id'];
        $this->action_resource_link = $data['action_resource_link'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => "this is data",
        ]);
    }
}
