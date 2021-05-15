<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Role, User};

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_role_could_be_created() {
        $count = count(Role::all());

        Role::create([
            'role'=>'Admin',
            'slug'=>'admin'
        ]);
        $this->assertCount($count+1, Role::all());
    }

    /** @test */
    public function a_role_could_be_updated() {
        $role = Role::create([
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);

        $role->update([
            'role'=>'Normal User'
        ]);
        $this->assertEquals($role->role, 'Normal User');
    }

    /** @test */
    public function a_role_could_be_deleted() {
        
        $role = Role::create([
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);

        $count = count(Role::all());

        $this->assertCount($count, Role::all());
        Role::first()->delete();
        $this->assertCount($count-1, Role::all());
    }

    /** @test */
    public function a_role_could_be_attached() {
        $this->withoutExceptionHandling();

        $role = Role::create([
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);

        $user = User::create([
            'firstname'=>'Mouad',
            'lastname'=>'Nassri',
            'username'=>'Grotto',
            'email'=>'mouad@gmail.com',
            'password'=>'laremuranium'
        ]);

        $this->assertCount(0, $user->roles);
        $user->roles()->attach($role);
        $user->load('roles');
        $this->assertCount(1, $user->roles);
    }

    /** @test */
    public function a_role_could_be_detached() {
        $this->withoutExceptionHandling();

        $role = Role::create([
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);

        $user = User::create([
            'firstname'=>'Mouad',
            'lastname'=>'Nassri',
            'username'=>'Grotto',
            'email'=>'mouad@gmail.com',
            'password'=>'laremuranium'
        ]);

        $user->roles()->attach($role);
        $user->load('roles');
        $this->assertCount(1, $user->roles);

        $user->roles()->detach($role);
        $user->load('roles');
        $this->assertCount(0, $user->roles);
    }
}
