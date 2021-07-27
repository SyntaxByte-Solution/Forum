<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\ExcludePrivateScope;
use App\Models\{User, Post, Category, Forum, Vote, ThreadStatus, Like, Report, Notification};

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
                    $post->likes()->delete();
                }
                $thread->votes()->delete();
                $thread->posts()->forceDelete();

                foreach(Notification::all() as $notification) {
                    $data = json_decode($notification->data, true);
                    $resource_type = explode('-', $data['action_type'])[0];
                    if($data['action_resource_id'] == $thread->id
                    && $resource_type == 'thread') {
                        $notification->delete();
                    }
                }
            } else {
                // Here there's no need to soft delete posts as the thread is sift deleted
                // $thread->posts()->delete();
            }
        });
    }

    protected static function booted() {
        static::addGlobalScope(new ExcludePrivateScope);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function users_who_save() {
        return $this->belongsToMany(User::class, 'saved_threads', 'thread', 'user');
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

    public function disables() {
        return $this->morphMany(NotificationDisable::class, 'disabled');
    }

    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function getAlreadyReportedAttribute() {
        if(auth()->user()) {
            return $this->reports->where('user_id', auth()->user()->id)
                ->where('reportable_id', $this->id)
                ->where('reportable_type', 'App\Models\Thread')
                ->count();
        }

        return false;
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

    public function getVoteCountAttribute() {
        return $this->votes->count();
    }

    public function getUpvoteCountAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            if($vote->vote == '1')
            $count += 1;
        }

        return $count;
    }

    public function getDownvoteCountAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            if($vote->vote == '-1')
            $count += 1;
        }

        return $count;
    }

    public function getIsSavedAttribute() {
        return $this->users_who_save->contains(auth()->user()->id);
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function scopeTicked($builder) {
        return $builder->whereHas('posts', function(Builder $post) {
            return $post->where('ticked', 1);
        });
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

    public function getSliceAttribute() {
        return strlen($this->subject) > 40 ? substr($this->subject, 0, 40) . '..' : $this->subject;
    }

    public function getMediumsliceAttribute() {
        return strlen($this->subject) > 120 ? substr($this->subject, 0, 120) . '..' : $this->subject;
    }

    public function getContentsliceAttribute() {
        return strlen($this->content) > 80 ? substr($this->content, 0, 80) . '..' : $this->content;
    }

    public function getMediumcontentsliceAttribute() {
        return strlen($this->content) > 400 ? substr($this->content, 0, 400) . '..' : $this->content;
    }

    public function getLinkAttribute() {
        return route('thread.show', ['forum'=>$this->forum()->slug, 'category'=>$this->category->slug, 'thread'=>$this->id]);
    }
}
