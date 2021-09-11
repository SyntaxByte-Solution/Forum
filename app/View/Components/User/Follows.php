<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Follow};

class Follows extends Component
{
    public $followed_by_current_user;
    public $followed;

    public function __construct(Follow $followeduser)
    {
        $this->followed_by_current_user = User::find($followeduser->followable_id);
        if(Auth::check()) {
            $this->followed = auth()->user()->follows()
            ->where('followable_id', $followeduser->followable_id)
            ->where('followable_type', 'App\Models\User')
            ->count();
        } else
            $this->followed = false;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.follows', $data);
    }
}
