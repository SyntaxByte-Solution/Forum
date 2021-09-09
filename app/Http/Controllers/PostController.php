<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exceptions\ThreadClosedException;
use App\Models\{Post, ThreadStatus, Thread};
use App\View\Components\PostComponent;
use App\View\Components\Thread\ViewerReply;
use Markdown;

class PostController extends Controller
{
    public function store(Request $request) {
        
        $data = $request->validate([
            'content'=>'required|min:2|max:40000',
            'thread_id'=>'required|exists:threads,id',
            'from'=> [
                'required',
                Rule::in(['thread-show','thread-viewer']),
            ]
        ]);
        $this->authorize('store', [Post::class, $data['thread_id']]);

        $current_user = auth()->user();
        $thread = Thread::find($data['thread_id']);
        $thread_owner = $thread->user;
        $thread_status_slug = ThreadStatus::find($thread->status_id)->slug;

        $data['user_id'] = auth()->user()->id;
        $from = $request->from;
        unset($data['from']);
        $post = Post::create($data);

        /**
         * Before notify the user we have to fetch all the notifications that have the same resource_id
         * and action_type and pluck the users's names and delete all those notifications and add one with the collection of names
         * like following: 
         * grotto_IV, hostname47 and hitman replied to your thread
         * Take a look at User model->fetchNotifs()
         */
        if(!$thread_owner->thread_disabled($thread->id)) {
            if($thread_owner->id != $current_user->id) {
                // If the user is already reply to this thread we have to delete the previous notification
                foreach($thread_owner->notifications as $notification) {
                    if($notification->data['action_type'] == "thread-reply" 
                    && $notification->data['action_user'] == $current_user->id
                    && $notification->data['action_resource_id'] == $thread->id) {
                        $notification->delete();
                    }
                }
                
                $notif_data = [
                    'action_user'=>$current_user->id,
                    'action_statement'=>"replied to your discussion :",
                    'resource_string_slice'=>mb_convert_encoding($thread->slice, 'UTF-8', 'UTF-8'),
                    'action_type'=>'thread-reply',
                    'action_date'=>now(),
                    'action_resource_id'=>$thread->id,
                    'action_resource_link'=>$thread->link.'?reply='.$post->id,
                ];

                // Only notify thread owner if he didn't disable notif on the thread
                $thread_owner->notify(
                    new \App\Notifications\UserAction($notif_data)
                );
            }
        }

        if($from == 'thread-show') {
            // First we create a component class instance
            $component = (new PostComponent($post->id));
            // Then we pass the data to the render method on component class and pass that data to the component view
            $component = $component->render(get_object_vars($component))->render();
            // Then return that view
            return $component;
        } else if($from == 'thread-viewer') {
            $component = (new ViewerReply($post));
            $component = $component->render(get_object_vars($component))->render();
            return $component;
        }
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

        foreach($post->thread->user->notifications as $notification) {
            if($notification->data['action_type'] == "thread-reply" 
            && $notification->data['action_user'] == auth()->user()->id
            && $notification->data['action_resource_id'] == $post->thread->id) {
                $notification->delete();
            }
        }
        // You may be wondering about deleting the related resources: look at the boot method in Post model
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

    public function post_raw_content_fetch(Post $post) {
        $this->authorize('fetch', $post);
        return $post->content;
    }

    public function post_parsed_content_fetch(Post $post) {
        $this->authorize('fetch', $post);
        return Markdown::parse($post->content);
    }

    public function thread_show_post_generate(Post $post) {
        $component = (new PostComponent($post->id));
        $component = $component->render(get_object_vars($component))->render();
        return $component;
    }

    public function thread_viewer_post_generate(Post $post) {
        $component = (new ViewerReply($post));
        $component = $component->render(get_object_vars($component))->render();
        return $component;
    }
}
