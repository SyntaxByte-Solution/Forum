<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\{ThreadController, PostController};
use App\Models\Forum;
use App\Models\Thread;
use App\Models\Discussion;

class DiscussionController extends Controller
{
    public function create(Forum $forum) {
        $categories = $forum->categories;

        return view('discussion.create')
        ->with(compact('categories'));
    }

    public function store() {
        $thread = (new ThreadController)->store();
        $post = (new PostController)->store();

        $discussion = Discussion::create([
            'thread_id'=>$thread->id
        ]);

        return $discussion;
    }

    public function destroy($forum, Discussion $discussion) {
        /**
         * $forum: hold the forum slug specified in the url
         */
         // First we get the thread
        $thread = Thread::find($discussion->thread_id);

        // Then we delete all posts associated with this thread
        foreach($thread->posts as $post) {
            (new PostController)->destroy($post);
        }

        // Then we destroy the thread itself
        (new ThreadController)->destroy($thread);

        // Then destroy the discussion
        $discussion->delete();
    }
}
