<?php

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Models\{User, Role};

class TestHelper {
    /** Insider is a moderator created by itself and assign moderator role to itself :) */
    public static function create_insider() {
        $user = self::create_user();

        $role = Role::create(['role'=>'moderator']);

        $user->roles()->attach($role, ['assigned_by'=>$user->id]);

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
        $found = false;
        foreach($moderator->roles as $r) {
            if(strtolower($r->role) == 'moderator') {
                $found = true;
                break;
            }
        }

        if(!$found) {
            throw new \Exception('Only moderators could assign roles to others !');
        }
        
        $role = Role::create(['role'=>$role]);

        $user->roles()->attach($role, ['assigned_by'=>$moderator->id]);
    }
}