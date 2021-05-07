<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Exceptions\AccessDeniedException;
use App\Models\{Role, User};
use App\Classes\TestHelper;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * For role management - Only owners could perform role CRUD operations and attaching permissions to roles.
     * But for assigning roles to users or assigning permissions to users we allow moderator and admins to do so
     * but in restricted scenarios.
     * For example, a moderator could assign admin role to some user, but he can't assign moderator role. The same thing with 
     * admin, he could assign only permissions or roles with lower priority to his own permissions and roles
     */

    /** @test */
    public function a_role_should_be_unique() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Validation\ValidationException::class);

        $owner = TestHelper::create_user_with_role('owner', 'owner');

        $this->actingAs($owner);
        
        $this->post('/roles', [
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);

        $this->post('/roles', [
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);
    }

    /** @test */
    public function only_owner_could_create_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $owner = TestHelper::create_user_with_role('owner', 'owner');
        $user = TestHelper::create_user();
        
        $this->actingAs($owner);

        $this->assertCount(1, Role::all());
        $this->post('/roles', [
            'role'=>'Admin',
            'slug'=>'admin'
        ]);
        $this->assertCount(2, Role::all());

        /** Now it should fail because normal user could not create roles */

        $this->actingAs($user);
        $this->post('/roles', [
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);
    }

    /** @test */
    public function owner_could_update_roles() {
        $owner = TestHelper::create_user_with_role('owner', 'owner');

        $this->actingAs($owner);
        
        $this->assertEquals('owner', Role::first()->role);
        $this->patch("/roles/1", [
            'role'=>'new_role_title',
            'slug'=>'role.test'
        ]);
        $this->assertEquals('new_role_title', Role::first()->role);
    }

    /** @test */
    public function only_owner_could_update_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $user = TestHelper::create_user();
        $role = TestHelper::create_role('Update a post', 'update.post');

        $this->actingAs($user);
        
        $this->patch("/roles/$role->id", [
            'role'=>'new_role_title',
            'slug'=>'role.test'
        ]);
    }

    /** @test */
    public function only_owner_could_delete_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $user = TestHelper::create_user();
        $role = TestHelper::create_role('Update a post', 'update.post');

        $this->actingAs($user);
        
        $this->assertCount(1, Role::all());
        $this->delete("/roles/$role->id");
        $this->assertCount(0, Role::all());
    }

    /** @test */
    public function only_owner_could_attach_roles_to_users() {
        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $user1 = TestHelper::create_user();
        $user2 = TestHelper::create_user();

        $role = Role::create([
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);
        
        $this->actingAs($user1);

        $this->post('/roles/attach', [
            'role_id'=>$role->id,
            'user_id'=>$user2->id
        ]);
    }

    /** @test */
    public function only_owners_could_detach_roles_from_users() {
        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $moderator_role = Role::create([
            'role'=>'Moderator',
            'slug'=>'moderator'
        ]);

        $user_1 = TestHelper::create_user();
        $user_1->roles()->attach($moderator_role);

        $user_2 = TestHelper::create_user();
        $user_2->roles()->attach($moderator_role);

        $this->actingAs($user_1);

        $this->delete("/users/$user_2->id/roles/$moderator_role->id/detach");
    }
}
