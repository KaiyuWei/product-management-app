<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->truncateUsersTable();
    }

    protected function truncateUsersTable()
    {
        DB::table('users')->truncate();
    }

    public function test_user_registration_with_valid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Kai Wei',
            'email' => 'kai.wei@example.com',
            'role' => 'supplier',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => ['id' => 1],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'kai.wei@example.com',
            'name' => 'Kai Wei',
            'role' => 'supplier',
        ]);
    }

    /**
     * Test user registration with invalid data.
     *
     * @return void
     */
    public function test_user_registration_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'not-an-email',
            'role' => 'dummy',
            'password' => 's',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'role', 'password']);
    }

    /**
     * Test user registration with missing data.
     *
     * @return void
     */
    public function test_user_registration_with_missing_data()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'role', 'password']);
    }
}
