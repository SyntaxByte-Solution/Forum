<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{User, Post, Category, Forum, Vote, ThreadStatus, Like};

class Thread extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static function boot() {
        parent::boot();

        /**
         * Before deleting the thread, we need to clear all posts related to this thread
         * as well as deleting the related votes to this thread and its posts
         */
        static::deleting(function($thread) {
            // Delete registry_detail
            if ($thread->isForceDeleting()) {
                foreach($thread->posts as $post) {
                    $post->votes()->delete();
                }
                $thread->votes()->delete();
                $thread->posts()->forceDelete();
            } else {
                $thread->posts()->delete();
            }
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function status() {
        return $this->belongsTo(ThreadStatus::class);
    }

    public function votes() {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function likes() {
        return $this->morphMany(Like::class, 'likable');
    }

    public function getLikedAttribute() {
        if($current_user = auth()->user()) {
            return Like::where('user_id', $current_user->id)
                ->where('likable_type', 'App\Models\Thread')
                ->where('likable_id', $this->id)
                ->count();
        }
        return false;
    }

    public function getUpvotesAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            if($vote->vote == '-1')
            $count -= 1;
        }

        return $count;
    }

    public function getDownvotesAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            if($vote->vote == '1')
            $count += 1;
        }

        return $count;
    }

    public function getVotevalueAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            $count += $vote->vote;
        }

        return $count;
    }

    public function scopeToday($builder)
    {
        return $builder->where('created_at', '>', today());
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function isClosed() {
        return $this->status->slug == 'closed';
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function tickedPost() {
        foreach($this->posts as $post) {
            if($post->ticked) {
                return $post;
            }
        }

        return false;
    }

    public function forum() {
        return Forum::find($this->category->forum_id);
    }
}
