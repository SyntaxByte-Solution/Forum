<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Role, User};
use App\Classes\TestHelper;

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

        $user = TestHelper::create_user();

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

        $user = TestHelper::create_user();

        $user->roles()->attach($role);
        $user->load('roles');
        $this->assertCount(1, $user->roles);

        $user->roles()->detach($role);
        $user->load('roles');
        $this->assertCount(0, $user->roles);
    }
}
