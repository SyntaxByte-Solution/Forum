<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Carbon\Carbon;
use App\Models\{User, NotificationDisable};

class HeaderNotification extends Component
{
    public $notification;
    public $notification_id;

    public $action_resource_link;
    public $action_user;
    public $action_takers;
    public $action_statement;
    public $resource_string_slice;
    public $action_type;
    public $resource_action_icon;
    public $action_date;
    public $notif_read;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification_id = isset($notification['notif_id']) ? $notification['notif_id'] : '';
        $this->action_user = $notification['action_user'];
        $this->action_takers = $notification['action_takers'];
        $this->action_statement = $notification['action_statement'];
        $this->resource_string_slice = $notification['resource_string_slice'];
        $this->action_date = $notification['action_date'];
        $this->action_resource_link = $notification['action_resource_link'];
        $this->resource_action_icon = $notification['resource_action_icon'];
        $this->notif_read = $notification['notif_read'];
        $this->disabled = $notification['disabled'];

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.header-notification', $data);
    }
}
