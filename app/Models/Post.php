<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Markdown;
use Carbon\Carbon;
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

    public function reports() {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public static function top_today_poster() {
        $users_replies = Post::where('created_at', '>', today())->get()->sortBy('created_at')->groupBy('user_id');

        if($users_replies->count()) {
            $top_today_poster;
            $ur = -1;
            foreach($users_replies as $user_replies) {
                if($user_replies->count() > $ur) {
                    $top_today_poster = $user_replies->first()->user;
                    $ur = $user_replies->count();
                }
            }

            return $top_today_poster;
        }

        return false;
    }

    public function liked_by($user) {
        foreach($this->likes as $like) {
            if($like->likable_id == $this->id && $like->likable_type == 'App\Models\Post' && $like->user_id == $user->id) {
                return true;
            }
        }

        return false;
    }

    public function getVotevalueAttribute() {
        $count = 0;
        foreach($this->votes as $vote) {
            $count += $vote->vote;
        }

        return $count;
    }

    public function getIsUpdatedAttribute() {
        return $this->created_at != $this->updated_at;
    }

    public function getSliceAttribute() {
        return substr($this->content, 0, 30);
    }

    public function getLinkAttribute() {
        return $this->thread->link . "#" . $this->id;
    }
    
    public function getParsedContentAttribute() {
        return Markdown::parse($this->content);
    }

    public function getCreationDateHumansAttribute() {
        return (new Carbon($this->created_at))->diffForHumans();
    }

    public function getCreationDateAttribute() {
        return (new Carbon($this->created_at))->toDayDateTimeString();
    }

    public function getUpdateDateHumansAttribute() {
        return (new Carbon($this->updated_at))->diffForHumans();
    }

    public function getUpdateDateAttribute() {
        return (new Carbon($this->updated_at))->toDayDateTimeString();
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
