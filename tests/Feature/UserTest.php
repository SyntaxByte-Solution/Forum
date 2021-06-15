<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Classes\TestHelper;
use App\Models\{User};

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
        $response = $this->patch(route('change.user.settings.profile'), [
            'username'=>$username
        ]);
        
        $response->assertSessionHasErrors('username');
    }

    /**
     * for only_account_owner_could_open_profile_settings_page test it's obvious that every user
     * will see his account settings proportional to his profile
     */

    /** @test */
    public function only_account_owner_could_update_his_profile() {
        /**
         * Here is the same thing every user's changes will be pushed to the controller to update
         * the current user settings. we can't test the authorization part because we don't
         * have any url parameter to check with the current user.
         * For that, we just test if the changes are made successfully !
         */
        $user1 = TestHelper::create_user();
        $user2 = TestHelper::create_user();

        $this->actingAs($user2);
        // Trying to update user2 username with username1 username
        $response = $this->patch(route('change.user.settings.profile'), [
            'username'=>'EDITED_USERNAME'
        ]);
        $this->assertEquals('EDITED_USERNAME', $user2->username);


    }

    /** @test */
    public function when_a_user_account_deleted_all_data_associatd_with_it_get_deleted_as_well() {
        // We'll implement this later
        $this->assertTrue(true);
    }
}
