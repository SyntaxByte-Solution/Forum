<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\ThreadClosedException;
use App\Models\{Post, ThreadStatus, Thread};
use App\View\Components\PostComponent;


class PostController extends Controller
{
    public function store() {
        
        $data = request()->validate([
            'content'=>'required|min:2|max:40000',
            'thread_id'=>'required|exists:threads,id',
        ]);
        $this->authorize('store', [Post::class, $data['thread_id']]);

        $current_user = auth()->user();
        $thread = Thread::find($data['thread_id']);
        $thread_owner = $thread->user;
        $thread_status_slug = ThreadStatus::find($thread->status_id)->slug;

        if($thread_status_slug == 'closed') {
            throw new ThreadClosedException("You can't share posts on a closed thread");
        }
        
        if($thread_status_slug == 'temp.closed') {
            throw new ThreadClosedException("You can't share posts on a temporarily closed thread");
        }

        /**
         * Before notify the user we have to fetch all the notifications that have the same resource_id
         * and action_type and pluck the users's names and delete all those notifications and add one with the collection of names
         * like following: 
         * grotto_IV, hostname47 and hitman replied to your thread
         * Actually this is useful for likes not for comment all we need to do is delete existing 
         * notifications related to this thread with this action type and add this one
         */
        
        foreach($thread_owner->notifications as $notification) {
            if($notification->data['action_resource_id'] == $thread->id && $notification->data['action_type'] == 'thread-reply') {
                $notification->delete();
            }
        }
        
        if($thread_owner->id != $current_user->id) {
            $thread_owner->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>$current_user->id,
                    'action_statement'=>"replied to your thread:",
                    'resource_string_slice'=> (strlen($thread->subject) > 30) ? substr($thread->subject, 0, 30) . '..' : $thread->subject,
                    'action_type'=>'thread-reply',
                    'action_resource_id'=>$thread->id,
                    'action_resource_link'=>route('thread.show', ['forum'=>$thread->forum()->slug, 'category'=>$thread->category->slug, 'thread'=>$thread->user]),
                ])
            );
        }

        $data['user_id'] = auth()->user()->id;
        
        
        $post = Post::create($data);

        
        // First we create a component class instance
        $component = (new PostComponent($post->id));
        // Then we pass the data to the render method on component class and pass that data to the component view
        $component = $component->render(get_object_vars($component))->render();
        // Then return that view
        return $component;
    }

    public function update(Post $post) {
        $this->authorize('update', $post);

        $data = request()->validate([
            'content'=>'sometimes|min:2|max:40000',
        ]);
        
        $post->update($data);
    }

    public function destroy(Post $post) {
        $this->authorize('destroy', $post);

        $post->delete();
    }

    public function tick(Post $post) {
        $this->authorize('tick', $post);

        /**
         * Here we disable timestamps and use save method instead of update directly model because we don't
         * want to set updated_at timestamp when changing tecked column
        */
        $post->timestamps = false;
        if($post->ticked) {
            $post->ticked = false;
            $post->save();
            return 0;
        } else {
            $post->ticked = true;
            $post->save();
            return 1;
        }
    }
}
