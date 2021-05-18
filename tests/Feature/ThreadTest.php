<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Exceptions\AccessDeniedException;
use App\Classes\TestHelper;
use App\Models\{Thread, CategoryStatus, ThreadStatus};

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_thread_could_be_created() {
        $this->withoutExceptionHandling();

        $user = TestHelper::create_user();
        $this->actingAs($user);

        /**
         * Notice that thread schema use both category and thread default value to 1 
         * which is th first item in the database (LIVE)
         */

        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        ThreadStatus::create([
            'status'=>'LIVE'
        ]);

        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);

        $this->post('/thread', [
            'subject'=>'The side effects of using steroids',
            'category_id'=>1,
        ]);

        $this->assertCount(1, Thread::all());

        dd(Thread::first());
    }
}
