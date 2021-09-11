<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\{ExcludePrivateScope, FollowersOnlyScope, ExcludeDeactivatedUserData, ExcludeAnnouncements};
use App\Models\{User, Post, Category, Forum, Vote, ThreadStatus, ThreadVisibility, Like, Report, Notification, SavedThread};

class Thread extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public $with = ['category.forum','likes','posts', 'visibility', 'status', 'votes', 'user.status'];

    public static function boot() {
        parent::boot();

        /**
         * Before deleting the thread, we need to clear everything related to this thread
         */
        static::deleting(function($thread) {
            if ($thread->isForceDeleting()) {
                // delete related posts with their resources
                foreach($thread->posts as $post) {
                    $post->votes()->delete();
                    $post->likes()->delete();
                    $post->forceDelete();
                }

                // Delete associated votes & likes
                $thread->votes()->delete();
                $thread->likes()->delete();

                // Delete saved threads of people who already saved this thread
                SavedThread::where('thread', $thread->id)->delete();
                
                // Maybe in future, reports related to deleted thread must not be deleted
                // Cause If we find that the same user creates a new account, we will still have these reports and warning to identify him better.
                $thread->reports()->delete();

                // Delete all the notifications for this thread
                foreach(Notification::all() as $notification) {
                    $data = json_decode($notification->data, true);
                    $resource_type = explode('-', $data['action_type'])[0];
                    if($data['action_resource_id'] == $thread->id
                    && $resource_type == 'thread') {
                        $notification->delete();
                    }
                }
            } else {

            }
        });
    }

    protected static function booted() {
        static::addGlobalScope(new ExcludePrivateScope);
        static::addGlobalScope(new FollowersOnlyScope);
        static::addGlobalScope(new ExcludeDeactivatedUserData);
        static::addGlobalScope(new ExcludeAnnouncements);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function users_who_save() {
        return $this->belongsToMany(User::class, 'saved_threads', 'thread', 'user');
    }

    public function status() {
        return $this->belongsTo(ThreadStatus::class);
    }

    public function visibility() {
        return $this->belongsTo(ThreadVisibility::class);
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
            return $this->likes()
                ->where('user_id', $current_user->id)
                ->count();
        }
        return false;
    }

    public function getLikedandlikescountAttribute() {
        $liked = false;
        $count = 0;
        if(!auth()->user()) {
            $liked = false;
        } else {
            foreach($this->likes() as $like) {
                
            }
        }

        return [
            'liked'=>$liked,
            'count'=>$count
        ];
    }

    public function liked_by($user) {
        $d = $this->likes()
            ->where('user_id', $user->id)
            ->where('likable_type', 'App\Models\Thread')
            ->where('likable_id', $this->id)
            ->count();

        return $d;
    }

    public function voted_by($user, $vote) {
        $vote = ($vote == 'up') ? 1 : -1;
        return Vote::where('vote', $vote)
                ->where('user_id', $user->id)
                ->where('votable_id', $this->id)
                ->where('votable_type', 'App\Models\Thread')
                ->count();
    }

    public function voted() {
        if($user=auth()->user()) {
            $vote = $this->votes()->where('user_id', $user->id)->first();
            if(!is_null($vote))
                return $vote->vote;

            return false;
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
        return $this->votes()->sum('vote');
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
        return $this->users_who_save()->where('user_id', auth()->user()->id);
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function scopeTicked($builder) {
        return $builder->whereHas('posts', function(Builder $post) {
            return $post->where('ticked', 1);
        });
    }

    public function isClosed() {
        return $this->status->slug == 'closed';
    }

    public function tickedPost() {
        return $this->posts()->where('ticked', 1)->first();
    }

    public function isticked() {
        return $this->posts()->where('ticked', 1)->count() > 0;
    }

    public function getPostsandlikescountAttribute() {
        return $this->posts->count() + $this->likes->count();
    }

    public function getSliceAttribute() {
        return strlen($this->subject) > 50 ? substr($this->subject, 0, 50) . '..' : $this->subject;
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
        return route('thread.show', ['forum'=>$this->category->forum->slug, 'category'=>$this->category->slug, 'thread'=>$this->id]);
    }

    public function getAnnouncementLinkAttribute() {
        return route('announcement.show', ['forum'=>$this->category->forum->slug, 'announcement'=>$this->id]);
    }
}
