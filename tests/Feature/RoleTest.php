<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{Role, User};
use App\Classes\TestHelper;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_role_should_be_unique() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();

        $this->actingAs($owner);
        
        $this->post('/roles', [
            'role'=>'moderator',
        ]);

        $this->post('/roles', [
            'role'=>'moderator',
        ]);

    }

    /** @test */
    public function only_owner_could_create_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $this->actingAs($owner);
        // 2: owner & user
        $this->assertCount(2, Role::all());
        $this->post('/roles', [
            'role'=>'admin',
        ]);
        $this->assertCount(3, Role::all());

        /** Now it should fail because normal user could not create roles */

        $this->actingAs($user);
        $this->post('/roles', [
            'role'=>'admin',
        ]);
    }

    /** @test */
    public function only_owner_could_update_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $dump_role = TestHelper::create_role('DUMP');

        $this->actingAs($owner);
        
        $this->patch("/roles/$dump_role->id", [
            'role'=>'new_role_title'
        ]);
        $this->assertSame('new_role_title', $dump_role->refresh()->role);

        $this->actingAs($user);
        
        $this->patch("/roles/$dump_role->id", [
            'role'=>'old_title'
        ]);
    }

    /** @test */
    public function only_owner_could_delete_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $dump_role = TestHelper::create_role('DUMP');

        $this->actingAs($owner);
        
        $this->assertCount(3, Role::all());
        $this->delete("/roles/$dump_role->id");
        $this->assertCount(2, Role::all());

        $this->actingAs($user);
        $dump_role = TestHelper::create_role('DUMP');
        $this->delete("/roles/$dump_role->id");
    }

    /** @test */
    public function owner_could_attach_roles() {
        $owner = TestHelper::create_owner();
        $user = TestHelper::create_user();

        $user_role = Role::create([
            'role'=>'moderator'
        ]);
        
        $this->actingAs($owner);

        $this->post('/roles/attach', [
            'role'=>'moderator',
            'user_id'=>$user->id
        ]);
        
        $this->assertCount(2, $user->roles);
    }

    /** @test */
    public function only_owner_could_attach_roles_to_users() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user_1 = TestHelper::create_user();
        $user_2 = TestHelper::create_user();

        $user_role = Role::create([
            'role'=>'moderator'
        ]);
        
        $this->actingAs($user_1);

        $this->post('/roles/attach', [
            'role'=>'moderator',
            'user_id'=>$user_2->id
        ]);
        
        $this->assertCount(2, $user_2->roles);
    }

    /** @test */
    public function owner_could_detach_roles_from_users() {
        $this->withoutExceptionHandling();

        $owner_role = Role::create([
            'role'=>'owner'
        ]);
        $moderator_role = Role::create([
            'role'=>'moderator'
        ]);

        $user_1 = TestHelper::create_user();
        $user_1->roles()->attach($owner_role);

        $user_2 = TestHelper::create_user();
        $user_2->roles()->attach($moderator_role);

        $this->actingAs($user_1);

        $this->assertCount(2, $user_2->roles);
        $this->delete("/users/$user_2->id/roles/$moderator_role->id/detach");
        $user_2->load('roles');
        $this->assertCount(1, $user_2->roles);
    }

    /** @test */
    public function only_owners_could_detach_roles_from_users() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $moderator_role = Role::create([
            'role'=>'moderator'
        ]);

        $user_1 = TestHelper::create_user();
        $user_1->roles()->attach($moderator_role);

        $user_2 = TestHelper::create_user();
        $user_2->roles()->attach($moderator_role);

        $this->actingAs($user_1);

        $this->delete("/users/$user_2->id/roles/$moderator_role->id/detach");
    }
}
