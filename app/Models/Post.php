<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Markdown;
use Carbon\Carbon;
use App\Models\{Thread, Vote, Like, User};
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ExcludeDeactivatedUserData;

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
        $topposter = \DB::table('posts')
        ->where('created_at', '>', today())
        ->select(\DB::raw('count(*) as posts, user_id'))
        ->groupBy('user_id')
        ->orderBy('posts', 'desc')
        ->first();

        if(!is_null($topposter)) {
            return User::find($topposter->user_id);
        }

        return false;
    }

    public function liked_by($user) {
        return $this::likes()
                ->where('user_id', $user->id)
                ->count() > 0;
    }

    public function voted() {
        if($user=auth()->user()) {
            $vote = $this->votes()
                ->where('user_id', $user->id)
                ->first();
            
            if(!is_null($vote))
                return $vote->vote;
                
            return false;
        }
        return false;
    }

    public function getVotevalueAttribute() {
        return $this->votes()->sum('vote');
    }

    public function getIsUpdatedAttribute() {
        return $this->created_at != $this->updated_at;
    }

    public function getAlreadyReportedAttribute() {
        if(auth()->user()) {
            return $this->reports()
                ->where('user_id', auth()->user()->id)
                ->count() > 0;
        }

        return 0;
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

    protected static function booted() {
        static::addGlobalScope(new ExcludeDeactivatedUserData);
    }
}
