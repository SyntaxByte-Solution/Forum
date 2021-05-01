<?php

namespace App\Classes;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\{User, Role};

class TestHelper {

    public static function create_user() {
        $faker = \Faker\Factory::create();

        $user = User::create([
            'name'=>$faker->name,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);
        $user_role;

        if(!self::role_exists('user')) {
            $user_role = Role::create([
                'role'=>'user'
            ]);
        } else {
            $user_role = Role::where('role', 'user')->first();
        }

        $user->roles()->attach($user_role);

        return $user;
    }

    public static function create_owner() {
        $owner = self::create_user();
        $owner_role;

        if(!self::role_exists('owner')) {
            $owner_role = Role::create([
                'role'=>'owner'
            ]);
        } else {
            $owner_role = Role::where('role', 'owner')->first();
        }

        $owner->roles()->attach($owner_role);

        return $owner;
    }

    public static function role_exists($role) {
        $role = ($role instanceof Role) ? $role->role : $role;

        return count(Role::where('role', $role)->get());
    }

    public static function create_role($role) {
        if(!self::role_exists($role)) {
            return Role::create([
                'role'=>$role
            ]);
        } else {
            Role::where('role', $role)->first();
        }
    }

}
