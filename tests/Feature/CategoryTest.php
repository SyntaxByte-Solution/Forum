<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, Role, Category};
use Illuminate\Support\Facades\Auth;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_category_can_be_created() {
        // Moderator
        $moderator = $this->create_fake_user();
        $moderator->save();
        $this->assertCount(1, User::all());

        // Create a moderator role
        $moderator_role = Role::create([
            'role'=>'Moderator'
        ]);
        
        /**
         * Attach a normal user and add assigned by to specify who give this normal user theis role 
         * Notice that the assigned_by user MUST be a moderator and that will be covered in the next test
         * Notice here the user who assign moderator moderator role to that new user is not a moderator bit IT MUST be a moderator as well
         * but for now let's keep it as it is because we only need to know that the final user if a moderator
         */
        $moderator->roles()->attach($moderator_role, ['assigned_by'=>$moderator->id]);

        $response = $this->post('/category', [
            'category'=>'Body building',
            'created_by'=>$moderator->id
        ]);

        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function only_moderator_could_create_categories() {
        /**
         * IMPORTANT: When you expect an exception to be thrown from your controller, you must
         * disable exception handling in order to catch the exception by expectException assertion
         */
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user = $this->create_fake_user();
        $user->save();
        
        // Create a moderator role
        $role = Role::create([
            'role'=>'Normal User'
        ]);
        $this->assertCount(1, Role::all());
        
        $user->roles()->attach($role, ['assigned_by'=>$user->id]);

        $response = $this->post('/category', [
            'category'=>'Body building',
            'created_by'=>$user->id
        ]);
    }

    /** @test */
    public function only_moderators_could_update_categories() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        /**
         * Here we temporarily create a moderator to allow the category to be created
         * because our aim in this test is to make sure of update feature that generate 
         * an exception when the user who want to update it is a normal user
         * Hint: we create a fresh user after that to test update
         * Hint: Notice we can detach the roles from the user and then assign normal user role to him again
         * But this will fail because when we tend to assign role to a user this user should be a moderator :(
         */
        $user = $this->create_fake_user();
        $user->save();

        // Create a moderator role
        $role = Role::create([
            'role'=>'Moderator'
        ]);

        $user->roles()->attach($role, ['assigned_by'=>$user->id]);

        // First create a category
        $this->post('/category', [
            'category'=>'Body building',
            'created_by'=>$user->id
        ]);
        $this->assertCount(1, Category::all());

        $normal_user = $this->create_fake_user();
        $normal_user->save();
        
        // Create a moderator role
        $role = Role::create([
            'role'=>'Normal User'
        ]);

        $normal_user->roles()->attach($role, ['assigned_by'=>$user->id]);

        $this->actingAs($normal_user);

        // Fetch it
        $category = Category::first();

        // Then update it
        $this->patch('/category/'. $category->id, [
            'category'=>'Calisthenics',
            'created_by'=>$normal_user->id
        ]);
    }

    /** 
     * @test 
    */
    public function only_moderators_can_delete_a_category() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user = $this->create_fake_user();
        $user->save();

        $role = Role::create([
            'role'=>'Moderator'
        ]);
        $user->roles()->attach($role, ['assigned_by'=>$user->id]);

        $this->post('/category', [
            'category'=>'Body building',
            'created_by'=>$user->id
        ]);

        $normal_user = $this->create_fake_user();
        $normal_user->save();

        $role = Role::create([
            'role'=>'Normal User'
        ]);
        $normal_user->roles()->attach($role, ['assigned_by'=>$user->id]);
        $this->actingAs($normal_user);

        $category = Category::first();

        $this->delete('/category/'. $category->id);

        $this->assertCount(1, Category::all());

    }


    private function create_fake_user() {
        $faker = \Faker\Factory::create();

        return new User([
            'name'=>$faker->name,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);
    }
}
