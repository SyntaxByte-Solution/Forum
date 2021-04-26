<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, Role, Category, SubCategory};

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function category_could_be_created() {
        $user = $this->create_user();
        $this->assign_role($user, 'moderator');
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
        $this->assign_role($user, 'Normal User');
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
        $this->assign_role($user, 'moderator');
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
        $this->assign_role($user, 'Normal User');
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
        $this->assign_role($user, 'moderator');
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
        $this->assign_role($user, 'Normal User');
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'FAQs',
            'created_by'=>1
        ]);

        $this->delete('/categories/'.$category->id);
    }

    // ---------------------- SUB-CATEGORIES ----------------------

    /** @test */
    public function a_subcategory_could_be_created() {
        $user = $this->create_user();
        $this->assign_role($user, 'moderator');
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'Body building',
            'created_by'=>1
        ]);

        $this->post('/subcategories', [
            'subcategory'=>'street workout',
            'created_by'=>$user->id,
            'category_id'=>$category->id,
        ]);

        $this->assertCount(1, SubCategory::all());
    }
    /** @test */
    public function only_moderators_could_add_subcategories() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user = $this->create_user();
        $this->assign_role($user, 'normal user');
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'Body building',
            'created_by'=>1
        ]);

        $this->post('/subcategories', [
            'subcategory'=>'street workout',
            'created_by'=>$user->id,
            'category_id'=>$category->id,
        ]);
    }
    /** @test */
    public function a_subcategory_could_be_updated() {
        $user = $this->create_user();
        $this->assign_role($user, 'moderator');
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'Body building',
            'created_by'=>1
        ]);

        $this->post('/subcategories', [
            'subcategory'=>'street workout',
            'created_by'=>$user->id,
            'category_id'=>$category->id,
        ]);

        $subcategory = SubCategory::first();
        
        $this->patch('/subcategories/'.$subcategory->id, [
            'subcategory'=>'gym workout',
            'created_by'=>$user->id,
            'category_id'=>$category->id,
        ]);
        $this->assertEquals('gym workout', $subcategory->fresh()->subcategory);
    }
    /** @test */
    public function only_moderators_could_update_subcategories() {
        $this->withoutExceptionHandling();
        $this->expectException(\Exception::class);

        $user = $this->create_user();
        $this->assign_role($user, 'normal user');
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'Body building',
            'created_by'=>1
        ]);

        $this->post('/subcategories', [
            'subcategory'=>'street workout',
            'created_by'=>$user->id,
            'category_id'=>$category->id,
        ]);

        $subcategory = SubCategory::first();
        
        $this->patch('/subcategories/'.$subcategory->id, [
            'subcategory'=>'gym workout',
            'created_by'=>$user->id,
            'category_id'=>$category->id,
        ]);
    }
    /** @test */
    public function a_subcategory_could_be_deleted() {
        $this->withoutExceptionHandling();

        $user = $this->create_user();
        $this->assign_role($user, 'moderator');
        $this->actingAs($user);

        $category = Category::create([
            'category'=>'FAQs',
            'created_by'=>1
        ]);

        $this->post('/subcategories', [
            'subcategory'=>'street workout',
            'created_by'=>$user->id,
            'category_id'=>$category->id,
        ]);

        $subcategory = SubCategory::first();

        $this->assertCount(1, SubCategory::all());
        $this->delete('/subcategories/'.$subcategory->id);
        $this->assertCount(0, SubCategory::all());
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
    private function assign_role($user, $role) {
        /**
         * Notice that the user who assign the moderator role to the passed user is that passed user itself
         * but in reality it should be another moderator
         */
        $moderator_role = Role::create(['role'=>$role]);
        $user->roles()->attach($moderator_role, ['assigned_by'=>$user->id]);
    }
}
