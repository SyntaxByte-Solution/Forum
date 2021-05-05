<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\{Role, Permission};

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

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function has_permission($permission) {
        $permission = ($permission instanceof Permission) ? $permission->permission : $permission;

        foreach($this->roles as $role) {
            foreach($role->permissions as $p) {
                if($p->permission == $permission) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Notice we have permissions relationship between user and permissions directly, where the user get permissions directly
     * from the owner
     * But default_permissions() method get permissions from this user's roles 
     * (Each role has some default permissions attached along with it)
     * 
     * Hint: Notice we check if the permission exists before insert it to the array because some roles has some common permissions.
     */
    public function default_permissions() {
        $permissions = [];
        $roles = $this->roles;

        foreach($roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return array_unique($permissions);
    }

    public function all_permissions() {
        // $permissions = $this->user_roles_permissions();

        // foreach($this->permissions as $permission) {
        //     $permissions[] = $permission;
        // }

        // return $permissions;
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

    public function attach_role(Role $role) {
        if(!$this->has_role($role)) {
            $this->roles()->attach($role);
        }else {
            throw new \Exception("This user already has " . $role->role . " role.");
        }
    }

    public function detach_role(Role $role) {
        if($this->has_role($role)) {
            $this->roles()->detach($role);
        }else {
            throw new \Exception("This user doesn't have " . $role->role . " role.");
        }
    }
}
