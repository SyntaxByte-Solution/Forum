<?php

namespace App\View\Components\User;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, Follow};

class Follows extends Component
{
    public $followed_by_current_user;
    public $followed;

    public function __construct(User $user)
    {
        $this->followed_by_current_user = $user;
        if(Auth::check()) {
            $this->followed = (bool) Follow::where('follower', auth()->user()->id)
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
        return view('components.user.follows', $data);
    }
}
