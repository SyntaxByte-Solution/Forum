<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Role;
use App\Classes\TestHelper;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_role_could_be_created() {
        $this->withoutExceptionHandling();

        $user = TestHelper::create_insider();
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
    
}
