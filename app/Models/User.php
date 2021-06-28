<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as UserAuthenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Role, Permission, UserStatus, UserReach, ProfileView, Thread, UserPersonalInfos, AccountStatus, Vote, Like};
use App\Permissions\HasPermissionsTrait;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends UserAuthenticatable implements Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait, SoftDeletes;

    protected $guarded = [];

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

    // Mutators
    public function getAvatarAttribute($value) {
        if(!$value) {
            if($this->provider_avatar) {
                return $this->provider_avatar;
            } else {
                return asset('storage') . '/users/defaults/avatar-default.png';
            }
        }

        return asset('storage') . '/' . $value;
    }

    public function getReachAttribute() {
        return UserReach::where('user_id', $this->id)->count();
    }

    public function getCoverAttribute($value) {
        if($value) {
            return asset('storage') . '/' . $value;
        }

        return $value;
    }

    public function getProfileViewsAttribute() {
        return ProfileView::where('visited_id', $this->id)->count();
    }

    public function personal() {
        return $this->hasOne(UserPersonalInfos::class, 'user');
    }

    public function threads() {
        return $this->hasMany(Thread::class);
    }

    public function liked_threads() {
        $threads_ids = Like::where('user_id', $this->id)->where('likable_type', 'App\Models\Thread')->pluck('likable_id');

        return Thread::whereIn('id', $threads_ids)->get();
    }

    public function votes() {
        return Vote::where('user_id', $this->id)->get();
    }

    public function votes_count() {
        return $this->votes()->count();
    }

    public function isBanned() {
        return $this->has_status('banned');
    }

    public function isAdmin() {
        return $this->has_role('admin');
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

    public function threads_count() {
        return $this->threads()->count();
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
                $action_takers_count = $group->count();
                $action_takers = '';
                switch($action_takers_count) {
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

                $cloned_notification_data = $this->notifications->where('data', $group[0])->first();
                
                $resource_action_icon = '';
                if($cloned_notification_data->data['action_type'] == 'thread-reply') {
                    $resource_action_icon = 'resource24-reply-icon';
                } else if($cloned_notification_data->data['action_type'] == 'thread-vote' || $cloned_notification_data->data['action_type'] == 'post-vote') {
                    $resource_action_icon = 'resource24-vote-icon';
                } else if($cloned_notification_data->data['action_type'] == 'resource-like') {
                    $resource_action_icon = 'resource24-like-icon';
                } else {
                    $resource_action_icon = 'notification24-icon';
                }

                $notifications->push([
                    'action_takers'=>$action_takers,
                    'action_statement'=> __($cloned_notification_data->data['action_statement']),
                    'resource_string_slice'=>$cloned_notification_data->data['resource_string_slice'],
                    'action_date'=>(new Carbon($cloned_notification_data->created_at))->diffForHumans(),
                    'action_type'=>$cloned_notification_data->data['action_type'],
                    'action_resource_link'=>$cloned_notification_data->data['action_resource_link'],
                    'action_user' => User::find($cloned_notification_data->data['action_user']),
                    'resource_action_icon' => $resource_action_icon,
                ]);
            }
        }

        return $notifications;
    }

    public function getMinifiedNameAttribute() {
        return strlen($fullname=($this->firstname . ' ' . $this->lastname)) > 20
            ? strlen($username=$this->username) > 14 ? substr($fullname, 0, 14) . '..': $username
            : $fullname;
    }
}

