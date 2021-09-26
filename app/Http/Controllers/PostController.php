<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exceptions\ThreadClosedException;
use App\Models\{Post, ThreadStatus, Thread};
use App\View\Components\PostComponent;
use App\View\Components\Thread\ViewerReply;
use App\Scopes\ExcludeAnnouncements;
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

        $currentuser = auth()->user();
        $thread = Thread::withoutGlobalScope(ExcludeAnnouncements::class)->find($data['thread_id']);
        $thread_owner = $thread->user;

        $data['user_id'] = auth()->user()->id;
        $from = $request->from;
        unset($data['from']);
        $post = Post::create($data);
        $threadtype = ($thread->type == 'poll') ? 'poll' : 'discussion';

        if(!$thread_owner->thread_disabled($thread->id)) { // Only notify thread owner if he doesn't disable notifs for this thread
            if($thread_owner->id != $currentuser->id) {
                // If the user is already reply to this thread we have to delete the previous notification
                \DB::statement(
                    "DELETE FROM `notifications` 
                    WHERE JSON_EXTRACT(data, '$.action_type')='thread-reply'
                    AND JSON_EXTRACT(data, '$.action_user') = " . $currentuser->id .
                    " AND JSON_EXTRACT(data, '$.resource_type')='post' 
                    AND JSON_EXTRACT(data, '$.action_resource_id')=" . $thread->id
                );
                
                $notif_data = [
                    'action_user'=>$currentuser->id,
                    'action_statement'=>"replied to your $threadtype :",
                    'resource_string_slice'=>mb_convert_encoding($thread->slice, 'UTF-8', 'UTF-8'),
                    'resource_type'=>'post',
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
            $component = (new PostComponent($post));
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

        \DB::statement(
            "DELETE FROM `notifications` 
            WHERE JSON_EXTRACT(data, '$.action_type')='thread-reply'
            AND JSON_EXTRACT(data, '$.action_user') = " . $post->user->id .
            " AND JSON_EXTRACT(data, '$.resource_type')='post' 
            AND JSON_EXTRACT(data, '$.action_resource_id')=" . $post->thread->id
        );
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

            $notif_data = [
                'action_user'=>auth()->user()->id,
                'action_statement'=>"marks your reply as best reply :",
                'resource_string_slice'=>mb_convert_encoding($post->slice, 'UTF-8', 'UTF-8'),
                'resource_type'=>'post',
                'action_type'=>'post-tick',
                'action_date'=>now(),
                'action_resource_id'=>$post->id,
                'action_resource_link'=>$post->thread->link.'?reply='.$post->id,
            ];
    
            // Only notify thread owner if he didn't disable notif on the thread
            $post->user->notify(
                new \App\Notifications\UserAction($notif_data)
            );
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
        $component = (new PostComponent($post));
        $component = $component->render(get_object_vars($component))->render();
        return $component;
    }

    public function thread_viewer_post_generate(Post $post) {
        $component = (new ViewerReply($post));
        $component = $component->render(get_object_vars($component))->render();
        return $component;
    }
}
