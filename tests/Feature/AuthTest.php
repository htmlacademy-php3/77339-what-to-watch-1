<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRegister()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role',
                ]
            ],
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function testUserCanLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role',
                ]
            ],
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function testUserCannotLoginWithInvalidCredentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(401);
        $response->assertJsonStructure([
            'success',
            'error' => [
                'message',
                'code'
            ],
            'timestamp'
        ]);
        $response->assertJson([
            'success' => false
        ]);
    }

    public function testUserCannotRegisterWithExistingEmail()
    {
        $existingUser = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422);
    }

    public function testUserCannotRegisterWithoutPasswordConfirmation()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422);
    }

    public function testUserCanLogout()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function testUserCanViewProfile()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->getJson('/api/user');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function testUserCanUpdateProfile()
    {
        $user = User::factory()->create();
        
        $updateData = [
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($user)->patchJson('/api/user', $updateData);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data',
            'timestamp'
        ]);
        $response->assertJson([
            'success' => true
        ]);
    }

    public function testRegistrationRequiresValidEmail()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422);
    }

    public function testRegistrationRequiresMinimumPasswordLength()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(422);
    }
} 