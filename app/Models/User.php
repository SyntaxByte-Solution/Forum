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
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function setRoleAttribute($role) {
        /**
         * This mutator will fetch the moderator string and it will return a role id if this role string exists.
         * Notice: If the string doesn't exists, we return the id of role:Normal User
         */
        
        $role = Role::where('role', $role)->first();

        if(is_null($role)) {
            $role = Role::where('role', 'Normal User')->first();
        }

        $this->attributes['role'] = $role->id;
    }
}
