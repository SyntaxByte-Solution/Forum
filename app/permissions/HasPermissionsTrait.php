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

    public function has_role($role) {
        // Besically the following line allows you to pass either a role string or a Role object
        $role = ($role instanceof Role) ? $role->role : $role;

        return $this->roles()->where('role', $role)->first() ? true : false;
    }

    protected function has_permission($permission) {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
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