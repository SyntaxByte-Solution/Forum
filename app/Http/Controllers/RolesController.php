<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Role};

class RolesController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'role:owner']);
    }

    public function create(Request $request) {
        $data = $request->validate([
            'role'=>'required|unique:roles,role',
        ]);

        Role::create($data);
    }

    public function attach(Request $request) {
        $data = $request->validate([
            'role'=>'required|exists:roles',
            'user_id'=>'required'
        ]);

        $user = User::find($data['user_id']);
        $role = Role::where('role', $data['role'])->first();

        if(!$user->has_role($role)) {
            $user->roles()->attach($role);
        }
    }

    public function detach(Request $request, User $user, Role $role) {
        $user->roles()->detach($role);
    }

    public function update(Request $request, Role $role) {
        $data = $request->validate([
            'role'=>'required|unique:roles',
        ]);

        $role->update($data);
    }

    public function destroy(Role $role) {
        $role->delete();
    }

}
