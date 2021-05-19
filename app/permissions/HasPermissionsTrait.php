<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;
use App\Models\UserStatus;

trait HasPermissionsTrait {

    public function roles() {
        return $this->belongsToMany(Role::class,'role_user');
    }
    
    public function permissions() {
        return $this->belongsToMany(Permission::class,'permission_user');
    }

    /**
     * Returns permissions for every role the current user has
     */
    public function roles_permissions() {
        $role_permissions = [];
        foreach($this->roles as $role) {
            foreach($role->permissions as $perm) {
                $role_permissions[] = $perm; 
            }
        }

        return array_unique($role_permissions);
    }

    /**
     * The permissions() relationship only fetch permissions assigned directly to the user by an owner. The following method
     * fetches both permissions from roles and directly assigned permissions.
    */
    public function all_permissions() {
        // all_permissions is initialited with roles_permissions then we add direct permissions to it
        $all_permissions = $this->roles_permissions();

        $direct_permissions = $this->permissions;

        foreach($direct_permissions as $permission) {
            $all_permissions[] = $permission;
        }
        
        return $all_permissions;
    }

    public function has_permission($slug) {
        // We need permission as model to search for it later.
        $perm = ($slug instanceof Permission) ? $slug : Permission::where('slug', $slug)->first();

        $all_permissions = $this->all_permissions();

        foreach($all_permissions as $permission) {
            if($permission->id == $perm->id) {
              return true;
            }
        }
        return false;
    }

    public function has_role($slug) {
        return (bool) $this->roles()->where('slug', $slug)->first();
    }

    public function status() {
        return UserStatus::find($this->status_id);
    }

    public function has_status($slug) {
        return $this->status()->slug == $slug;
    }
}