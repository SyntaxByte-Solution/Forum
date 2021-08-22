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
             * first we are goinf to delete: 
             * 1. likes on posts && likes on threads
             * 2. votes on posts && votes on threads
             * 3. saved threads
             * 4. saved threads of other users who saved the deleted user's threads
             * 4. followers
             * 5. followings
             * 6. threads -threads also will delete attached posts/likes/votes of other users -
             * 7. avatars
             * 8. cover
             */
            
            // foreach ($user->threads as $thread) {
            //     $thread->delete();
            // }
        });
    }

    // Even though using local scopes needs a lot of code update like prefixing user fetch queries but
    // it gives me what I need and it doesn't cause infinite (nested) calls to the global scope like in global scopes
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

    public function getReachAttribute() {
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

    public function savedthreads() {
        return $this->belongsToMany(Thread::class, 'saved_threads', 'user', 'thread')->withTimestamps()->withPivot('created_at')->orderBy('saved_threads.created_at', 'desc');
    }

    public function disables() {
        return $this->hasMany(NotificationDisable::class);
    }

    public function followers() {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function faqs() {
        return $this->hasMany(FAQ::class);
    }

    public function getFollowedUsersAttribute() {
        return 
            Follow::where('follower', $this->id)
            ->where('followable_type', 'App\Models\User')
            ->get();
    }

    public function liked_threads($order="desc") {
        $threads_ids = Like::where('user_id', $this->id)->where('likable_type', 'App\Models\Thread')->orderBy('created_at', $order)->pluck('likable_id');
        /**
         * The reason why we add reject is because sometimes the fetched threads from likes table are private or follower only threads and the
         * visitor is not a follower of the owners of these threads so the global scopes(ExcludePrivate and Followersonly) return null
         */
        return $threads_ids
            ->map(function($value) {
                return Thread::find($value);
            })->reject(function($value) {
                return $value == null;
            });
    }

    public function likes_on_threads() {
        return Like::where('user_id', $this->id)->where('likable_type', 'App\Models\Thread')->get();
    }

    public function likes_on_posts() {
        return Like::where('user_id', $this->id)->where('likable_type', 'App\Models\Post')->get();
    }
    
    public function votes_on_threads() {
        return Vote::where('user_id', $this->id)->where('votable_type', 'App\Models\Thread')->get();
    }

    public function votes_on_posts() {
        return Vote::where('user_id', $this->id)->where('votable_type', 'App\Models\Post')->get();
    }

    public function votes() {
        return Vote::where('user_id', $this->id)->get();
    }

    public function voted_threads($order="desc") {
        $threads_ids = Vote::where('user_id', $this->id)->where('votable_type', 'App\Models\Thread')->orderBy('created_at', $order)->pluck('votable_id');
        /**
         * The reason why we add reject is because sometimes the fetched threads from votes table are private or follower only threads and the
         * visitor is not a follower of the owners of these threads so the global scopes(ExcludePrivate and Followersonly) return null
         */
        return $threads_ids
        ->map(function($value) {
            return Thread::find($value);
        })->reject(function($value) {
            return $value == null;
        });
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
        return $this->has_status('banned');
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
        // Grouped based on action_type and action_resource_id
        $grouped_notifications = $this->notifications;

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
                    } else if($cloned_notification_data->data['action_type'] == 'reply-like' || $cloned_notification_data->data['action_type'] == 'thread-like') {
                        $resource_action_icon = 'resource24-like-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'warning-warning') {
                        $resource_action_icon = 'warning24-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'user-follow') {
                        $resource_action_icon = 'followfilled24-icon';
                    } else if($cloned_notification_data->data['action_type'] == 'avatar-change') {
                        $resource_action_icon = 'image24-icon';
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
        return $this->threads()->onlyTrashed()->get();
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

