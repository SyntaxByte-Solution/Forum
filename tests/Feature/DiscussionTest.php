<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Exceptions\UserBannedException;
use App\Models\{Discussion, ThreadStatus, ForumStatus, CategoryStatus, PostStatus};

class DiscussionTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void {
        parent::setUp();

        $user = TestHelper::create_user();
        $this->actingAs($user);

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
        PostStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        $forum = TestHelper::create_forum('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        $catgeory = TestHelper::create_category('freestyle category', 'freestyle', 'This is freestyle category', 1, 1);
    }

    /** @test */
    public function discussion_could_be_added() {
        $this->withoutExceptionHandling();

        $this->assertCount(0, Discussion::all());
        $this->post('/general/discussions', [
            'subject'=>'How to gain more muscle',
            'category_id'=>1,
            'content'=>"You need to train everyday and maintain a solid consistency with a perfect diet and program, and you'll see the difference",
            'thread_id'=>1
        ]);
        $this->assertCount(1, Discussion::all());
    }

    /** @test */
    public function banned_user_cant_add_discussions() {
        $this->expectException(UserBannedException::class);
        $this->withoutExceptionHandling();

        $banned_user = TestHelper::create_user_with_status('Banned user', 'banned');
        $this->actingAs($banned_user);

        $this->post('/general/discussions', [
            'subject'=>'How to gain more muscle',
            'category_id'=>1,
            'content'=>"You need to train everyday and maintain a solid consistency with a perfect diet and program, and you'll see the difference",
            'thread_id'=>1
        ]);
    }

    /** @test */
    public function discussion_could_be_deleted() {
        $this->withoutExceptionHandling();

        $this->post('/general/discussions', [
            'subject'=>'How to gain more muscle',
            'category_id'=>1,
            'content'=>"You need to train everyday and maintain a solid consistency with a perfect diet and program, and you'll see the difference",
            'thread_id'=>1
        ]);

        $this->assertCount(1, Discussion::all());

        $discussion = Discussion::first();

        $this->delete('/general/discussions/'.$discussion->id);
        $this->assertCount(0, Discussion::all());
    }
}
