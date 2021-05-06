<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Role, User, Permission};
use App\Classes\TestHelper;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function permissions_could_be_created() {
        $this->withoutExceptionHandling();

        Permission::create([
            'permission'=>'Create posts',
            'slug'=>'create.post'
        ]);

        $this->assertCount(1, Permission::all());
    }

    /** @test */
    public function permissions_could_be_attached_to_roles() {
        $role = TestHelper::create_role('Moderator', 'moderator');        
        $permission = TestHelper::create_permission('Update posts', 'update.post');

        $role->permissions()->attach($permission);

        $this->assertCount(1, $role->permissions);
    }

    /** @test */
    public function permissions_could_be_attached_to_users_directly() {
        $user = TestHelper::create_user();
        $permission = TestHelper::create_permission('Update posts', 'update.post');

        $user->permissions()->attach($permission);

        $this->assertCount(1, $user->permissions);
    }
}
