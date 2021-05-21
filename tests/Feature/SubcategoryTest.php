<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Exceptions\UnauthorizedActionException;
use App\Models\{Category, CategoryStatus, Subcategory};
use App\Classes\TestHelper;

class SubcategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void {
        parent::setUp();

        $admin = TestHelper::create_user_with_role('Admin', 'admin');
        $this->actingAs($admin);

        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        Category::create([
            'category'=>'Calisthenics',
            'description'=>'This section is for calisthenics athletes only.',
            'slug'=>'calisthenics',
            'status'=>1,
        ]);
    }

    /** @test */
    public function a_subcategory_could_be_added() {
        $this->withoutExceptionHandling();

        $this->assertCount(0, Subcategory::all());
        $this->post('/subcategory', [
            'subcategory'=>'Pull ups section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'category_id'=>1
        ]);
        $this->assertCount(1, Subcategory::all());
    }

    /** @test */
    public function subcategories_are_unique_relative_to_category() {
        $this->withoutExceptionHandling();
        $this->expectException(\App\Exceptions\DuplicateSubcategoryException::class);

        Subcategory::create([
            'subcategory'=>'Pull ups section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'category_id'=>1
        ]);

        $this->post('/subcategory', [
            'subcategory'=>'Pull ups section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'category_id'=>1
        ]);
    }

    /** @test */
    public function subcategory_could_be_edited() {
        $this->withoutExceptionHandling();

        $subcategory = Subcategory::create([
            'subcategory'=>'Pull ups section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'category_id'=>1
        ]);

        $this->patch('/subcategory/'.$subcategory->id, [
            'subcategory'=>'Pull ups gate',
        ]);

        $this->assertEquals('Pull ups gate', $subcategory->refresh()->subcategory);
    }

    /** @test */
    public function duplicate_subdirectories_titles_are_not_allowed_while_editing() {
        $this->withoutExceptionHandling();
        $this->expectException(\App\Exceptions\DuplicateSubcategoryException::class);

        Subcategory::create([
            'subcategory'=>'Pull ups section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'category_id'=>1
        ]);
        $subcategory = Subcategory::create([
            'subcategory'=>'Pull ups gate',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'category_id'=>1
        ]);

        $this->patch('/subcategory/'.$subcategory->id, [
            'subcategory'=>'Pull ups section',
        ]);
    }

    /** @test */
    public function subdirectory_could_be_deleted() {
        $this->withoutExceptionHandling();

        $subcategory = Subcategory::create([
            'subcategory'=>'Pull ups section',
            'description'=>'Pull ups section contains pull up challenges, questions and discussions',
            'category_id'=>1
        ]);
        
        $this->assertCount(1, Subcategory::all());
        $this->delete('/subcategory/'.$subcategory->id);
        $this->assertCount(0, Subcategory::all());
    }
}
