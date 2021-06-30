<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Thread, Post, Like};

class LikesController extends Controller
{
    public function thread_like(Request $request, Thread $thread) {
        return $this->handle_resource_like($request, $thread, 'App\Models\Thread');
    }

    public function post_like(Request $request, Post $post) {
        return $this->handle_resource_like($request, $post, 'App\Models\Post');
    }

    private function handle_resource_like($request, $resource, $type) {
        $this->authorize('store', Like::class);

        $current_user = auth()->user();

        $founded_like = false;
        foreach($resource->likes as $like) {
            if($current_user->id == $like->user_id) {
                $founded_like = $like;
                break;
            }
        }

        $like = new Like;
        $like->user_id = $current_user->id;
        if($founded_like) {
            $founded_like->delete();

            // Check if there's a notification of like before
            foreach($resource->user->notifications as $notification) {
                if($notification->data['action_type'] == "resource-like" 
                && $notification->data['action_user'] == $current_user->id
                && $notification->data['action_resource_id'] == $resource->id) {
                    $notification->delete();
                }
            }

            return 0;
        } else {
            $resource->likes()->save($like);

            /** ---------- NOTIFY USER ---------- */
            // Only notifiy resource owner when the like takes place;
            // If the user is click like button to remove his like we don't have to notify the resource owner
            // we don't have the user to get notification when he reacted to his own resources
            if($current_user->id != $resource->user->id) {
                $type_name = strtolower(substr($type, strrpos($type, '\\') + 1));
                if($type_name == 'post') {
                    $type_name = 'reply';
                }

                $resource->user->notify(
                    new \App\Notifications\UserAction([
                        'action_user'=>$current_user->id,
                        'action_statement'=>"liked your " . $type_name . ':',
                        'resource_string_slice'=> $resource->slice,
                        'action_type'=>'resource-like',
                        'action_date'=>now(),
                        'action_resource_id'=>$resource->id,
                        'action_resource_link'=>$resource->link
                    ])
                );
            }

            return 1;
        }
    }
}
