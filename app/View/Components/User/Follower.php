<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Follow};

class Follower extends Component
{
    public $follower;
    public $followed;

    public function __construct(Follow $follower)
    {
        $this->follower = User::find($follower->follower);
        if(Auth::check()) {
            $this->followed = (bool) auth()->user()->follows()
            ->where('followable_id', $follower->follower)
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
        return view('components.user.follower', $data);
    }
}
