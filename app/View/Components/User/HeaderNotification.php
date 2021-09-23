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
    public $resource_type;
    public $resource_action_icon;
    public $action_date;
    public $notif_read;
    public $disabled;
    public $could_be_disabled;

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
        $this->action_statement = __($notification['action_statement']);
        $this->resource_string_slice = $notification['resource_string_slice'];
        $this->resource_type = $notification['resource_type'];
        $this->action_date = $notification['action_date'];
        $this->action_resource_link = $notification['action_resource_link'];
        $this->resource_action_icon = $notification['resource_action_icon'];
        $this->notif_read = $notification['notif_read'];
        $this->disabled = isset($notification['disabled']) ? $notification['disabled'] : false;
        $this->could_be_disabled = false;
        $resources_could_be_disabled = ['thread', 'discussion', 'reply', 'post'];
        $action_type = $notification['action_type'];
        
        foreach ($resources_could_be_disabled as $resource_type) {
            if (strstr($action_type, $resource_type)) {
                $this->could_be_disabled = true;
                break;
            }
        }
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
