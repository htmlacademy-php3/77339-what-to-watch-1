<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест успешного входа с корректными данными.
     * Ожидается статус 200 и наличие токена в ответе.
     */
    public function testUserCanLoginWithCorrectCredentials(): void
    {
        User::factory()->create([
            'email' => 'test@example.ru',
            'password' => Hash::make('password'),
        ]);

        $response =
            $this->postJson(route('user.login'), [
                'email' => 'test@example.ru',
                'password' => 'password',
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'token',
            ]
        ]);
    }

    /**
     * Тест неудачного входа с неверным паролем.
     * Ожидается статус 401 Unauthorized.
     */
    public function testUserCannotLoginWithWrongPassword(): void
    {
        User::factory()->create([
            'email' => 'test@example.ru',
            'password' => Hash::make('password'),
        ]);

        $response =
            $this->postJson(route('user.login'), [
                'email' => 'test@example.ru',
                'password' => 'wrongPassword',
            ]);

        $response->assertStatus(401);
    }
}

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест выхода из системы аутентифицированного пользователя.
     * Ожидается статус 204 No Content.
     */
    public function testAuthenticatedUserCanLogout(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson(route('user.logout'));
        $response->assertStatus(204);
    }
}

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Тест успешной регистрации пользователя.
     * Ожидается статус 201 и наличие пользователя в БД.
     */
    public function testUserCanRegisterSuccessfully(): void
    {
        $response =
            $this->postJson(route('user.register'), [
                'name' => 'Test User',
                'email' => 'test@example.ru',
                'password' => 'Password!2',
                'password_confirmation' => 'Password!2',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => 'test@example.ru']);
    }
}
