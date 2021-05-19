<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Exceptions\AccessDeniedException;
use App\Models\{Role, User, Thread, CategoryStatus, ThreadStatus, PostStatus, Post};
use App\Classes\TestHelper;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void {
        parent::setUp();

        $user = TestHelper::create_user();
        /**
         * Notice that thread schema use both category and thread default value to 1 
         * which is th first item in the database (LIVE)
         */

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

        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);

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

}
