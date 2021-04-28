<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'moderator']);
    }

    public function create() {
        $data = request()->validate([
            'role'=>'required|min:2|max:100'
        ]);

        Role::create($data);
    }

    public function destroy(User $user, Role $role) {
        //$user->roles()->detach($role->id);
        
        DB::table('role_user')
        ->where('user_id', $user->id)
        ->where('role_id', $role->id)
        ->delete();
    }
}
