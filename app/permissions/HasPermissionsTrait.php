<?php

namespace App\Permissions;

use App\Models\Permission;
use App\Models\Role;

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

    public function has_permission($permission) {
        // We need permission as model to search for it later.
        $perm = ($permission instanceof Permission) ? $permission : Permission::find($permission);

        $all_permissions = $this->all_permissions();

        foreach($all_permissions as $permission) {
            if($permission->id == $perm->id) {
              return true;
            }
        }
        return false;
    }

    public function has_role($role) {
        // Besically the following line allows you to pass either a role id or a Role object
        $role_id = ($role instanceof Role) ? $role->id : $role;

        return $this->roles()->find($role_id) ? true : false;
    }

    public function givePermissionsTo(...$permissions) {
        $permissions = $this->getAllPermissions($permissions);
        dd($permissions);
        if($permissions === null) {
        return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

  public function withdrawPermissionsTo(...$permissions) {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;

  }

  public function refreshPermissions(...$permissions) {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
  }

  public function hasPermissionTo($permission) {

    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
  }

  public function hasPermissionThroughRole($permission) {

    foreach ($permission->roles as $role){
      if($this->roles->contains($role)) {
        return true;
      }
    }
    return false;
  }

  protected function getAllPermissions(array $permissions) {

    return Permission::whereIn('slug',$permissions)->get();
    
  }

}