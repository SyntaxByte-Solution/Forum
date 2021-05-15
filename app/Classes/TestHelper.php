<?php

namespace App\Classes;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\{User, Role, Permission};

class TestHelper {

    public static function create_user() {
        $faker = \Faker\Factory::create();

        $user = User::create([
            'firstname'=>$faker->firstname,
            'lastname'=>$faker->lastname,
            'username'=>$faker->username,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);

        return $user;
    }

    public static function create_user_with_role($role, $slug) {
        $user = self::create_user();

        if(!self::role_exists($slug)) {
            $role = Role::create([
                'role'=>$role,
                'slug'=>$slug
            ]);
        } else {
            $role = Role::where('slug', $slug)->first();
        }

        $user->roles()->attach($role);

        return $user;
    }

    public static function role_exists($slug) {
        return (bool) count(Role::where('slug', $slug)->get());
    }

    public static function permission_exists($slug) {
        return (bool) count(Permission::where('slug', $slug)->get());
    }

    public static function create_role($role, $slug) {
        if(!self::role_exists($role)) {
            return Role::create([
                'role'=>$role,
                'slug'=>$slug
            ]);
        }
        
        return Role::where('role', $role)->first();
    }

    public static function create_permission($permission, $slug) {
        if(!self::permission_exists($permission)) {
            return Permission::create([
                'permission'=>$permission,
                'slug'=>$slug,
                'description'=>'To find yourself, think for yourself - socrates'
            ]);
        }

        return Permission::where('permission', $permission)->first();
    }
}
