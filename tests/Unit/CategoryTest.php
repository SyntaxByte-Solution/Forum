<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Category, Role};

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_category_column_is_required() {
        $this->withoutExceptionHandling();
        $this->expectException(\Illuminate\Database\QueryException::class);

        $user = $this->create_user();
        $moderator_role = Role::create(['role'=>'moderator']);
        $user->roles()->attach($moderator_role, ['assigned_by'=>$user->id]);

        $category = Category::create([
            'created_by'=>$user->id
        ]);
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
