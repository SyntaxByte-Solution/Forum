<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Role;

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
}
