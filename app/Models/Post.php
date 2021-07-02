<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Thread, Vote, Like};
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function thread() {
        return $this->belongsTo(Thread::class);
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

    public function liked_by($user) {
        foreach($this->likes as $like) {
            if($like->likable_id == $this->id && $like->likable_type == 'App\Models\Post' && $like->user_id == $user->id) {
                return true;
            }
        }

        return false;
    }

    public function getSliceAttribute() {
        return substr($this->content, 0, 30);
    }

    public function getLinkAttribute() {
        return $this->thread->link . "#" . $this->id;
    }
    
    public static function boot() {
        parent::boot();

        static::deleting(function($post) {
            // delete related votes records
            $post->likes()->delete();
            $post->votes()->delete();
        });
    }
}
