<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Http\Controllers\{ThreadController, PostController};
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
        $discussion->delete();
    }
}
