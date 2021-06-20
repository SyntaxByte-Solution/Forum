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
        return $this->handle_resource_like($request, $thread, 'App\Models\Post');
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
            return 0;
        } else {
            $resource->likes()->save($like);
            return 1;
        }
    }
}
