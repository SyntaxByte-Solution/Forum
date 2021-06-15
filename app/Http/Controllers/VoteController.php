<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Thread, Post, Vote};

class VoteController extends Controller
{
    /**
     * Here we need to check first if the user is already vote on this thread, then we decide if we add this vote or not
     * we have 3 cases here:
     *  1- the user is upvoted this thread, then press upvote button again; in this case we're gonna delete the vote
     *  2- the user is not voted at all, in this case we simply add it
     *  3- the user is upvoted  the thread, and then he decide to downvote it; in this case we need to delete the up
     *     vote and then add the down vote
     */
    public function thread_vote(Request $request, Thread $thread) {
        return $this->handle_vote($request, $thread, 'App\Models\Thread');
    }

    public function post_vote(Request $request, Post $post) {
        return $this->handle_vote($request, $post, 'App\Models\Post');
    }

    private function handle_vote($request, $resource, $type) {
        $current_user = auth()->user();
        $data = $request->validate([
            'vote'=> [
                'required',
                Rule::in([-1, 1]),
            ]
        ]);

        $exists = false;
        $founded_vote;
        foreach($current_user->votes() as $vote) {
            if($vote->votable_id == $resource->id && $vote->votable_type == $type) {
                $exists = true;
                $founded_vote = $vote;
            }
        }

        $vote = new Vote;
        $vote->vote = $data['vote'];
        $vote->user_id = $current_user->id;

        if($exists) {
            $vote_value = $founded_vote->vote;
            if($vote_value == -1) {
                $founded_vote->delete();
                if($data['vote'] == 1) {
                    $resource->votes()->save($vote);
                    return -1;
                }
                return 0;
            } else {
                $founded_vote->delete();
                if($data['vote'] == -1) {
                    $resource->votes()->save($vote);
                    return -1;
                }
                return 0;
            }
        } else {
            $resource->votes()->save($vote);
            return 1;
        }

        /**
         * for return value:
         *      -1: downvote
         *      0 : unvoted (due to viting with the same prvious vote value)
         *      1 : upvote
         */
    }
}
