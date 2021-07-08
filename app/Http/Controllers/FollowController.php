<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\View\Components\User\Follow as FollowComponent;
use App\Models\{User, Thread, Follow};

class FollowController extends Controller
{
    public function follow_user(User $user) {
        $this->authorize('follow_user', [Follow::class, $user]);

        $current_user = auth()->user();

        $found = Follow::where('follower', $current_user->id)
            ->where('followable_id', $user->id)
            ->where('followable_type', 'App\Models\User');

        if($found->count()) {
            $found->first()->delete();
            return -1;
        }

        $follow = new Follow;
        $follow->follower = $current_user->id;
        $user->followers()->save($follow);

        return 1;
    }

    public function follow_thread(Thread $user) {
        
    }

    public function followers_load(Request $request, User $user) {
        $data = $request->validate([
            'range'=>'required|Numeric',
            'skip'=>'required|Numeric',
        ]);

        $followers_to_return = $user->followers->skip($data['skip'])->take($data['range']);

        $payload = "";

        foreach($followers_to_return as $follower) {
            $follower = User::find($follower->follower);
            $follower_component = (new FollowComponent($follower));
            $follower_component = $follower_component->render(get_object_vars($follower_component))->render();
            $payload .= $follower_component;
        }

        return [
            "hasNext"=> auth()->user()->followers->skip(($data['skip']+1) * $data['range'])->count() > 0,
            "content"=>$payload,
            "count"=>$followers_to_return->count()
        ];
    }
}
