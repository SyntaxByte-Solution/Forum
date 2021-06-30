<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Thread, Post, Vote, UserAction};

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
        $thread_vote_count = $thread->votes->count();

        $result = $this->handle_vote($request, $thread, 'App\Models\Thread');

        // If the subtraction of the below operation is greater than 0 means he get rid of his vote
        // meaning we don't have to notify the user of that action 
        if($thread_vote_count - $thread->votes->count() <= 0) {
            $thread->user->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>auth()->user()->id,
                    'action_statement'=>"voted your thread:",
                    'resource_string_slice'=>$thread->slice,
                    'action_type'=>'thread-vote',
                    'action_date'=>now(),
                    'action_resource_id'=>$thread->id,
                    'action_resource_link'=>$thread->link,
                ])
            );
        }

        return $result;
    }

    public function post_vote(Request $request, Post $post) {
        $post_vote_count = $post->votes->count();
        $result = $this->handle_vote($request, $post, 'App\Models\Post');
        $thread = $post->thread;
        if($post_vote_count - $post->votes->count() <= 0) {
            $post->user->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>auth()->user()->id,
                    'action_statement'=>"voted your reply: '",
                    'resource_string_slice'=>$post->slice . "' on:" . $thread->slice,
                    'action_type'=>'post-vote',
                    'action_date'=>now(),
                    'action_resource_id'=>$post->id,
                    'action_resource_link'=>$thread->link,
                ])
            );
        }

        return $result;
    }

    private function handle_vote($request, $resource, $type) {
        $current_user = auth()->user();
        $data = $request->validate([
            'vote'=> [
                'required',
                Rule::in([-1, 1]),
            ]
        ]);
        $type_name = strtolower(substr($type, strrpos($type, '\\') + 1));

        $this->authorize('store', [\App\Models\Vote::class, $data['vote'], $resource, $type_name]);

        $exists = false;
        $founded_vote;
        foreach($current_user->votes() as $vote) {
            if($vote->votable_id == $resource->id && $vote->votable_type == $type) {
                $exists = true;
                $founded_vote = $vote;
                break;
            }
        }

        $vote = new Vote;
        $vote->vote = $data['vote'];
        $vote->user_id = $current_user->id;

        if($exists) {
            $vote_value = $founded_vote->vote;
            $founded_vote->delete();
            foreach($resource->user->notifications as $notification) {
                if($notification->data['action_type'] == $type_name."-vote" 
                && $notification->data['action_user'] == $current_user->id
                && $notification->data['action_resource_id'] == $resource->id) {
                    $notification->delete();
                }
            }

            if(($vote_value == -1 && $data['vote'] == 1) || ($vote_value == 1 && $data['vote'] == -1)) {
                $resource->votes()->save($vote);
            }
        } else {
            $resource->votes()->save($vote);
        }
        
        $resource->load('votes');
        $vote_count = 0;
        foreach($resource->votes as $vote) {
            $vote_count += $vote->vote;
        }
        return $vote_count;
    }
}
