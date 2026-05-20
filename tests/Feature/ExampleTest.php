<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\AdminModuleSeeder;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed(AdminModuleSeeder::class);
    
        $user = \App\Models\User::where('email', 'admin@proyectoafe.com')->first();
    
        $response = $this->actingAs($user)->get('/');
    
        $response->assertStatus(200);
    }
}