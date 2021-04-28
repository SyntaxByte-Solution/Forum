<?php

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\{User, Role};

class TestHelper {

    public static function create_moderator() {
        $user = self::create_user();

        $role = Role::create(['role'=>'moderator']);
        
        $user->roles()->attach($role, ['assigned_by'=>$user->id]);
        // When a moderator get moderator role, we need to delete normal user role
        $user->roles()->detach(1);

        return $user;
    }
    public static function create_user() {
        $faker = \Faker\Factory::create();
        $user = User::create([
            'name'=>$faker->name,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);

        $role = Role::create(['role'=>'normal user']);

        $user->roles()->attach($role, ['assigned_by'=>null]);

        return $user;
    }
    public static function assign_role(User $user, string $role, User $moderator) {
        /**
         * Notice that the role_assigner must be a moderator
         */

        if(!$moderator->is_moderator()) {
            throw new \Exception('Only moderators could assign roles to others !');
        }
        
        $role = Role::create(['role'=>$role]);

        $user->roles()->attach($role, ['assigned_by'=>$moderator->id]);

        return $role;
    }
}