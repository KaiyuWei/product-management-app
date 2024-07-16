<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_registration_with_valid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Kai Wei',
            'email' => 'kai.wei@example.com',
            'password' => 'password123',
            'role' => 'supplier'
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'id' => 1,
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'kai.wei@example.com',
            'name' => 'Kai Wei',
        ]);

        $this->assertDatabaseHas('suppliers', [
            'user_id' => 1
        ]);
    }

    public function test_user_registration_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 's',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'role', 'email', 'password']);
    }

    public function test_user_registration_with_missing_data()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'role', 'email', 'password']);
    }

    public function test_login_with_valid_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'token' => true
                ]
            ]);

        $this->assertArrayHasKey('token', $response->json('data'));
    }

    public function test_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 'failed',
                'errorMessage' => true
            ]);
    }

    public function test_login_with_non_existent_user()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'status' => 'failed',
                'errorMessage' => true
            ]);
    }

    public function test_login_with_invalid_data()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'invalid+email',
            'password' => ''
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }
}
