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
        Role::create([
            'role'=>'Admin'
        ]);
        $this->assertCount(1, Role::all());
    }

    /** @test */
    public function a_role_could_be_updated() {
        Role::create([
            'role'=>'Moderator'
        ]);

        $role = Role::first();

        $role->update([
            'role'=>'Normal User'
        ]);
        $this->assertEquals($role->role, 'Normal User');
    }

    /** @test */
    public function a_role_could_be_deleted() {
        Role::create([
            'role'=>'Moderator'
        ]);
        $this->assertCount(1, Role::all());
        Role::first()->delete();
        $this->assertCount(0, Role::all());
    }

    /** @test */
    public function a_role_could_be_attached() {
        $this->withoutExceptionHandling();

        $role = Role::create([
            'role'=>'Moderator'
        ]);

        $user = User::create([
            'name'=>'Mouad Nassri',
            'email'=>'mouad@gmail.com',
            'password'=>'laremuranium'
        ]);

        $this->assertCount(0, $user->roles);

        $user->attach_role($role);
        $user->load('roles');

        $this->assertCount(1, $user->roles);
    }

    /** @test */
    public function a_role_could_be_detached() {
        $this->withoutExceptionHandling();

        $role = Role::create([
            'role'=>'Moderator'
        ]);

        $user = User::create([
            'name'=>'Mouad Nassri',
            'email'=>'mouad@gmail.com',
            'password'=>'laremuranium'
        ]);
        $user->attach_role($role);
        $user->load('roles');

        $this->assertCount(1, $user->roles);

        $user->detach_role($role);
        $user->load('roles');

        $this->assertCount(0, $user->roles);
    }

    /** @test */
    public function an_exception_is_thrown_if_the_owner_try_to_detach_a_role_that_is_not_exist_in_user_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $role = Role::create([
            'role'=>'Moderator'
        ]);

        $user = User::create([
            'name'=>'Mouad Nassri',
            'email'=>'mouad@gmail.com',
            'password'=>'laremuranium'
        ]);

        $user->detach_role($role);
        $user->load('roles');

        $this->assertCount(0, $user->roles);
    }
}