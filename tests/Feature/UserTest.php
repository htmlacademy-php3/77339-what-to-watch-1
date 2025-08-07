<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Функциональные тесты для профиля пользователя.
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест возвращает данные текущего пользователя.
     */
    public function testUserCanViewOwnProfile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('user.self.account'));

        $response->assertOk()
            ->assertJsonStructure([
                'data',
            ]);
    }

    /**
     * Тест обновления профиля пользователя.
     */
    public function testUserCanUpdateProfile(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'New Name',
        ];

        $response = $this->actingAs($user)->patchJson(route('user.account.update'), $payload);

        $response->assertOk()
            ->assertJsonStructure([
                'data',
            ]);
    }

    /**
     * Гость не может просматривать профиль.
     */
    public function testGuestCannotViewProfile(): void
    {
        $response = $this->getJson(route('user.self.account'));

        $response->assertUnauthorized();
    }

    /**
     * Гость не может обновить профиль.
     */
    public function testGuestCannotUpdateProfile(): void
    {
        $response = $this->patchJson(route('user.account.update'), [
            'name' => 'Attempted Name',
        ]);

        $response->assertUnauthorized();
    }
}
