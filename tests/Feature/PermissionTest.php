<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Role, User, Permission};
use App\Classes\TestHelper;
use App\Exceptions\UnauthorizedActionException;
use Illuminate\Support\Facades\DB;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Hint: Notice that we can't add or delete a permission because we've already used them with gates
     * and checks. Permissions could only be modefied and only the title because the slug also used in 
     * gates and middlewares.
    */

    /** @test */
    public function a_permission_title_could_be_updated_only_by_owner() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user();
        $owner = TestHelper::create_user_with_role('Owner', 'owner');

        $permission = TestHelper::create_permission('Create a post', 'create.post');

        $this->actingAs($owner);

        $this->patch('/permissions/' .$permission->id, [
            'permission'=>'New permission title',
        ]);
        $this->assertEquals('New permission title', $permission->refresh()->permission);

        $this->actingAs($user);

        $this->patch('/permissions/' .$permission->id, [
            'permission'=>'Old title',
        ]);
    }

    /** @test */
    public function only_owner_could_attach_permissions_to_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user();
        $owner = TestHelper::create_user_with_role('Owner', 'owner');

        $role = TestHelper::create_role('Moderator', 'moderator');

        $permission = TestHelper::create_permission('Create a post', 'create.post');
        $permission1 = TestHelper::create_permission('Delete a post', 'delete.post');

        $this->actingAs($owner);
        $this->assertCount(0, $role->permissions);
        $this->post('roles/' . $role->id . '/permissions/attach', [
            'permission'=>$permission->id,
        ]);
        $role->load('permissions');
        $this->assertCount(1, $role->permissions);

        $this->actingAs($user);
        $this->post('roles/' . $role->id . '/permissions/attach', [
            'permission'=>$permission1->id,
        ]);
    }
    
    /** @test */
    public function only_owner_could_detach_permissions_from_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user();
        $owner = TestHelper::create_user_with_role('Owner', 'owner');

        $role = TestHelper::create_role('Moderator', 'moderator');
        $permission = TestHelper::create_permission('Create a post', 'create.post');
        $permission1 = TestHelper::create_permission('Delete a post', 'delete.post');

        $role->permissions()->attach($permission);
        $role->permissions()->attach($permission1);

        $this->actingAs($owner);
        $this->assertCount(2, $role->permissions);
        $this->post("roles/$role->id/permissions/$permission->id/detach");
        $role->load('permissions');
        $this->assertCount(1, $role->permissions);

        $this->actingAs($user);
        $this->post("roles/$role->id/permissions/$permission1->id/detach");
    }

    /** 
     * @test 
     * IMPORTANT: when a role is deleted we need to delete associated records from both pivots: role_user & permission_role
    */
    public function when_a_role_is_deleted_all_related_records_in_pivot_tables_are_deleted_as_well() {
        $this->withoutExceptionHandling();

        $owner = TestHelper::create_user_with_role('Admin', 'admin');
        $role = TestHelper::create_role('Update a post', 'update.post');
        $permission = TestHelper::create_permission('Update a post', 'update.post');

        $owner->roles()->attach($role);

        $role->permissions()->attach($permission);

        $this->actingAs($owner);

        $this->assertCount(2, Role::all());
        $this->assertEquals(1, DB::table('role_user')->where('role_id', $role->id)->count());
        $this->assertEquals(1, DB::table('permission_role')->where('role_id', $role->id)->count());

        $this->delete("/roles/$role->id");

        $this->assertCount(1, Role::all());
        $this->assertEquals(0, DB::table('role_user')->where('role_id', $role->id)->count());
        $this->assertEquals(0, DB::table('permission_role')->where('role_id', $role->id)->count());
    }
    
}
