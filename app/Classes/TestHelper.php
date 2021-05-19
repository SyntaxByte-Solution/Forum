<?php

namespace App\Classes;

use Illuminate\Foundation\Testing\WithFaker;
use App\Models\{User, Role, Permission, Category, UserStatus};

class TestHelper {

    public static function create_user() {
        $faker = \Faker\Factory::create();

        $status = self::create_user_status('Unverified', 'unverified')->id;

        $user = User::create([
            'firstname'=>$faker->firstname,
            'lastname'=>$faker->lastname,
            'username'=>$faker->username,
            'status_id'=>$status,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);

        return $user;
    }

    public static function create_user_with_status($status, $slug) {
        $faker = \Faker\Factory::create();

        $status = self::create_user_status($status, $slug)->id;

        $user = User::create([
            'firstname'=>$faker->firstname,
            'lastname'=>$faker->lastname,
            'username'=>$faker->username,
            'status_id'=>$status,
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

    public static function category_exists($slug) {
        return (bool) count(Category::where('slug', $slug)->get());
    }

    public static function user_status_exists($slug) {
        return (bool) count(UserStatus::where('slug', $slug)->get());
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
        if(!self::permission_exists($slug)) {
            return Permission::create([
                'permission'=>$permission,
                'slug'=>$slug,
                'description'=>'To find yourself, think for yourself - socrates'
            ]);
        }

        return Permission::where('permission', $permission)->first();
    }

    public static function create_category($category, $slug, $desc, $status) {
        if(!self::category_exists($slug)) {
            return Category::create([
                'category'=>$category,
                'slug'=>$slug,
                'description'=>$desc,
                'status'=>$status
            ]);
        }

        return Category::where('slug', $slug)->first();
    }

    public static function create_user_status($status, $slug) {
        if(!self::user_status_exists($slug)) {
            return UserStatus::create([
                'status'=>$status,
                'slug'=>$slug,
            ]);
        }

        return UserStatus::where('slug', $slug)->first();
    }
}
