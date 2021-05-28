<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\ThreadClosedException;
use App\Models\{Post, ThreadStatus, Thread};
use App\View\Components\DiscussionPost;


class PostController extends Controller
{
    public function store() {
        $this->authorize('store', Post::class);

        $data = request()->validate([
            'content'=>'required|min:2|max:40000',
            'thread_id'=>'required|exists:threads,id',
        ]);

        $thread_status_slug = ThreadStatus::find(Thread::find($data['thread_id'])->status_id)->slug;

        if($thread_status_slug == 'closed') {
            throw new ThreadClosedException("You can't share posts on a closed thread");
        }

        if($thread_status_slug == 'temp.closed') {
            throw new ThreadClosedException("You can't share posts on a temporarily closed thread");
        }

        $data['user_id'] = auth()->user()->id;
        
        $post = Post::create($data);

        // We return a component based on the created post
        
        // First we create a component class instance 
        $component = (new DiscussionPost($post->id));
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
}
