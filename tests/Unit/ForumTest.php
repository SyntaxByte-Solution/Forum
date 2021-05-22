<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Forum, ForumStatus};
use App\Classes\TestHelper;

class ForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function forum_could_be_created() {
        
        ForumStatus::create([
            'status'=>'TEMPORARILTY CLOSED',
            'slug'=>'temp.closed'
        ]);

        Forum::create([
            'forum'=>'Calisthenics',
            'description'=>'This section is for calisthenics athletes only.',
            'slug'=>'calisthenics',
            'status'=>1,
        ]);

        $this->assertCount(1, Forum::all());
    }
}
