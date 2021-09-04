<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\View\Components\User\{Follower, Follows};
use App\Models\{User, Thread, Follow};

class FollowController extends Controller
{
    public function follow_user(User $user) {
        $this->authorize('follow_user', [Follow::class, $user]);

        $current_user = auth()->user();

        $found = Follow::where('follower', $current_user->id)
            ->where('followable_id', $user->id)
            ->where('followable_type', 'App\Models\User');

        /**
         * Before follow a user, we check if the current user already follow this user;
         * If so ($found->count()>0), we need to delete the follow record because in this case the user click on unfollow button
         * If not we simply create a follow model and attach the current user as follower to the followed user
         * and finally notify this user that the current user follow him
         */
        
        if($found->count()) {
            $found->first()->delete();

            foreach($user->notifications as $notification) {
                if($notification->data['action_type'] == "user-follow" 
                && $notification->data['action_user'] == $current_user->id
                && $notification->data['action_resource_id'] == $user->id) {
                    $notification->delete();
                }
            }
            return -1;
        }

        $follow = new Follow;
        $follow->follower = $current_user->id;
        $user->followers()->save($follow);

        $user->notify(
            new \App\Notifications\UserAction([
                'action_user'=>auth()->user()->id,
                'action_statement'=>__("starts following you"),
                'resource_string_slice'=>"",
                'action_type'=>'user-follow',
                'action_date'=>now(),
                'action_resource_id'=>$user->id,
                'action_resource_link'=>route('user.profile', ['user'=>$user->username]),
            ])
        );
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
            $follower_component = (new Follower($follower));
            $follower_component = $follower_component->render(get_object_vars($follower_component))->render();
            $payload .= $follower_component;
        }

        return [
            "hasNext"=> $user->followers->skip($data['skip']+$data['range'])->count() > 0,
            "content"=>$payload,
            "count"=>$followers_to_return->count()
        ];
    }
    public function follows_load(Request $request, User $user) {
        $data = $request->validate([
            'range'=>'required|Numeric',
            'skip'=>'required|Numeric',
        ]);

        $follows_to_return = $user->followed_users->skip($data['skip'])->take($data['range']);

        $payload = "";

        foreach($follows_to_return as $followed_user) {
            $followed_user = User::find($followed_user->followable_id);
            $follows_component = (new Follows($followed_user));
            $follows_component = $follows_component->render(get_object_vars($follows_component))->render();
            $payload .= $follows_component;
        }

        return [
            "hasNext"=> $user->followed_users->skip($data['skip']+$data['range'])->count() > 0,
            "content"=>$payload,
            "count"=>$follows_to_return->count()
        ];
    }
    public function generate_follower_component(User $user) {
        $follower_component = (new Follower($user));
        $follower_component = $follower_component->render(get_object_vars($follower_component))->render();

        return $follower_component;
    }
}
