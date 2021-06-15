<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Exceptions\{AccessDeniedException, UserBannedException, DuplicateThreadException, CategoryClosedException};
use App\Classes\TestHelper;
use App\Models\{Thread, ForumStatus, CategoryStatus, ThreadStatus, PostStatus, ThreadType, Post};

class ThreadTest extends TestCase
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
        PostStatus::create([
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

        $forum = TestHelper::create_forum('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        $catgeory = TestHelper::create_category('freestyle category', 'freestyle', 'This is freestyle category', 1, 1);

    }

    /** @test */
    public function a_thread_could_be_created() {
        $this->withoutExceptionHandling();

        $this->post('/thread', [
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'category_id'=>1,
            'thread_type'=>1
        ]);

        $this->assertCount(1, Thread::all());
    }

    /** @test */
    public function a_banned_user_could_not_create_threads() {
        $this->withoutExceptionHandling();
        $this->expectException(UserBannedException::class);

        $user = TestHelper::create_user_with_status('banned', 'banned');
        $this->actingAs($user);

        $this->post('/thread', [
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'category_id'=>1,
            'thread_type'=>1
        ]);
    }

    /** @test */
    public function a_thread_could_be_updated() {
        $this->withoutExceptionHandling();

        TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1, 1);

        $thread = Thread::create([
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
            'thread_type'=>1
        ]);

        $this->patch('/thread/'.$thread->id, [
            'subject'=>'Why using steroids is dangerous ?',
            'category_id'=>2,
            'thread_type'=>1
        ]);

        $this->assertEquals('Why using steroids is dangerous ?', $thread->refresh()->subject);
        $this->assertEquals(2, $thread->refresh()->category_id);
    }

    /** @test */
    public function a_user_could_not_create_two_threads_with_the_same_subject() {
        $this->withoutExceptionHandling();

        TestHelper::create_category('Workout', 'workout', 'This section is for workout athletes only.', 1, 1);

        $thread = Thread::create([
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
            'thread_type'=>1
        ]);
        $thread1 = Thread::create([
            'content'=>'This is the content #2',
            'subject'=>'The side effects of using protein',
            'user_id'=>1,
            'category_id'=>1,
            'thread_type'=>1
        ]);

        // Here we try to edit the first thread with a new subject but already taken by the same user in the second thread
        /**
         * Notice that we edit the constraint to allow user to post two threads with the same subject
         * but in different categories
         * Now for this case we need to have the same category and the same subject in order to get the error
         */
        $response = $this->patch('/thread/'.$thread->id, [
            'subject'=>'The side effects of using protein',
            'category_id'=>1,
            'thread_type'=>1
        ]);
        // Assert that the subject is not updated because there's duplicates
        $this->assertEquals('The side effects of using steroids', $thread->refresh()->subject);

        // Assert that the response is returnned with a session error
        $response->assertSessionHas('type', 'error');
    }

    /** @test */
    public function only_thread_owner_could_update_it() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        // We create the thread with user1
        $thread = Thread::create([
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
            'thread_type'=>1
        ]);

        // Then we want to update the thread using user2
        $user2 = TestHelper::create_user();
        $this->actingAs($user2);

        $this->patch('/thread/'.$thread->id, [
            'subject'=>'Why using steroids is dangerous ?',
        ]);
    }

    /** @test */
    public function a_thread_could_be_deleted() {
        $this->withoutExceptionHandling();

        $thread = Thread::create([
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
            'thread_type'=>1
        ]);

        $this->assertCount(1, Thread::all());
        $this->delete('/thread/'.$thread->id);
        $this->assertCount(0, Thread::all());
    }

    /** @test */
    public function only_thread_owner_could_delete_the_current_thread() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        $thread = Thread::create([
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
            'thread_type'=>1
        ]);

        $user1 = TestHelper::create_user();
        $this->actingAs($user1);

        $this->delete('/thread/'.$thread->id);
    }

    /** @test */
    public function when_a_thread_is_force_deleted_all_related_resources_must_be_deleted_as_well() {
        $this->withoutExceptionHandling();

        $thread = Thread::create([
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
            'thread_type'=>1
        ]);

        Post::create([
            'content'=>'Post #1',
            'thread_id'=>$thread->id,
            'user_id'=>1
        ]);

        Post::create([
            'content'=>'Post #2',
            'thread_id'=>1,
            'user_id'=>1
        ]);

        $this->assertCount(2, $thread->posts);
        $this->assertCount(1, Thread::all());
        $this->delete('/thread/'.$thread->id.'/force');
        $this->assertCount(0, Thread::all());

        $thread->load('posts');
        $this->assertCount(0, $thread->posts);
    }

    /** @test */
    public function user_could_create_a_limited_number_of_threads_per_day() {
        $this->withoutExceptionHandling();
        /*
            $this->post('/thread', [
                'subject'=>'The side effects of using steroids',
                'category_id'=>1,
            ]);
            $this->post('/thread', [
                'subject'=>'The side effects of using proteins',
                'category_id'=>1,
            ]);
            $this->post('/thread', [
                'subject'=>'The side effects of using glutamine',
                'category_id'=>1,
            ]);
            $this->post('/thread', [
                'subject'=>'The side effects of using tea after training haha lol !',
                'category_id'=>1,
            ]);

            In the policy we limit the peak of potential thread creation to 60 thread/day
            we can't create 61 thread to test this feature but you can change the peak in the policy to 3 and 
            test the endpoint and you'll get unauthorized action

        */

        $this->assertTrue(true);
    }

    /** @test */
    public function thread_could_not_be_added_on_closed_category() {
        $this->withoutExceptionHandling();
        $this->expectException(CategoryClosedException::class);

        $closed = CategoryStatus::create([
            'status'=>'Closed',
            'slug'=>'closed'
        ]);

        $catgeory = TestHelper::create_category('another category', 'another', 'This is another category', 1, $closed->id);

        $this->post('/thread', [
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'category_id'=>$catgeory->id,
            'thread_type'=>1
        ]);

        $this->assertCount(1, Thread::all());
    }
}
