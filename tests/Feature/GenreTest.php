<?php

namespace Tests\Feature;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Функциональные тесты для GenreController.
 *
 * Проверяет:
 * - Получение списка жанров
 * - Обновление жанра модератором
 * - Ошибки доступа и авторизации при обновлении
 * - Поведение при несуществующем жанре
 */
class GenreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест получения списка жанров.
     *
     * @return void
     */
    public function testReturnsListOfGenres(): void
    {
        Genre::factory()->count(5)->create();

        $response = $this->getJson(route('genres.index'));

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    /**
     * Тест успешного обновления жанра модератором.
     *
     * @return void
     */
    public function testModeratorCanUpdateGenre(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR
        ]);
        $genre = Genre::factory()->create([
            'name' => 'Old Name',
        ]);

        $response = $this->actingAs($moderator)->patchJson(route('genres.update', $genre->id), [
            'name' => 'New Name',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    /**
     * Тест ошибки 401 при попытке обновить жанр без авторизации.
     *
     * @return void
     */
    public function testUpdateGenreUnauthenticated(): void
    {
        $genre = Genre::factory()->create();

        $response = $this->patchJson(route('genres.update', $genre->id), [
            'name' => 'Horror',
        ]);

        $response->assertUnauthorized()
            ->assertJson([
                'message' => 'Запрос требует аутентификации.',
            ]);
    }

    /**
     * Тест ошибки 403 при попытке обновить жанр обычным пользователем.
     *
     * @return void
     */
    public function testUpdateGenreAsUser(): void
    {
        $user = User::factory()->create();
        $genre = Genre::factory()->create();

        $response = $this->actingAs($user)->patchJson(route('genres.update', $genre->id), [
            'name' => 'Drama',
        ]);

        $response->assertForbidden();
    }

    /**
     * Тест ошибки 404 при обновлении несуществующего жанра.
     *
     * @return void
     */
    public function testUpdateGenreNotFound(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR
        ]);

        $response = $this->actingAs($moderator)->patchJson(route('genres.update', 999), [
            'name' => 'Comedy',
        ]);

        $response->assertNotFound()
            ->assertJson([
                'message' => 'Запрашиваемая страница не существует.',
            ]);
    }
}
