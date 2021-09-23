<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\{ExcludePrivateScope, FollowersOnlyScope, ExcludeDeactivatedUserData, ExcludeAnnouncements};
use App\Models\{User, Post, Category, Forum, Vote, ThreadStatus, ThreadVisibility, Like, Report, Notification, SavedThread, Poll};

class Thread extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public $with = ['category.forum', 'visibility', 'status', 'user.status'];

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

    public function poll() {
        return $this->hasOne(Poll::class);
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

    public function foo() {
        $thread_likes = 
        \DB::table('likes')
            ->where('likable_id', $this->id)->where('likable_type', 'App\Models\Thread')
            ->where('user_id', auth()->user()->id)
            ->count();
        return $thread_likes;
    }

    public function getLikedandlikescountAttribute() {
        /**
         * Here, in order to get resource number of likes and at the same time check if the current user
         * like this resource or not, we con't achieve that in one query ! INSTEAD what we can do is to fetch
         * resource likes records and pluck the result to get only user_id's;
         * That way we count the number of records to get count, and check if the current user_id exists there
         * in that way we achive that in only one query
         */
        $liked = false;
        $count = 0;
        
        $result = \DB::select('SELECT user_id FROM likes WHERE likable_type=? AND likable_id=?', ['App\Models\Thread', $this->id]);
        $result =  array_column($result, 'user_id');
        if(!auth()->user()) {
            $liked = false;
            $count = count($result);
        } else {
            $count = count($result);
            if($count) // We don't have to check whether a user like a thread if it has no likes
                $liked = in_array(auth()->user()->id, $result);
        }

        return [
            'liked'=>$liked,
            'count'=>$count
        ];
    }

    function getVotedandvotescountAttribute() {
        $votevalue = 0;
        $totalvotevalue = 0;
        
        $result = \DB::select('SELECT vote,user_id FROM votes WHERE votable_type=? AND votable_id=?', ['App\Models\Thread', $this->id]);
        if(!auth()->user()) {
            $voted = false;
            foreach($result as $vote) {
                $totalvotevalue+=$vote->vote;
            }
        } else {
            $count = count($result);
            if($count) { // We don't have to check whether a user like a thread if it has no likes
                foreach($result as $vote) {
                    $totalvotevalue+=$vote->vote;
                    if($vote->user_id == auth()->user()->id)
                        $votevalue = $vote->vote;
                }
            }
        }

        return [
            'votevalue'=>$votevalue,
            'totalvotevalue'=>$totalvotevalue,
        ];
    }

    public function liked_by($user) {
            return $this::likes()
                    ->where('user_id', $user->id)
                    ->count() > 0;
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
        return $this->posts()->count() + $this->likes()->count();
    }

    public function getSliceAttribute() {
        return strlen($this->subject) > 50 ? substr($this->subject, 0, 50) . '..' : $this->subject;
    }

    public function getMediumsliceAttribute() {
        return strlen($this->subject) > 110 ? substr($this->subject, 0, 110) . '..' : $this->subject;
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
