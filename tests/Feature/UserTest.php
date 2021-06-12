<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{User, Thread, ForumStatus, CategoryStatus, ThreadStatus, ThreadType, Post};

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function username_is_unique() {
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'username'=>'grotto',
            'email'=>'grotto@gmail.com',
        ]);

        $response = User::create([
            'username'=>'grotto',
            'email'=>'istable@fgh.com',
        ]);

        $response->assertSessionHasErrors('username');
    }

    /** @test */
    public function updated_username_must_be_unique() {
        /**
         * Notice that here we expect an exception which is validation exception, 
         * but in testing username in creation we expect query exception. That's because in creation,
         *  use create eloquent helper which create and store user directly, but in creation we create 
         * the user and directly send it to database taht's why we get query exception
         */

        $user1 = TestHelper::create_user();
        $user2 = TestHelper::create_user();

        $username = $user1->username;

        $this->actingAs($user2);
        // Trying to update user2 username with username1 username
        $response = $this->patch('/users/' . $user2->username . '/settings/profile', [
            'username'=>$username
        ]);
        
        $response->assertSessionHasErrors('username');
    }

    /** @test */
    public function only_account_owner_could_open_profile_settings_page() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        $user1 = TestHelper::create_user();
        $user2 = TestHelper::create_user();

        $this->actingAs($user2);
        // Trying to update user2 username with username1 username
        $response = $this->get('/users/' . $user1->username . '/settings');
    }

    /** @test */
    public function only_account_owner_could_update_his_profile() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Auth\Access\AuthorizationException::class);

        $user1 = TestHelper::create_user();
        $user2 = TestHelper::create_user();

        $this->actingAs($user2);
        // Trying to update user2 username with username1 username
        $response = $this->patch('/users/' . $user1->username . '/settings/profile', [
            'username'=>'EDITED_USERNAME'
        ]);
    }

    /** @test */
    public function when_a_user_account_deleted_all_data_associatd_with_it_get_deleted_as_well() {

    }
}
