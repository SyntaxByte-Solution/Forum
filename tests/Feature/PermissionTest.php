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
    public function permission_must_be_unique() {
        $owner = TestHelper::create_owner();

        $this->actingAs($owner);
        
        $this->post('/permissions', [
            'permission'=>'create.user',
            'description'=>'Create users permission'
        ]);
        
        $response = $this->post('/permissions', [
            'permission'=>'create.user',
            'description'=>'Update users permission'
        ]);
        // Because permission must be unique
        $response->assertSessionHasErrors();
    }
    /** @test */
    public function only_owner_could_create_permission() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $this->actingAs($owner);
        
        $this->assertCount(0, Permission::all());
        $this->post('/permissions', [
            'permission'=>'create.user',
            'description'=>'Create users permission'
        ]);
        $this->assertCount(1, Permission::all());

        $this->actingAs($user);
        
        $this->post('/permissions', [
            'permission'=>'update.user',
            'description'=>'Update users permission'
        ]);
    }
    /** @test */
    public function only_owner_could_update_permission() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $permission = TestHelper::create_permission('create.post');

        $this->actingAs($owner);

        $this->patch("/permissions/$permission->id", [
            'permission'=>'new_permission_name',
            'description'=>'new_description'
        ]);
        
        $this->assertSame('new_permission_name', $permission->refresh()->permission);
        
        $this->actingAs($user);

        $this->patch("/permissions/$permission->id", [
            'permission'=>'old_one',
            'description'=>'old_description'
        ]);
    }
    /** @test */
    public function only_owner_could_delete_permissions() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $permission = TestHelper::create_permission('create.post');

        $this->actingAs($owner);

        $this->assertCount(1, Permission::all());
        $this->delete("/permissions/$permission->id");
        $this->assertCount(0, Permission::all());

        $this->actingAs($user);
        $this->delete("/permissions/$permission->id");
    }
    /** @test */
    public function permissions_could_be_attached_to_roles() {
        $permission0 = TestHelper::create_permission('foo0');
        $permission1 = TestHelper::create_permission('foo1');

        $role = TestHelper::create_role('boo');

        $role->permissions()->attach($permission0);
        $role->permissions()->attach($permission1);
        $this->assertCount(2, $role->permissions);
    }
    /** @test */
    public function only_owners_could_attach_permissions_to_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $role = TestHelper::create_role('admin');
        $permission = TestHelper::create_permission('update.post');

        $this->actingAs($owner);
        
        $this->assertCount(0, $role->permissions);
        $this->post("roles/permissions/attach", [
            'role'=>$role->id,
            'permission'=>$permission->id
        ]);
        $role->load('permissions');
        $this->assertCount(1, $role->permissions);

        $this->actingAs($user);
        
        $this->post("roles/permissions/attach", [
            'role'=>$role->id,
            'permission'=>$permission->id
        ]);
    }
    /** @test */
    public function only_owners_could_dettach_permissions_from_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $role = TestHelper::create_role('admin');
        $permission = TestHelper::create_permission('update.post');

        $role->permissions()->attach($permission);

        $this->actingAs($owner);

        $this->assertCount(1, $role->permissions);
        $this->post("roles/permissions/detach", [
            'role'=>$role->id,
            'permission'=>$permission->id
        ]);
        $role->load('permissions');
        $this->assertCount(0, $role->permissions);

        $role->permissions()->attach($permission);
        $this->actingAs($user);
        $this->post("roles/permissions/detach", [
            'role'=>$role->id,
            'permission'=>$permission->id
        ]);

    }
    /** @test */
    public function foo() {
        $role = TestHelper::create_role('Moderator');
        $role1 = TestHelper::create_role('Admin');

        $permission0 = TestHelper::create_permission('create.user');
        $permission1 = TestHelper::create_permission('update.user');
        $permission2 = TestHelper::create_permission('delete.user');
        $permission3 = TestHelper::create_permission('delete.post');

        $role->permissions()->attach($permission0);
        $role->permissions()->attach($permission1);
        $role->permissions()->attach($permission2);

        $role1->permissions()->attach($permission0);
        $role1->permissions()->attach($permission1);
        $role1->permissions()->attach($permission1);

        $user = TestHelper::create_user();
        //$this->assertCount(0, $user->all_permissions());
        $user->roles()->attach($role);
        $user->roles()->attach($role1);
        $user->permissions()->attach($permission3);
        
        $role->load('permissions');
        $role1->load('permissions');
        $user->load('roles');
        $user->load('permissions');
        
        foreach($user->default_permissions() as $p) {
            echo $p->permission . PHP_EOL;
        }

        $this->assertTrue(true);
        // $this->assertCount(3, $user->user_roles_permissions());
        // $this->assertCount(4, $user->all_permissions());
    }
}