<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as UserAuthenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Role, Permission, UserStatus, UserReach, ProfileView, 
    Thread, Post, SavedThread, UserPersonalInfos, AccountStatus, 
    Vote, Like, NotificationDisable, Follow, FAQ};
use App\Permissions\HasPermissionsTrait;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\ExcludeDeactivatedUser;

class User extends UserAuthenticatable implements Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait, SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $guarded = [];
    private $avatar_dims = [26, 36, 100, 160, 200, 300, 400];
    protected $raw_avatar;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        //"data" => "array"
    ];

    protected static function booted() {
        // Infinite call fore applying global scope to user model
        // static::addGlobalScope(new ExcludeDeactivatedUser);
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function(User $user) {
            /**
             * Before deleting a user we have to delete everything related to that user
             * first we need to delete: 
             * 1. likes on threads => [for posts related to threads -> READ NOTICE ABOVE THREADS DELETION LOOP BELOW]
             * 2. votes on threads => [for posts related to threads -> READ NOTICE ABOVE THREADS DELETION LOOP BELOW]
             * 3. saved threads (also saved threads of other users who saved the deleted user's threads)
             * 4. followers
             * 5. followings
             * 6. avatars and cover
             * 7. all user reach records in user_reach table
             * 8. all notifications
             * 9. profile views
             * . delete threads
             */
            
            // 1. user votes (on posts and threads)
            Vote::where('user_id', $user->id)->delete();
            // 2. user likes (on posts and threads)
            Like::where('user_id', $user->id)->delete();
            // 3. user posts (on own threads and other's users threads)
            Post::withTrashed()->where('user_id', $user->id)->forceDelete();
            // 3. delete saved threads
                // 3.1 delete user's saved threads
            $user->savedthreads()->delete();
                // 3.2 delete all saved threads of other users related to user's threads because we're going to delete all threads at the end
            \App\Models\SavedThread::whereIn('thread', $user->threads->pluck('id'))->delete(); 
            // 4. delete all followers records
            $user->followers()->delete();
            // 5. delete followed users
            foreach($user->followed_users as $followed) {
                $followed->delete();
            }
            // 6. delete all medias directory content
            $media_dir = 'users/' . $user->id . '/usermedia';
            (new \Illuminate\Filesystem\Filesystem)->cleanDirectory($media_dir);
            $user->update(['avatar'=>null, 'cover'=>null]);

            // 7. reach records
            $user->reach()->delete();
            // 8. notifications
            // Normally we have to delete followers notification that are relevant to the deleted user's own resources but we're gonna left it as it is just for now
            $user->notifications()->delete(); 
            // 9. profile views
            ProfileView::where('visited_id', $user->id)->delete();

            /**
             * This should be among the last deletions because lot of other tables rely on threads ids
             * NOTICE: In Thread model, when we delete a thread, deleting in boot method will trigger all posts/votes/likes
             * handling actions for delete. -check out Thread boot-deleting method
             */
            foreach (Thread::withTrashed()->where('user_id', $user->id)->get() as $thread) {
                $thread->forceDelete();
            }
            // After deleting all threads we have to delete threads directory in order to delete all medias of his threads
            $threads_media_dir = 'users/' . $user->id . '/threads';
            (new \Illuminate\Filesystem\Filesystem)->cleanDirectory($threads_media_dir);
        });
    }

    // Even though using local scopes needs a lot of code update like prefixing user fetch queries but
    // it gives me what I need and it doesn't cause infinite (nested) calls to the scope like in global scopes
    public function scopeExcludedeactivatedaccount($query) {
        return $query->where('account_status', '<>', 2);
    }

    public function getAvatarAttribute($value) {
        $this->raw_avatar = $value;

        if(is_null($value)) {
            if(!is_null($this->provider_avatar)) {
                return $this->provider_avatar;
            }
        }

        return $value;
    }

    public function getHasavatarAttribute() {
        $avatar = DB::select('SELECT avatar, provider_avatar FROM users WHERE id=' . $this->id)[0];

        return $avatar->avatar != null || $avatar->provider_avatar != null;
    }

    public function sizedavatar($size, $quality="-h") {
        if(!is_null($this->avatar)) {
            if($this->avatar == $this->provider_avatar) {
                return $this->avatar;
            }
            return asset('/users/' . $this->id . '/usermedia/avatars/' . $size . $quality . '.png');
        } else {
            if($this->provider_avatar) {
                return $this->provider_avatar;
            } else {
                return asset("users/defaults/medias/avatars/$size-l.png");
            }
        }
    }

    public static function sizeddefaultavatar($size, $quality="-h") {
        return asset("users/defaults/medias/avatars/" . $size . $quality . ".png");
    }

    public function reach() {
        return $this->hasMany(UserReach::class, 'reachable');
    }

    public function status() {
        return $this->belongsTo(AccountStatus::class, 'status_id');
    }

    public function getReachcountAttribute() {
        return UserReach::where('reachable', $this->id)->count();
    }

    public function getCoverAttribute($value) {
        if($value) {
            return asset($value);
        }

        return $value;
    }

    public function getProfileViewsAttribute() {
        return ProfileView::where('visited_id', $this->id)->count();
    }

    // Relationships
    public function personal() {
        return $this->hasOne(UserPersonalInfos::class, 'user');
    }

    public function threads() {
        return $this->hasMany(Thread::class);
    }

    public function threadsvotes() {
        return $this->hasManyDeep(
            'App\Models\User',
            ['votes', 'App\Models\Thread'],
            [null, 'id', 'id'],
            [null, ['votable_type', 'votable_id'], 'user_id']
        );
    }

    public function threadslikes() {
        // Here we can't use hasManyThrough (many likes through thread) because the relation between likes and thread is morph
        return $this->hasManyDeep(
            'App\Models\User',
            ['likes', 'App\Models\Thread'],
            [null, 'id', 'id'],
            [null, ['likable_type', 'likable_id'], 'user_id']
        );
    }

    public function posts() {
        return $this->hasManyThrough(Post::class, Thread::class);
    }

    public function savedthreads() {
        return $this->belongsToMany(Thread::class, 'saved_threads', 'user', 'thread')->withTimestamps()->withPivot('created_at')->orderBy('saved_threads.created_at', 'desc');
    }

    public function disables() {
        return $this->hasMany(NotificationDisable::class);
    }

    public function followers() {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function follows() {
        return $this->hasMany(Follow::class, 'follower');
    }

    public function faqs() {
        return $this->hasMany(FAQ::class);
    }

    public function isthatthreadsaved($thread) {
        return \DB::select(
            "SELECT COUNT(*) as saved
            FROM saved_threads
            WHERE user=$this->id AND thread=$thread->id")[0]->saved > 0;
    }

    public function getFollowedUsersAttribute() {
        return 
            Follow::where('follower', $this->id)
            ->where('followable_type', 'App\Models\User')
            ->get();
    }

    public function liked_threads($skip=10, $pagesize=10) {
        /**
         * To fetch liked threads in form of chunks we have to do the following (due to performence purposes)
         * 1. Use threadslikes relationship to fetch likes on threads only.
         * 2. 
         */
        $likedthreads = $this
            ->threadslikes()
            ->without(['votes', 'posts', 'likes'])
            ->orderBy('likes.created_at', 'desc')
            ->pluck('likable_id')
            ->skip($skip)
            ->take($pagesize);
        
        return Thread::without(['votes', 'posts', 'likes'])->findMany($likedthreads);
    }

    public function voted_threads($skip=10, $pagesize=10) {
        $votedthreads = $this
            ->threadsvotes()
            ->without(['posts', 'likes'])
            ->orderBy('votes.created_at', 'desc')
            ->pluck('votable_id')
            ->skip($skip)
            ->take($pagesize);
        
        return Thread::without(['votes', 'posts', 'likes'])->findMany($votedthreads);
    }

    public function likes_on_threads() {
        return Like::where('user_id', $this->id)->where('likable_type', 'App\Models\Thread')->get();
    }

    public function likes_on_posts() {
        return Like::where('user_id', $this->id)->where('likable_type', 'App\Models\Post')->get();
    }
    
    public function votes_on_threads() {
        return Vote::where('user_id', $this->id)->where('votable_type', 'App\Models\Thread')->count();
    }

    public function votes_on_posts() {
        return Vote::where('user_id', $this->id)->where('votable_type', 'App\Models\Post')->count();
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function votes_count() {
        return $this->votes()->count();
    }

    public function post_disabled($post_id) {
        return $this->disables
            ->where('disabled_type', 'App\Models\Post')
            ->where('disabled_id', $post_id)
            ->count();
    }

    public function thread_disabled($post_id) {
        return $this->disables
            ->where('disabled_type', 'App\Models\Thread')
            ->where('disabled_id', $post_id)
            ->count();
    }

    public function isBanned() {
        return $this->status->slug == 'banned';
    }

    public function isAdmin() {
        return $this->has_role('admin');
    }

    public function scopeToday($builder){
        return $builder->where('created_at', '>', today());
    }

    public function today_posts_count() {
        $count = 0;
        foreach($this->threads as $thread) {
            $count += $thread->posts()->whereDate('created_at', Carbon::today())->count();
        }

        return $count;
    }

    public function posts_count() {
        $count = 0;
        foreach($this->threads as $thread) {
            $count += $thread->posts->count();
        }

        return $count;
    }

    public function getNotifsAttribute() {
        // First let's group by action_resource_id
        $groups_by_resource_id = $this->notifications->pluck('data')
        ->groupBy('action_type');
        
        // This will be result
        $notifications = collect();

        foreach($groups_by_resource_id as $group_by_resource_id) {
            foreach($group_by_resource_id->groupBy('action_resource_id') as $group) {
                
                $group = $group->filter(function($g) {
                    return !is_null(User::find($g['action_user'])); 
                });

                $action_takers_count = $group->count();
                if($action_takers_count) {
                    $action_takers = '';
                    switch($action_takers_count) {
                        case 0:
                            break;
                        case 1:
                            $action_takers = User::find($group->first()['action_user'])->minified_name;
                            break;
                        case 2:
                            $action_takers = User::find($group->first()['action_user'])->minified_name;
                            $action_takers .= __(' and ') . User::find($group[1]['action_user'])->minified_name;
                            break;
                        default:
                            $c = 0;
                            $i = 0;
                            foreach($group as $notification_data_record) {
                                if($c == 0) {
                                    $action_takers = User::find($notification_data_record['action_user'])->minified_name;
                                } else if($c == 1) {
                                    $action_takers .= ', ' . User::find($notification_data_record['action_user'])->minified_name;
                                } else {
                                    $i++;
                                }
                                $c++;
                            }
                            $action_takers .= __(' and ') . $i . (($i>1) ? __(' others ') : __(' other '));
                    }
                    $cloned_notification_data = $this->notifications->where('data', $group->first())->first();
                    $resource_action_icon = '';
                    if($cloned_notification_data->data['action_type'] == 'thread-reply') {
                        $resource_action_icon = 'resource24-reply-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'thread-vote' || $cloned_notification_data->data['action_type'] == 'reply-vote') {
                        $resource_action_icon = 'resource24-vote-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'reply-like' || $cloned_notification_data->data['action_type'] == 'discussion-like') {
                        $resource_action_icon = 'resource24-like-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'warning-warning') {
                        $resource_action_icon = 'warning24-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'user-follow') {
                        $resource_action_icon = 'followfilled24-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'avatar-change') {
                        $resource_action_icon = 'image24-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'poll-action') {
                        $resource_action_icon = 'poll24-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'poll-vote') {
                        $resource_action_icon = 'pollvote24-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'poll-option-add') {
                        $resource_action_icon = 'polloptionadd24-icon';
                    } else {
                        $resource_action_icon = 'notification24-icon';
                    }
    
                    $resource_type = explode('-', $cloned_notification_data->data['action_type'])[0];
                    if($resource_type == 'thread') {
                        $resource_type = "App\Models\Thread";
                    } else if($resource_type == 'reply') {
                        $resource_type = "App\Models\Post";
                    }
    
                    $resource_id = $cloned_notification_data->data['action_resource_id'];
                    $disabled = (bool)
                        $this->disables
                        ->where('disabled_type', $resource_type)
                        ->where('disabled_id', $resource_id)
                        ->count();
    
                    $notifications->push([
                        'notif_id'=>$cloned_notification_data->id,
                        'action_takers'=>$action_takers,
                        'action_statement'=> __($cloned_notification_data->data['action_statement']),
                        'resource_string_slice'=>$cloned_notification_data->data['resource_string_slice'],
                        'action_date'=>(new Carbon($cloned_notification_data->created_at))->diffForHumans(),
                        'action_real_date'=>$cloned_notification_data->created_at,
                        'action_type'=>$cloned_notification_data->data['action_type'],
                        'action_resource_link'=>$cloned_notification_data->data['action_resource_link'],
                        'action_user' => User::find($cloned_notification_data->data['action_user']),
                        'resource_id' => $cloned_notification_data->data['action_resource_id'],
                        'resource_action_icon' => $resource_action_icon,
                        'notif_read' => $cloned_notification_data->read(),
                        'disabled'=>$disabled
                    ]);
                }
            }
        }

        return $notifications->sortByDesc('action_real_date');
    }

    /**
     * fetching notification is more complicated than expected.
     * The function above fo the job but it ruin the performance :( It actually fetch all user notifications to the memory
     * and increase number of queries drastically ! simply the above function is not efficient
     * For that reason, the following function is a reimplementation of notifications fetch that try to get notifications 
     * by taking performance into account
     * 
     * The first query is the most important query in notifications fetching; It sort user notifications by
     * data->action_resource_id AND data->action_type to get notifications of same resource and same action
     * Actually wa have to take all notification columns because we need created_at and updated_at when showing notifs
     */
    public function unique_notifications($skip=0, $take=6) {
        $notifications = DB::select("SELECT * FROM `notifications` 
        WHERE notifiable_id = $this->id
        ORDER BY created_at DESC,
                 JSON_EXTRACT(data, '$.action_resource_id'),
                 JSON_EXTRACT(data, '$.action_type')");

        $result = collect([]);
        $uniques = [];
        $similars = [];
        $count = -1;
        $hasmore = false;
        /**
         * Loop through notification and get $take number of unique notifications (unique by action_resource_id and action_type)
         * after that, look for their groups of similar action_resource_id and action type of each of them to extract the 
         * action_takers name (X, Y and Z likes your ..)
         */
        foreach($notifications as $notification) {
            /* 
             * Now as we are looping through the user notifications we check first if current notification
             * exists in  the result or not; If it's not, we simple push it to the uniques; otherwise if the notification exists
             * in the uniques we push it to similars in order to use it to fetch action takers names and counts
             */
            $data = json_decode($notification->data);

            $already_exists = false;
            $i=0;
            foreach($uniques as $unique) {
                $d = json_decode($unique->data);
                if($d->action_resource_id == $data->action_resource_id && $d->action_type == $data->action_type) {
                    $already_exists = true;
                    $similars[$i][] = $notification;
                }
                $i++;
            }

            /**
             * We want unique notifications and only $take(=6) number of them
             * Notice that before pushing notification to unique we have to skip the already taken notifications
             */
            if(++$count >= $skip)
                if(!$already_exists) {
                    if(count($uniques) < $take) $uniques[] = $notification;
                    else $hasmore = true; 
                    // Has more will be true only if the unique notifications are pushed to uniques and then after 
                    // that we find other uniques which means more notifications still there.
                }
        }


        if($count == -1) // count == -1 means user has no notifications => return empty collection
            return [
                'notifs'=>$result,
                'hasmore'=>false
            ];

        for($i=0;$i<count($uniques);$i++) {
            $data = json_decode($uniques[$i]->data);
            $notification = $uniques[$i]; // NOTICE THAT $notification hold only data field as stdObject

            $action_takers = User::find($data->action_user)->minified_name;
            if(isset($similars[$i])) {
                $c = count($similars[$i]);
                if($c == 1) { // Means X and Y liked your ..
                    $action_takers .= __(' and ') . User::find(json_decode($similars[$i][0]->data)->action_user)->minified_name;
                } else { // Means X, Y and n($c-1) others liked your ..
                    $k=-1; // -1 because we take one before the comma (X, Y <- look at the appending after foreach)
                    foreach($similars[$i] as $similar)
                        $k++;
                    $action_takers .= ', ' . User::find(json_decode($similars[$i][0]->data)->action_user)->minified_name;
                    $action_takers .= __(' and ') . $k . (($k>1) ? __(' others ') : __(' other '));
                }
            }

            $resource_type = $data->resource_type;
            if($resource_type == 'thread') {
                $resource_type = "App\Models\Thread";
            } else if($resource_type == 'reply') {
                $resource_type = "App\Models\Post";
            }

            $resource_id = $data->action_resource_id;
            $disabled = (bool)
                $this->disables
                ->where('disabled_type', $resource_type)
                ->where('disabled_id', $resource_id)
                ->count();

            $result->push([
                'notif_id'=>$notification->id,
                'action_takers'=>$action_takers,
                'action_statement'=> __($data->action_statement),
                'resource_string_slice'=>$data->resource_string_slice,
                'resource_type'=>isset($data->resource_type) ? $data->resource_type : '',
                'action_date'=>(new Carbon($notification->created_at))->diffForHumans(),
                'action_real_date'=>$notification->created_at,
                'action_type'=>$data->action_type,
                'action_resource_link'=>$data->action_resource_link,
                'action_user' => User::find($data->action_user),
                'resource_id' => $data->action_resource_id,
                'resource_action_icon' => (new \App\Classes\Helper)->notification_icon($data->action_type),
                'notif_read' => !is_null($notification->read_at),
                'disabled'=>$disabled
            ]);
        }

        return [
            'notifs'=>$result,
            'hasmore'=>$hasmore
        ];
    }

    public function getMinifiedNameAttribute() {
        return strlen($fullname=($this->firstname . ' ' . $this->lastname)) > 20
            ? strlen($username=$this->username) > 14 ? substr($fullname, 0, 14) . '..': $username
            : $fullname;
    }

    public function getFullnameAttribute() {
        return $this->firstname . " " . $this->lastname;
    }

    public function getProfilelinkAttribute() {
        return route('user.profile', ['user'=>$this->username]);
    }

    public function getArchivedthreadsAttribute() {
        return $this->threads()->onlyTrashed();
    }

    public function getAboutminAttribute() {
        return strlen($about=($this->about)) > 100 ? substr($about, 0, 100) . '..' : $about;
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'user.'.$this->id.'.notifications';
    }
}

