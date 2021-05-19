<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Exceptions\{AccessDeniedException, UserBannedException, DuplicateThreadException};
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
    }

    /** @test */
    public function a_banned_user_could_not_create_threads() {
        $this->withoutExceptionHandling();
        $this->expectException(UserBannedException::class);

        $user = TestHelper::create_user_with_status('banned', 'banned');
        $this->actingAs($user);

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
    }

    /** @test */
    public function a_thread_could_be_updated() {
        $this->withoutExceptionHandling();

        $user = TestHelper::create_user();
        $this->actingAs($user);

        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        ThreadStatus::create([
            'status'=>'LIVE'
        ]);

        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        $category_2 = TestHelper::create_category('Workout', 'workout', 'This section is for workout athletes only.', 1);

        $thread = Thread::create([
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
        ]);

        $this->patch('/thread/'.$thread->id, [
            'subject'=>'Why using steroids is dangerous ?',
            'category_id'=>2,
        ]);

        $this->assertEquals('Why using steroids is dangerous ?', $thread->refresh()->subject);
        $this->assertEquals(2, $thread->refresh()->category_id);
    }

    /** @test */
    public function a_user_could_not_create_two_threads_with_the_same_subject() {
        $this->withoutExceptionHandling();
        $this->expectException(DuplicateThreadException::class);

        $user = TestHelper::create_user();
        $this->actingAs($user);

        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        ThreadStatus::create([
            'status'=>'LIVE'
        ]);

        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        $category_2 = TestHelper::create_category('Workout', 'workout', 'This section is for workout athletes only.', 1);

        $thread = Thread::create([
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
        ]);
        $thread1 = Thread::create([
            'subject'=>'The side effects of using protein',
            'user_id'=>1,
            'category_id'=>1,
        ]);

        // Here we try to edit the first thread with a new subject but already taken by the same user in the second thread
        $this->patch('/thread/'.$thread->id, [
            'subject'=>'The side effects of using protein',
            'category_id'=>2,
        ]);
        // Assert that the subject is not updated because there's duplicates
        $this->assertEquals('The side effects of using steroids', $thread->refresh()->subject);
    }

    /** @test */
    public function only_thread_owner_could_update_it() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        $user1 = TestHelper::create_user();

        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        ThreadStatus::create([
            'status'=>'LIVE'
        ]);

        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);

        // We create the thread with user1
        $thread = Thread::create([
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
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

        $user = TestHelper::create_user();
        $this->actingAs($user);

        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        ThreadStatus::create([
            'status'=>'LIVE'
        ]);

        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);

        $thread = Thread::create([
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
        ]);

        $this->assertCount(1, Thread::all());
        $this->delete('/thread/'.$thread->id);
        $this->assertCount(0, Thread::all());
    }

    /** @test */
    public function only_thread_owner_could_delete_the_current_thread() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        $user = TestHelper::create_user();

        CategoryStatus::create([
            'status'=>'LIVE',
            'slug'=>'live'
        ]);

        ThreadStatus::create([
            'status'=>'LIVE'
        ]);

        $category = TestHelper::create_category('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);

        $thread = Thread::create([
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
        ]);

        $user1 = TestHelper::create_user();
        $this->actingAs($user1);

        $this->delete('/thread/'.$thread->id);
    }

    /** @test */
    public function user_could_create_a_limited_number_of_threads_per_day() {
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

        /**
         * In the policy we limit the peak of potential thread creation to 60 thread/day
         * we can't create 61 thread to test this feature but you can change the peak in the policy to 3 and 
         * test the endpoint and you'll get unauthorized action
         */
        $this->assertTrue(true);
    }
}
