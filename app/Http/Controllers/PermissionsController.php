<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\{Permission, Role, User};
use App\Exceptions\UnauthorizedActionException;

class PermissionsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function update(Permission $permission) {
        if (! Gate::allows('update.permissions')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }

        $data = request()->validate([
            'permission'=>'required|max:400'
        ]);

        $permission->update($data);
    }

    public function attach_permission_to_role(User $user, Role $role) {
        if (! Gate::allows('role.permission.attach')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }

        $data = request()->validate([
            'permission'=>'exists:permissions,id'
        ]);

        $role->permissions()->attach($data['permission']);
    }

    public function detach_permission_from_role(User $user, Role $role, Permission $permission) {
        if (! Gate::allows('role.permission.detach')) {
            throw new UnauthorizedActionException("Unauthorized action due to missing role or permission.");
        }
        
        $role->permissions()->detach($permission->id);
    }


}
