<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{User, Thread, ForumStatus, CategoryStatus, ThreadStatus, PostStatus, ThreadType, Post, Vote};

class VoteTest extends TestCase
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

        TestHelper::create_forum('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        TestHelper::create_category('freestyle category', 'freestyle', 'This is freestyle category', 1, 1);
        
        Thread::create([
            'content'=>'This is the content',
            'subject'=>'The side effects of using steroids',
            'user_id'=>1,
            'category_id'=>1,
            'thread_type'=>1
        ]);

        Post::create([
            'content'=>"Hello guys, I'm confusing these days about something and I need help if you don't mind ?",
            'thread_id'=>1,
            'user_id'=>1
        ]);
    }

    /** @test */
    public function hitting_thread_vote_endpoint() {
        $thread = Thread::first();

        $this->assertCount(0, Vote::all());
        $this->post(route('thread.vote', ['thread'=>$thread->id]), [
            'vote'=>1
        ]);
        $this->assertCount(1, Vote::all());
    }

    /**
     * Here we need to check first if the user is already vote on this thread, then we decide if we add this vote or not
     * we have 3 cases here:
     *  1- the user is upvoted this thread, then press upvote button again; in this case we're gonna delete the vote
     *  2- the user is not voted at all, in this case we simply add it
     *  3- the user is upvoted  the thread, and then he decide to downvote it; in this case we need to delete the up
     *     vote and then add the down vote
     */

    /** @test */
    public function handle_first_case() {
        $thread = Thread::first();

        $this->assertCount(0, $thread->votes);
        $this->post(route('thread.vote', ['thread'=>$thread->id]), [
            'vote'=>1
        ]);
        $thread->load('votes');
        $this->assertCount(1, $thread->votes);
    }

    /** @test */
    public function handle_second_case() {
        $thread = Thread::first();

        $vote = new Vote;
        $vote->vote = 1;
        $vote->user_id = 1;

        $thread->votes()->save($vote);

        $this->assertCount(1, $thread->votes);
        $this->post(route('thread.vote', ['thread'=>$thread->id]), [
            'vote'=>1
        ]);
        $thread->load('votes');
        $this->assertCount(0, $thread->votes);
    }

    /** @test */
    public function handle_third_case() {
        $thread = Thread::first();

        $vote = new Vote;
        $vote->vote = 1;
        $vote->user_id = 1;

        $thread->votes()->save($vote);

        $this->assertCount(1, $thread->votes);
        $this->post(route('thread.vote', ['thread'=>$thread->id]), [
            'vote'=>-1
        ]);
        $thread->load('votes');
        $this->assertCount(1, $thread->votes);
        $this->assertEquals(-1, $thread->votes->first()->vote);
    }

    /** @test */
    public function handle_three_cases_on_post_table() {
        $post = Post::first();

        // First case
        $this->assertCount(0, $post->votes);
        $this->post(route('post.vote', ['post'=>$post->id]), [
            'vote'=>1
        ]);
        $post->load('votes');
        $this->assertCount(1, $post->votes);

        // Second case
        $this->post(route('post.vote', ['post'=>$post->id]), [
            'vote'=>1
        ]);
        $post->load('votes');
        $this->assertCount(0, $post->votes);

        // Third case
        $this->post(route('post.vote', ['post'=>$post->id]), [
            'vote'=>-1
        ]);
        $this->post(route('post.vote', ['post'=>$post->id]), [
            'vote'=>1
        ]);
        $post->load('votes');
        $this->assertCount(1, $post->votes);
    }

    /** @test */
    public function when_a_post_deleted_all_related_votes_get_deleted_as_well() {
        $post = Post::first();
        
        $vote = new Vote;
        $vote->vote = '1';
        $vote->user_id = 1;
        $vote->votable_id = $post->id;
        $vote->votable_type = 'App\Models\Post';
        
        $this->assertCount(0, $post->votes);
        $post->votes()->save($vote);
        $post->load('votes');
        $this->assertCount(1, $post->votes);

        $this->delete('/post/'.$post->id);

        $post->load('votes');
        $this->assertCount(0, $post->votes);
    }

    /** @test */
    public function when_a_thread_deleted_all_related_votes_get_deleted_as_well() {
        $thread = Thread::first();
        
        $vote = new Vote;
        $vote->vote = '1';
        $vote->user_id = 1;
        $vote->votable_id = $thread->id;
        $vote->votable_type = 'App\Models\Thread';

        $this->assertCount(0, $thread->votes);
        $thread->votes()->save($vote);
        $thread->load('votes');
        $this->assertCount(1, $thread->votes);
        $this->delete('/thread/'.$thread->id.'/force');
        $thread->load('votes');
        $this->assertCount(0, $thread->votes);
        

    }

}
