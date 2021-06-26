<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\User;

class Notification extends Component
{
    public $notification;

    public $resource_link;
    public $action_user;
    public $action_user_name;
    public $action_statement;
    public $action_resource_slice;
    public $action_type;
    public $resource_action_icon;
    public $action_date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;

        $this->action_user = User::find($notification->data['action_user']);

        $this->action_user_name = 
            strlen($fullname=($this->action_user->firstname . ' ' . $this->action_user->lastname)) > 20
            ? strlen($username=$this->action_user->username) > 14 ? substr($fullname, 0, 14) . '..': $username
            : $fullname;

        $this->action_statement = $notification->data['action_statement'];
        
        $this->action_resource_slice = $notification->data['resource_string_slice'];
        $this->action_date = (new Carbon($notification->created_at))->diffForHumans();
        $this->resource_link = $notification->data['action_resource_link'];

        $action_type = $notification->data['action_type'];
        if($action_type == 'thread-reply') {
            $this->resource_action_icon = 'resource24-reply-icon';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user.notification');
    }
}
