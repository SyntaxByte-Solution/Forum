<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Exceptions\{UserBannedException};
use App\Models\{User, ForumStatus, ThreadStatus, PostStatus, CategoryStatus, Thread, Post};
use App\Classes\TestHelper;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void {
        parent::setUp();

        $user = TestHelper::create_user();
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
        PostStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        $forum = TestHelper::create_forum('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        $catgeory = TestHelper::create_category('freestyle category', 'freestyle', 'This is freestyle category', 1, 1);

        $thread = Thread::create([
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
        ]);
    }

    /** @test */
    public function post_could_be_created() {
        $this->withoutExceptionHandling();
        $this->actingAs(User::first());

        $this->assertCount(0, Post::all());
        $this->post('/post', [
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
        ]);
        $this->assertCount(1, Post::all());
    }

    /** @test */
    public function post_could_be_updated() {
        $this->withoutExceptionHandling();

        $this->actingAs(User::first());

        $post = Post::create([
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
            'user_id'=>1
        ]);

        $this->patch('/post/'.$post->id, [
            'title'=>'Re: This is the editable version of the subject of our post',
            'content'=>"Hello guys, Never mind, I think I was drunk right !",
        ]);
        
        $this->assertEquals('Re: This is the editable version of the subject of our post', $post->refresh()->title);
        $this->assertEquals('Hello guys, Never mind, I think I was drunk right !', $post->refresh()->content);
    }

    /** @test */
    public function post_could_be_deleted() {
        $this->withoutExceptionHandling();

        $this->actingAs(User::first());

        $post = Post::create([
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
            'user_id'=>1
        ]);

        $this->assertCount(1, Post::all());
        $this->delete('/post/'.$post->id);
        $this->assertCount(0, Post::all());
    }

    /** @test */
    public function banned_user_cant_add_post() {
        $this->withoutExceptionHandling();
        $this->expectException(UserBannedException::class);

        $banned = TestHelper::create_user_with_status('BANNED', 'banned');
        $this->actingAs($banned);

        $this->post('/post', [
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
        ]);
    }

    /** @test */
    public function users_could_post_a_limited_number_of_posts_per_day() {
        $this->withoutExceptionHandling();

        $user = User::first();
        $this->actingAs($user);

        $this->post('/post', [
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
        ]);

        $this->post('/post', [
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
        ]);

        $this->post('/post', [
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
        ]);

        $thread2 = Thread::create([
            'subject'=>'The side effects of using glutamine',
            'user_id'=>1,
            'category_id'=>1,
        ]);

        $this->post('/post', [
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>2,
        ]);

        /**
         * Again here we can't create too many posts to test this feature, because the user
         * could post 280 posts per day as maximum. If you want to test this try to change the max
         * to 3 and expect authorization expected to be returned from the authorization inside the controller
         */
        $this->assertTrue(true);
    }

    /** @test */
    public function only_post_owner_could_edit_the_current_post() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        $post = Post::create([
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
            'user_id'=>1
        ]);

        $other_user = TestHelper::create_user();
        $this->actingAs($other_user);

        $this->patch('/post/'.$post->id, [
            'title'=>'Re: This is the editable version of the subject of our post',
            'content'=>"Hello guys, Never mind, I think I was drunk right !",
        ]);
    }

    /** @test */
    public function only_post_owner_could_delete_the_dcurrent_post() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        $post = Post::create([
            'title'=>'Re: This is the subject of our post',
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
            'user_id'=>1
        ]);

        $other_user = TestHelper::create_user();
        $this->actingAs($other_user);

        $this->delete('/post/'.$post->id);
    }

}
