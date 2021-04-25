<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, Role, Category, SubCategory};
use Illuminate\Support\Facades\Auth;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function category_could_be_created() {
        $user = $this->create_user();
        $moderator_role = Role::create(['role'=>'moderator']);
        $user->roles()->attach($moderator_role, ['assigned_by'=>$user->id]);
        $this->actingAs($user);

        $this->post('/categories', [
            'category'=>'Body Building',
        ]);
        $this->assertCount(1, Category::all());
    }
    /** @test */
    public function only_moderator_could_create_catgeory() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user = $this->create_user();
        $moderator_role = Role::create(['role'=>'Normal User']);
        $user->roles()->attach($moderator_role, ['assigned_by'=>$user->id]);
        $this->actingAs($user);

        /**
         * Notice that the created_by field is filled with the current user
         */
        $this->post('/categories', [
            'category'=>'Body Building',
        ]);
    }
    /** @test */
    public function category_could_be_updated() {
        $user = $this->create_user();
        $normal_user_role = Role::create(['role'=>'Moderator']);
        $user->roles()->attach($normal_user_role, ["assigned_by"=>$user->id]);
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'FAQs',
            'created_by'=>1
        ]);

        $this->patch('/categories/'.$category->id, [
            'category'=>'Fitness FAQs'
        ]);
        $this->assertEquals('Fitness FAQs', Category::first()->category);
    }
    /** @test */
    public function only_moderator_could_update_a_category() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user = $this->create_user();
        $normal_user_role = Role::create(['role'=>'Normal User']);
        $user->roles()->attach($normal_user_role, ["assigned_by"=>$user->id]);
        $this->actingAs($user);
        /**
         * Notice we're loging in with a normal user and he can't create a category so an exception is thrown
         * when this user create a category
         */

        // First create a category (Notice we don't have to hit the endpoint because we need to do so in update part)
        $category = Category::create([
            'category'=>'FAQs',
            'created_by'=>1
        ]);
        $this->assertCount(1, Category::all());

        $this->patch('/categories/'.$category->id, [
            'category'=>'Fitness FAQs'
        ]);
    }
    /** @test */
    public function category_could_be_deleted() {
        $user = $this->create_user();
        $normal_user_role = Role::create(['role'=>'Moderator']);
        $user->roles()->attach($normal_user_role, ["assigned_by"=>$user->id]);
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'FAQs',
            'created_by'=>1
        ]);
        $this->assertCount(1, Category::all());

        $this->delete('/categories/'.$category->id);
        $this->assertCount(0, Category::all());
    }
    /** @test */
    public function only_moderator_could_delete_a_category() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user = $this->create_user();
        $normal_user_role = Role::create(['role'=>'Normal User']);
        $user->roles()->attach($normal_user_role, ["assigned_by"=>$user->id]);
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'FAQs',
            'created_by'=>1
        ]);

        $this->delete('/categories/'.$category->id);
    }

    private function create_user() {
        $faker = \Faker\Factory::create();
        $user = User::create([
            'name'=>$faker->name,
            'email'=>$faker->email,
            'password'=>$faker->password,
        ]);
        return $user;
    }
}
