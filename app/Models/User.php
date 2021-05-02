<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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

    public function roles() {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function attach_role(Role $role) {
        if(!$this->has_role($role)) {
            $this->roles()->attach($role);
        }else {
            throw new \Exception("This user already has " . $role->role . " role.");
        }
    }

    public function has_role($role) {
        $role = ($role instanceof Role) ? $role->role : $role;
        foreach($this->roles as $r) {
            if($r->role == $role) {
                return true;
            }
        }

        return false;
    }

    public function detach_role(Role $role) {
        if($this->has_role($role)) {
            $this->roles()->detach($role);
        }else {
            throw new \Exception("This user doesn't have " . $role->role . " role.");
        }
    }
}
