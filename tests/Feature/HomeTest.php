<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_sees_home_page(): void
    {
        $user = $this->adminUser();
        $this->actingAs($user)->get('/')->assertStatus(200);
    }

    public function test_unauthenticated_user_is_redirected_from_home(): void
    {
        $this->get('/')->assertRedirect('/login');
    }
}
