<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Category, CStatus};
use App\Classes\TestHelper;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function category_could_be_created() {
        
        CStatus::create([
            'status'=>'TEMPORARILTY CLOSED',
            'slug'=>'temp.closed'
        ]);

        Category::create([
            'category'=>'Calisthenics',
            'description'=>'This section is for calisthenics athletes only.',
            'slug'=>'calisthenics',
            'status'=>1,
        ]);

        $this->assertCount(1, Category::all());
    }
}
