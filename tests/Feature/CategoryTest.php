<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Exceptions\UnauthorizedActionException;
use App\Models\{Category, CategoryStatus};
use App\Classes\TestHelper;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_admins_could_create_categories() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user_with_role('admin', 'admin');
        $this->actingAs($user);

        CategoryStatus::create([
            'status'=>'TEMPORARILTY CLOSED',
            'slug'=>'temp.closed'
        ]);

        $this->post('/categories', [
            'category'=>'Calisthenics Workout',
            'slug'=>'calisthenics',
            'description'=>'This section is for calisthenics athletes only.',
            'status'=>1,
        ]);

        $this->assertCount(1, Category::all());

        $user = TestHelper::create_user_with_role('moderator', 'moderator');
        $this->actingAs($user);

        $this->post('/categories', [
            'category'=>'BodyBuilding',
            'slug'=>'bodybuilding',
            'description'=>'This section is for bb athletes only.',
            'status'=>1,
        ]);
    }

    /** @test */
    public function only_admins_could_update_categories_informations() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user_with_role('admin', 'admin');
        $this->actingAs($user);

        CategoryStatus::create([
            'status'=>'TEMPORARILTY CLOSED',
            'slug'=>'temp.closed'
        ]);
        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        
        $this->patch('/categories/'.$category->id, [
            'description'=>'This section is for bb athletes only.',
            'status'=>1,
        ]);
        
        $this->assertEquals('This section is for bb athletes only.', $category->refresh()->description);

        $user = TestHelper::create_user_with_role('moderator', 'moderator');
        $this->actingAs($user);

        $this->patch('/categories/'.$category->id, [
            'category'=>'PR',
            'slug'=>'pr',
            'description'=>'This section is for bb athletes only.',
            'status'=>1,
        ]);
    }

    /** @test */
    public function only_admin_could_delete_categories() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user_with_role('admin', 'admin');
        $this->actingAs($user);

        CategoryStatus::create([
            'status'=>'TEMPORARILTY CLOSED',
            'slug'=>'temp.closed'
        ]);
        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        
        $this->assertCount(1, Category::all());
        $this->delete('/categories/'.$category->id);
        $this->assertCount(0, Category::all());
        
        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        $user = TestHelper::create_user();
        $this->actingAs($user);
        $this->delete('/categories/'.$category->id);
    }
}
