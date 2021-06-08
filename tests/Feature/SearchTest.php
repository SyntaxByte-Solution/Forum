<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{Thread, ForumStatus, CategoryStatus, ThreadStatus, ThreadType, Post};

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void {
        parent::setUp();

        $user = TestHelper::create_user();
        $this->actingAs($user);
        /**
         * Notice that thread schema use both category and thread status default value to 1 
         * which is the first item in the database (LIVE)
         */
        ForumStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);
        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);
        ThreadStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);
        ThreadType::create([
            'type'=>'Question',
            'slug'=>'question',
        ]);

        TestHelper::create_forum('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        TestHelper::create_category('freestyle category', 'freestyle', 'This is freestyle category', 1, 1);
    }

    /** @test */
    public function search_field_is_required() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        //$this->expectException();
        // $k = 'How to lose weight in 1 hours ?';
        $k = '';

        $this->get('/{calisthenics}/search', [
            'k'=>''
        ]);

    }
}
