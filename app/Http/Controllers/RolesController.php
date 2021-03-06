<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{User, Role};


class RolesController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'role:admin']);
    }

    public function create(Request $request) {
        $data = $request->validate([
            'role'=>'required|unique:roles,role',
            'slug'=>'required|unique:roles,slug'
        ]);

        Role::create($data);
    }

    public function attach(Request $request) {
        $data = $request->validate([
            'role_id'=>'required|exists:roles,id',
            'user_id'=>'required'
        ]);

        $user = User::find($data['user_id']);
        $role = Role::find($data['role_id']);

        if(!$user->has_role($role)) {
            $user->roles()->attach($role->id);
        }
    }

    public function detach(Request $request, User $user, Role $role) {
        if($user->has_role($role)) {
            $user->roles()->detach($role->id);
        }
    }

    public function update(Request $request, Role $role) {
        $data = $request->validate([
            'role'=>'required|unique:roles,role',
        ]);

        $role->update($data);
    }

    public function destroy(Role $role) {
        DB::table('role_user')->where('role_id', $role->id)->delete();
        DB::table('permission_role')->where('role_id', $role->id)->delete();
        $role->delete();
    }

}
