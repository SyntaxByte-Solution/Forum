<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\{Thread, Post, Vote, UserAction};

class VoteController extends Controller
{
    /**
     * Here we need to check first if the user is already vote on this thread, then we decide if we add this vote or take it off
     * we have 3 cases here:
     *  1- the user is upvoted this thread, then press upvote button again; in this case we're gonna delete the vote
     *  2- the user is not voted at all, in this case we simply add it
     *  3- the user is upvoted  the thread, and then he decide to downvote it; in this case we need to delete the up
     *     vote and then add the down vote
     */
    public function thread_vote(Request $request, Thread $thread) {
        $voteaction = $this->handle_vote($request, $thread, 'App\Models\Thread');

        if($voteaction != 'deleted' && !$thread->user->thread_disabled($thread->id)) {
            $thread->user->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>auth()->user()->id,
                    'action_statement'=>"voted your discussion :",
                    'resource_string_slice'=>$thread->slice,
                    'resource_type'=>'thread',
                    'action_type'=>'resource-vote',
                    'action_date'=>now(),
                    'action_resource_id'=>$thread->id,
                    'action_resource_link'=>$thread->link,
                ])
            );
        }
    }

    public function post_vote(Request $request, Post $post) {
        $voteaction = $this->handle_vote($request, $post, 'App\Models\Post');
        
        $thread = $post->thread;
        if($voteaction != 'deleted' && !$post->user->post_disabled($post->id)) {
            $post->user->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>auth()->user()->id,
                    'action_statement'=>"voted your reply :",
                    'resource_string_slice'=>$post->slice . "' on:" . $thread->slice,
                    'resource_type'=>'thread',
                    'action_type'=>'resource-vote',
                    'action_date'=>now(),
                    'action_resource_id'=>$post->id,
                    'action_resource_link'=>$thread->link.'?reply='.$post->id,
                ])
            );
        }
    }

    /**
     * handle_vote function will handle vote by either inserting the vote, flipping it (remove up and add down) or delete it
     * completely, and then return the type of handling (either added, deleted, flipped)
     * we use that return to decide whether we notify the resource owner or not
     */
    private function handle_vote($request, $resource, $type) {
        $current_user = auth()->user();
        $data = $request->validate([
            'vote'=> [
                'required',
                Rule::in([-1, 1]),
            ]
        ]);

        $voteaction;
        $type_name = strtolower(substr($type, strrpos($type, '\\') + 1)); // App\Models\Thread => thread
        $this->authorize('store', [\App\Models\Vote::class, $data['vote'], $resource, $type_name]);

        /**
         * we have to check if the user already vote the resources
         */
        $exists_result = \DB::select("SELECT * FROM votes WHERE user_id=$current_user->id AND votable_id=? AND votable_type=?", [$resource->id, 'App\Models\Thread']);
        $exists = (bool)count($exists_result);
        $founded_vote;
        if($exists) {
            $founded_vote = Vote::find($exists_result[0]->id);
        }

        $vote = new Vote;
        $vote->vote = $data['vote'];
        $vote->user_id = $current_user->id;

        /**
         * If the user already vote the resource we do the following:
         *  1. store vote value in variable before delete the founded vote
         *  2. then we delete the notification of the former vote of the resource owner
         *  3. now we have to check in case the vote found, if resource is already upvoted and the user upvote again or already downvoted and the use..
         *     in that case we don't do anything but delete the vote and notification;
         *     Otherwise, if the user already upvote resource and then later downvote it, we save it again to db
         *     Notice: notifying resource owner is done in the caller method
         */
        if($exists) {
            $vote_value = $founded_vote->vote;
            $founded_vote->delete();

            \DB::statement(
                "DELETE FROM `notifications` 
                WHERE JSON_EXTRACT(data, '$.action_type')='resource-vote'
                AND JSON_EXTRACT(data, '$.action_user') = " . $current_user->id .
                " AND JSON_EXTRACT(data, '$.resource_type')='" . $type_name .
                "' AND JSON_EXTRACT(data, '$.action_resource_id')=" . $resource->id
            );

            $voteaction="deleted";
            if(($vote_value == -1 && $data['vote'] == 1) || ($vote_value == 1 && $data['vote'] == -1)) {
                $resource->votes()->save($vote);
                $voteaction="flipped";
            }
        } else {
            $resource->votes()->save($vote); // If the user never vote the resource we simply add the vote record
            $voteaction="added";
        }
        
        return $voteaction;
    }
}
