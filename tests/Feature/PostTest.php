<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Exceptions\AccessDeniedException;
use App\Models\{Role, User};
use App\Classes\TestHelper;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function post_could_be_created() {
        $user = TestHelper::create_user();

        $this->actingAs($user);

        $this->assertTrue(true);
    }

}
