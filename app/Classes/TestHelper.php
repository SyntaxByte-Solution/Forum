<?php

namespace App\Classes;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\{User, Role, Permission};

class TestHelper {

    public static function create_user() {
        $faker = \Faker\Factory::create();

        $user = User::create([
            'name'=>$faker->name,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);

        return $user;
    }

    public static function create_user_with_role($role) {
        $user = self::create_user();

        if(!self::role_exists($role)) {
            $role = Role::create([
                'role'=>$role,
                'slug'=>'slave'
            ]);
        } else {
            $role = Role::where('role', $role)->first();
        }

        $user->roles()->attach($role);

        return $user;
    }

    public static function role_exists($role) {
        $role = ($role instanceof Role) ? $role->role : $role;

        return (bool) count(Role::where('role', $role)->get());
    }

    public static function permission_exists($permission) {
        $permission = ($permission instanceof Permission) ? $permission->permission : $permission;

        return (bool) count(Permission::where('permission', $permission)->get());
    }

    public static function create_role($role) {
        if(!self::role_exists($role)) {
            return Role::create([
                'role'=>$role,
                'slug'=>'slave'
            ]);
        }
        
        return Role::where('role', $role)->first();
    }

    public static function create_permission($permission) {
        if(!self::permission_exists($permission)) {
            return Permission::create([
                'permission'=>$permission,
                'description'=>'To find yourself, think for yourself - socrates'
            ]);
        }

        return Permission::where('permission', $permission)->first();
    }
}
