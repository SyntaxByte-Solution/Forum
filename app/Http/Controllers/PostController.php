<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store() {
        $this->authorize('store', Post::class);

        $data = request()->validate([
            'title'=>'required|min:2|max:1000',
            'content'=>'required|min:2|max:40000',
            'thread_id'=>'required|exists:threads,id',
        ]);

        $data['user_id'] = auth()->user()->id;
        
        Post::create($data);
    }

    public function update(Post $post) {
        $this->authorize('update', $post);

        $data = request()->validate([
            'title'=>'sometimes|min:2|max:1000',
            'content'=>'sometimes|min:2|max:40000',
        ]);
        
        $post->update($data);
    }

    public function destroy(Post $post) {
        $this->authorize('destroy', $post);

        $post->delete();
    }
}
