<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User, Role, Category};

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_category_can_be_created() {
        // Moderator
        $moderator = $this->create_fake_user();
        $moderator->save();

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

    public function only_moderator_could_create_categories() {
        $this->expectException(\Exception::class);
        $user = $this->create_fake_user();
        $user->save();

        // Create a moderator role
        $role = Role::create([
            'role'=>'Normal User'
        ]);
        
        $user->roles()->attach($role, ['assigned_by'=>$user->id]);

        $response = $this->post('/category', [
            'category'=>'Body building',
            'created_by'=>$user->id
        ]);
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
