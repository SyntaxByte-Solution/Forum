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
        $thread_vote_count = $thread->votes->count();
        $result = $this->handle_vote($request, $thread, 'App\Models\Thread');

        // If the subtraction of the below operation is greater than 0 means he get rid of his vote
        // meaning we don't have to notify the user of that action 
        if($thread_vote_count - $thread->votes->count() <= 0 && !$thread->user->thread_disabled($thread->id)) {
            $thread->user->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>auth()->user()->id,
                    'action_statement'=>__("voted your thread") . " :",
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
        if($post_vote_count - $post->votes->count() <= 0 && !$post->user->post_disabled($post->id)) {
            $post->user->notify(
                new \App\Notifications\UserAction([
                    'action_user'=>auth()->user()->id,
                    'action_statement'=>"voted your reply: '",
                    'resource_string_slice'=>$post->slice . "' on:" . $thread->slice,
                    'action_type'=>'reply-vote',
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

        $type_name = strtolower(substr($type, strrpos($type, '\\') + 1)); // App\Models\Thread => thread
        $this->authorize('store', [\App\Models\Vote::class, $data['vote'], $resource, $type_name]);

        /**
         * we have to check if the user already vote the resources
         */
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
            $resource->votes()->save($vote); // If the user never vote the resource we simply add the vote record
        }
        
        $resource->load('votes');
        $vote_count = 0;
        foreach($resource->votes as $vote) {
            $vote_count += $vote->vote;
        }
        return $vote_count;
    }
}
