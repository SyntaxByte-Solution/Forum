<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Exceptions\{UnauthorizedActionException, DuplicateCategoryException};
use App\Models\{Forum, Category, ForumStatus, CategoryStatus};
use App\Classes\TestHelper;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void {
        parent::setUp();

        $admin = TestHelper::create_user_with_role('Admin', 'admin');
        $this->actingAs($admin);

        ForumStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);
        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        Forum::create([
            'forum'=>'Calisthenics',
            'description'=>'This forum is for calisthenics athletes only.',
            'slug'=>'calisthenics',
            'status'=>1,
        ]);
    }

    /** @test */
    public function a_category_could_be_added() {
        $this->withoutExceptionHandling();

        $this->assertCount(0, Category::all());
        $this->post('/categories', [
            'category'=>'Pull ups section',
            'slug'=>'pull-ups-section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'forum_id'=>1,
            'status'=>1
        ]);
        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function categories_are_unique_relative_to_category() {
        $this->withoutExceptionHandling();
        $this->expectException(\App\Exceptions\DuplicateCategoryException::class);

        Category::create([
            'category'=>'Pull ups section',
            'slug'=>'Pull ups section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'forum_id'=>1,
            'status'=>1,
        ]);

        $this->post('/categories', [
            'category'=>'Pull ups section',
            'slug'=>'Pull ups section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'forum_id'=>1,
            'status'=>1,
        ]);
    }

    /** @test */
    public function category_could_be_edited() {
        $this->withoutExceptionHandling();

        $category = Category::create([
            'category'=>'Pull ups section',
            'slug'=>'pull-ups-section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'forum_id'=>1,
            'status'=>1,
        ]);

        $this->patch('/categories/'.$category->id, [
            'category'=>'Pull ups gate',
        ]);

        $this->assertEquals('Pull ups gate', $category->refresh()->category);
    }

    /** @test */
    public function duplicate_categories_titles_are_not_allowed_while_editing() {
        $this->withoutExceptionHandling();
        $this->expectException(\App\Exceptions\DuplicateCategoryException::class);

        Category::create([
            'category'=>'Pull ups section',
            'slug'=>'pull-ups-section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'forum_id'=>1,
            'status'=>1,
        ]);
        $category = Category::create([
            'category'=>'Pull ups gate',
            'slug'=>'pull-ups-section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'forum_id'=>1,
            'status'=>1,
        ]);

        $this->patch('/categories/'.$category->id, [
            'category'=>'Pull ups section',
        ]);
    }

    /** @test */
    public function categories_could_be_deleted() {
        $this->withoutExceptionHandling();

        $category = Category::create([
            'category'=>'Pull ups section',
            'slug'=>'pull-ups-section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'forum_id'=>1,
            'status'=>1
        ]);
        
        $this->assertCount(1, Category::all());
        $this->delete('/categories/'.$category->id);
        $this->assertCount(0, Category::all());
    }
}
