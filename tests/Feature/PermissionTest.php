<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Role, User, Permission};
use App\Classes\TestHelper;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function boo() {
        
        $user = TestHelper::create_user();

        $role = TestHelper::create_role('author', 'author');

        $permission0 = TestHelper::create_permission('Create Post', 'create.post');
        $permission1 = TestHelper::create_permission('Update Post', 'update.post');
        $permission2 = TestHelper::create_permission('Delete Post', 'delete.post');

        $permission3 = TestHelper::create_permission('Add Article', 'add.artice');

        $role->permissions()->attach($permission0);
        $role->permissions()->attach($permission1);
        $role->permissions()->attach($permission2);

        $user->roles()->attach($role);

        $user->permissions()->attach($permission3);

        // Till now, this user should have 4 permissions
        $this->assertCount(4, $user->all_permissions());

    }
}
