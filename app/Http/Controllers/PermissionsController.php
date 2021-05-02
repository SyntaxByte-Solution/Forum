<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Permission, Role};

class PermissionsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('role:owner')->only(['create', 'update', 'delete', 'attach_permission_to_role']);
    }

    public function create(Request $request) {
        $data = $request->validate([
            'permission'=>'required|max:200|unique:permissions,permission',
            'description'=>'nullable|max:1000'
        ]);

        Permission::create($data);
    }

    public function update(Request $request, Permission $permission) {
        $data = $request->validate([
            'permission'=>'required|max:200|unique:permissions,permission',
            'description'=>'nullable|max:1000'
        ]);

        $permission->update($data);
    }

    public function destroy(Permission $permission) {
        $permission->delete();
    }

    public function attach_permission_to_role(Request $request) {
        $role = Role::find($request->role);
        $permission = Permission::find($request->permission);

        if(!$role->has_permission($permission)) {
            $role->permissions()->attach($permission);
        } else {
            throw new \Exception($role->role . " role already has " . $permission->permission . " permission.");
        }
    }
}
