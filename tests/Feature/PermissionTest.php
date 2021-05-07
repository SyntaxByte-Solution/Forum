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
    public function a_permission_title_could_be_updated_only_by_owner() {
        $this->withoutExceptionHandling();

        $user = TestHelper::create_user();
        $owner = TestHelper::create_user_with_role('Owner', 'owner');

        $permission = TestHelper::create_permission('Create a post', 'create.post');

        $this->actingAs($owner);

        $this->patch('/permissions/' .$permission->id, [
            'permission'=>'New permission title',
        ]);

        $this->assertEquals('New permission title', $permission->refresh()->permission);
    }
}
