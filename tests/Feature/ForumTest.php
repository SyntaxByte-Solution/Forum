<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Exceptions\UnauthorizedActionException;
use App\Models\{Forum, ForumStatus};
use App\Classes\TestHelper;

class ForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function only_admins_could_create_forums() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user_with_role('admin', 'admin');
        $this->actingAs($user);

        ForumStatus::create([
            'status'=>'TEMPORARILTY CLOSED',
            'slug'=>'temp.closed'
        ]);

        $this->post('/forums', [
            'forum'=>'Calisthenics Workout',
            'slug'=>'calisthenics',
            'description'=>'This section is for calisthenics athletes only.',
            'status'=>1,
        ]);

        $this->assertCount(1, Forum::all());

        $user = TestHelper::create_user_with_role('moderator', 'moderator');
        $this->actingAs($user);

        $this->post('/forums', [
            'forum'=>'BodyBuilding',
            'slug'=>'bodybuilding',
            'description'=>'This section is for bb athletes only.',
            'status'=>1,
        ]);
    }

    /** @test */
    public function only_admins_could_update_forums_informations() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user_with_role('admin', 'admin');
        $this->actingAs($user);

        ForumStatus::create([
            'status'=>'TEMPORARILTY CLOSED',
            'slug'=>'temp.closed'
        ]);
        $forum = TestHelper::create_forum('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        
        $this->patch('/forums/'.$forum->id, [
            'description'=>'This section is for bb athletes only.',
            'status'=>1,
        ]);
        
        $this->assertEquals('This section is for bb athletes only.', $forum->refresh()->description);

        $user = TestHelper::create_user_with_role('moderator', 'moderator');
        $this->actingAs($user);

        $this->patch('/forums/'.$forum->id, [
            'forum'=>'PR',
            'slug'=>'pr',
            'description'=>'This section is for bb athletes only.',
            'status'=>1,
        ]);
    }

    /** @test */
    public function only_admin_could_delete_forums() {
        $this->withoutExceptionHandling();
        $this->expectException(UnauthorizedActionException::class);

        $user = TestHelper::create_user_with_role('admin', 'admin');
        $this->actingAs($user);

        ForumStatus::create([
            'status'=>'TEMPORARILTY CLOSED',
            'slug'=>'temp.closed'
        ]);
        $forum = TestHelper::create_forum('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        
        $this->assertCount(1, Forum::all());
        $this->delete('/forums/'.$forum->id);
        $this->assertCount(0, Forum::all());
        
        $forum = TestHelper::create_forum('Calisthenics Workout', 'calisthenics', 'This section is for calisthenics athletes only.', 1);
        $user = TestHelper::create_user();

        $this->actingAs($user);
        $this->delete('/forums/'.$forum->id);
    }
}
