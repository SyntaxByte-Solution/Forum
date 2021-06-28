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
            $post->votes()->delete();
        });
    }
}
