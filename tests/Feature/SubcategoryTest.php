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
    public function foo() {
        $category = Category::first();

        $subdirectory = Subcategory::create([
            'subcategory'=>'pull up section',
            'description'=>'This section, is for pull ups exercices and challenges',
            'category_id'=>1
        ]);
        $subdirectory = Subcategory::create([
            'subcategory'=>'pull up section',
            'description'=>'This section, is for pull ups exercices and challenges',
            'category_id'=>1
        ]);

        dd($subdirectory->category);
    }
}
