<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Classes\TestHelper;
use Illuminate\Support\Facades\DB;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_role_could_be_created() {
        $this->withoutExceptionHandling();

        $user = TestHelper::create_moderator();
        $this->actingAs($user);

        $this->post('/roles', [
            'role'=>'Admin'
        ]);
        /** 
         * we create a user, a normal user role automatically added then we attach moderator to him, 
         * then we create a role by hiting the /role endpoint
        */
        $this->assertCount(3, Role::all());
    }
    /** @test */
    public function only_moderator_could_create_roles() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user = TestHelper::create_user();
        $this->actingAs($user);

        $this->post('/roles', [
            'role'=>'Admin'
        ]);

        $this->assertCount(1, Role::all());
    }
    /** @test */
    public function only_moderators_could_assign_roles_to_users() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        // Normal user
        $user = TestHelper::create_user();
        // Normal user
        $role_assigner = TestHelper::create_user();

        TestHelper::assign_role($user, 'Admin', $role_assigner);
    }
    /** @test */
    public function a_moderator_could_detach_roles_from_users() {
        $this->withoutExceptionHandling();

        // Then create a normal user
        $moderator = TestHelper::create_moderator();
        
        $user = TestHelper::create_user();

        $this->assertEquals(1, count($user->roles));

        $role = TestHelper::assign_role($user, 'Admin', $moderator);

        // Notice we have to refresh the user instance to query the relations again
        $user->load('roles');
        
        $this->assertEquals(2, count($user->roles));
        
        $this->actingAs($moderator);
        // Then we hit the revoke role endpoint to detach that role from that user
        $this->delete('/users/' . $user->id . '/roles/' . $role->id);
        
        $user->load('roles');
        $this->assertEquals(1, count($user->roles));
    }

    /** @test */
    public function only_moderators_could_detach_roles_from_users() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        // Then create a normal user
        $moderator = TestHelper::create_moderator();
        
        $user = TestHelper::create_user();

        $role = $moderator->roles->first();
        
        /** 
         * Here, the normal user wants to remove the moderator role from moderator, but
         * an exception will immediately throws because the middleware inside Role's constructor will deny this user's
         * request
         */

        $this->actingAs($user);
        // Then we hit the revoke role endpoint to detach that role from that user
        $this->delete('/users/' . $moderator->id . '/roles/' . $role->id);
    }

    
}
