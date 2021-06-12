<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as UserAuthenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Role, Permission, UserStatus, Thread, UserPersonalInfos, AccountStatus};
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
                return 'users/defaults/avatar-default.png';
            }
        }

        return asset('storage') . '/' . $value;
    }

    public function getCoverAttribute($value) {
        if($value) {
            return asset('storage') . '/' . $value;
        }

        return $value;
    }

    public function personal() {
        return $this->hasOne(UserPersonalInfos::class, 'user');
    }

    public function threads() {
        return $this->hasMany(Thread::class);
    }

    public function discussions() {
        return $this->threads()->where('thread_type', 1);
    }

    public function questions() {
        return $this->threads()->where('thread_type', 2);
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

    public function discussions_count() {
        return $this->discussions()->count();
    }

    public function questions_count() {
        return $this->questions()->count();
    }
}
