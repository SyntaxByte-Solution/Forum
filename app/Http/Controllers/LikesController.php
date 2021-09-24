<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Thread, Post, Like};

class LikesController extends Controller
{
    public function thread_like(Thread $thread) {
        return $this->handle_resource_like($thread, 'App\Models\Thread');
    }

    public function post_like(Post $post) {
        return $this->handle_resource_like($post, 'App\Models\Post');
    }

    private function handle_resource_like($resource, $type) {
        $this->authorize('store', [Like::class, $resource, $type]);

        $current_user = auth()->user();
        $likefound = Like::where('user_id', $current_user->id)
            ->where('likable_type', $type)
            ->where('likable_id', $resource->id);

        $like = new Like;
        $like->user_id = $current_user->id;
        if($likefound->count()) {
            $likefound->delete();
            // Only delete notification if user is not the owner of resource
            if($resource->user->id != auth()->user()->id) {
                $resource_type = strtolower(substr($type, strrpos($type, '\\') + 1));
                // Check if there's a notification of like before
                \DB::statement(
                    "DELETE FROM `notifications` 
                    WHERE JSON_EXTRACT(data, '$.action_type')='resource-like'
                    AND JSON_EXTRACT(data, '$.action_user') = " . $current_user->id .
                    " AND JSON_EXTRACT(data, '$.resource_type')='" . $resource_type .
                    "' AND JSON_EXTRACT(data, '$.action_resource_id')=" . $resource->id
                );
            }

            return 0;
        } else {
            $resource->likes()->save($like);

            /** ---------- NOTIFY USER ---------- */
            // First we check if the owner of the resource disable the notification
            // Then, only notifiy resource owner when the like takes place;
            // If the user is click like button to remove his like we don't have to notify the resource owner
            // we don't have the user to get notification when he reacted to his own resources

            $disabled = (bool) $resource->user->disables
                        ->where('disabled_type', $type)
                        ->where('disabled_id', $resource->id)->count();
            if(!$disabled) {
                if($current_user->id != $resource->user->id) {
                    $resource_link = $resource->link;
                    $type_name = strtolower(substr($type, strrpos($type, '\\') + 1));
                    $resource_type = 'thread';
                    if($type_name == 'post') {
                        $resource_link = $resource->thread->link . '?reply='.$resource->id;
                        $type_name = 'reply';
                        $resource_type = 'post';
                    }
                    if($type_name == 'thread') {
                        $type_name = 'post';
                    }

                    $resource->user->notify(
                        new \App\Notifications\UserAction([
                            'action_user'=>$current_user->id,
                            'action_statement'=>"liked your $type_name :",
                            'resource_string_slice'=> $resource->slice,
                            'resource_type'=>$resource_type,
                            'action_type'=>'resource-like',
                            'action_date'=>now(),
                            'action_resource_id'=>$resource->id,
                            'action_resource_link'=>$resource_link
                        ])
                    );
                }
            }

            return 1;
        }
    }
}
