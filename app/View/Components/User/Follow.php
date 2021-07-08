<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Follow as FLW};

class Follow extends Component
{
    public $follower;
    public $followed;

    public function __construct(User $user)
    {
        $this->follower = $user;
        if(Auth::check()) {
            $this->followed = (bool) FLW::where('follower', auth()->user()->id)
            ->where('followable_id', $user->id)
            ->where('followable_type', 'App\Models\User')
            ->count();
        } else {
            $this->followed = false;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render($data=[])
    {
        return view('components.user.follow', $data);
    }
}
