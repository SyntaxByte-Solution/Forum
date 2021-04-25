<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{User, Category};

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_category_can_be_deleted() {
        $user = $this->create_fake_user();
        $user->save();

        Category::create([
            'category'=>'Foo',
            'created_by'=>1
        ]);

        $this->assertCount(1, Category::all());
        
        $category = Category::first();
        $category->delete();
        
        $this->assertCount(0, Category::all());
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
