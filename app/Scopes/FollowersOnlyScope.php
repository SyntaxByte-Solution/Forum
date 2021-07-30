<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use App\Models\ThreadStatus;

class FollowersOnlyScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        /**
         * 1. Exclude followers-only thyread for guest users
         * 2. For authenticated users, we have 2 conditions :
         *      2.1. Either exclude the followers-only threads from thread list if the user is a guest
         *      2.2. Or if the user is authenticated we get everything except followers-only threads, or we get
         *           followers-only thread if the thread owner is the same as authenticated user, OR if the current user
         *           is one of the thread owner followers.
         *           (we check the last condition by getting the current user followed users and search if the thread owner
         *            is there with the followed users; If so we show the thread otherwise the current user is not a follower
         *            for the thread owner so we don't have to show it.
         *            )
         */
        if(!Auth::check()) {
            $builder->where('visibility_id', '<>', 2);
        } else {
            $builder->where(function($query) {
                $query->where('visibility_id', '<>', 2);
            })->orWhere(function($query) {
                $query->where('visibility_id', 2)
                ->where(function($query) {
                    $query->where('user_id', auth()->user()->id)
                    ->orWhereIn('user_id', auth()->user()->followed_users->pluck('followable_id'));
                });
            });;
        }
    }
}