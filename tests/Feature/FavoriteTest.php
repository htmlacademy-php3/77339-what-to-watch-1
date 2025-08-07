<?php

namespace Tests\Feature;

use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    use RefreshDatabase;

    /**
     * Пользователь может добавить фильм в избранное.
     */
    public function testUserCanAddFilmToFavorites(): void
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/films/{$film->id}/favorite");

        $response->assertStatus(201)
            ->assertJsonFragment(['message' => 'Фильм успешно добавлен в избранное!']);

        $this->assertDatabaseHas('favorite_films', [
            'user_id' => $user->id,
            'film_id' => $film->id,
        ]);
    }

    /**
     * Пользователь может получить список избранных фильмов.
     */
    public function testUserCanGetTheirFavoriteFilmsList(): void
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $user->favoriteFilms()->attach($film->id);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/favorite');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [[
                'id',
                'name',
                'poster_image',
                'preview_image',
                'preview_video_link',
                'genre',
                'released'
            ]]]);
    }

    /**
     * Пользователь может удалить фильм из избранного.
     */
    public function testUserCanRemoveFilmFromFavorites(): void
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $user->favoriteFilms()->attach($film->id);

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/films/{$film->id}/favorite");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Фильм удален из избранного']);

        $this->assertDatabaseMissing('favorite_films', [
            'user_id' => $user->id,
            'film_id' => $film->id,
        ]);
    }

    /**
     * Нельзя добавить фильм в избранное дважды.
     */
    public function testUserCannotAddDuplicateFilmToFavorites(): void
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $user->favoriteFilms()->attach($film->id);

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/films/{$film->id}/favorite");

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Фильм уже в избранном']);
    }

    /**
     * Нельзя добавить несуществующий фильм.
     */
    public function testUserCannotAddNonexistentFilmToFavorites(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson("/api/films/9999/favorite");

        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Фильм не найден']);
    }
}
