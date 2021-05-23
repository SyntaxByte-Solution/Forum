<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Exceptions\UserBannedException;
use App\Models\{Discussion, ThreadStatus, ForumStatus, CategoryStatus, PostStatus, Post, Thread};

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

    /** @test */
    public function only_discussion_creator_could_delete_it() {
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);
        $this->withoutExceptionHandling();

        $this->post('/general/discussions', [
            'subject'=>'How to gain more muscle',
            'category_id'=>1,
            'content'=>"You need to train everyday and maintain a solid consistency with a perfect diet and program, and you'll see the difference",
            'thread_id'=>1
        ]);

        $other_user = TestHelper::create_user();
        $this->actingAs($other_user);

        $discussion = Discussion::first();
        $this->delete('/general/discussions/'.$discussion->id);
    }

    /** @test */
    public function when_discussion_deleted_the_thread_and_its_associated_posts_get_deleted_as_well() {
        $this->withoutExceptionHandling();

        $this->post('/general/discussions', [
            'subject'=>'How to gain more muscle',
            'category_id'=>1,
            'content'=>"You need to train everyday and maintain a solid consistency with a perfect diet and program, and you'll see the difference",
            'thread_id'=>1
        ]);

        $this->post('/post', [
            'content'=>"post 1 on thread 1",
            'thread_id'=>1,
        ]);
        $this->post('/post', [
            'content'=>"post 1 on thread 2",
            'thread_id'=>1,
        ]);
        $this->post('/post', [
            'content'=>"post 1 on thread 3",
            'thread_id'=>1,
        ]);

        $discussion = Discussion::first();
        $thread = Thread::find($discussion->thread_id);

        $this->assertCount(1, Discussion::all());
        $this->assertCount(1, Thread::all());
        $this->assertCount(4, Post::all());

        $this->delete('/general/discussions/'.$discussion->id);

        $this->assertCount(0, Discussion::all());
        $this->assertCount(0, Thread::all());
        $this->assertCount(0, Post::all());
    }
}
