<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test creating a new order.
     *
     * @return void
     */
    public function test_models_can_be_created()
    {
        // Run the DatabaseSeeder...
        $this->seed();
    }
    public function test_users_tables_count()
    {
        $this->assertDatabaseCount('users', 5);
    }
}
