<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as UserAuthenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Role, Permission, UserStatus, Thread};
use App\Permissions\HasPermissionsTrait;
use Illuminate\Support\Carbon;

class User extends UserAuthenticatable implements Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait;

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

    public function threads() {
        return $this->hasMany(Thread::class);
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
}
