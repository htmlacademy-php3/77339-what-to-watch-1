<?php

namespace Tests\Feature\Films;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Resources\FilmResource;
use App\Models\Film;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тестирование обработки случая, когда фильм не найден.
     *
     * @return void
     */
    
    public function testReturns404WhenFilmNotFound(): void
    {
        $response = $this->getJson(route('films.show', ['id' => 999]));

        $response->assertNotFound()
        ->assertJson([
            'message' => 'Запрашиваемая страница не существует.',
        ]);
    }

    /**
     * Тест успешного добавления фильма модератором.
     * 
     * @return void
     */

    public function testStoreFilm(): void
    {
        $moderator =
            User::factory()->create([
                'role' => User::ROLE_MODERATOR,
            ]);

        $response =
            $this->actingAs($moderator)->postJson(route('films.store'), [
                'imdb_id' => 'tt1234567',
            ]);

        $response->assertCreated()->assertJsonStructure([
                'data' => [
                    "id",
                    "name",
                    "poster_image",
                    "preview_image",
                    "background_image",
                    "background_color",
                    "video_link",
                    "preview_video_link",
                    "description",
                    "rating",
                    "scores_count",
                    "director",
                    "starring",
                    "run_time",
                    "genre",
                    "released",
                    "is_favorite",
                    "is_promo",
                ]
            ]);
    }

    /**
     * Тест ошибки 403 при попытке добавить фильм обычным пользователем.
     * 
     * @return void
     */

    public function testStoreFilmAsUser(): void
    {
        $user =
            User::factory()->create();

        $response =
            $this->actingAs($user)->postJson(route('films.store'), [
                'imdb_id' => 'tt1234567',
            ]);

        $response->assertForbidden();
    }

    /**
     * Тестирование получения детальной информации о фильме.
     * 
     * @return void
     */

    public function testReturnsFilmDetails(): void
    {
        $film = Film::factory()->create();

        $response = $this->getJson(route('films.show', $film->id));

        $response->assertOk()
            ->assertJson([
                'data' => new FilmResource($film)->response()->getData(true)['data'],
            ]);
    }

    /**
     * Тестирование получения списка фильмов с пагинацией.
     * 
     * @return void
     */

    public function testReturnsPaginatedFilmList(): void
    {
        Film::factory()->count(20)->create();

        $response = $this->getJson(route('films.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'poster_image',
                        'preview_image',
                        'preview_video_link',
                        'genre',
                        'released'
                    ]
                ]
            ])
            ->assertJsonCount(8, 'data');
    }

    /**
     * Тест успешного обновления фильма модератором.
     *
     * @return void
     */
    
    public function testUpdateFilm(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
        ]);
        $film = Film::factory()->create();

        $response = $this->actingAs($moderator)->patchJson(route('films.update', $film->id), [
            'name' => 'Updated Title',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    /**
     * Тест ошибки 401 при попытке обновить фильм без авторизации.
     * 
     * @return void
     */

    public function testUpdateFilmUnauthenticated(): void
    {
        $film = Film::factory()->create();

        $response = $this->patchJson(route('films.update', $film->id), [
            'name' => 'No Access',
        ]);

        $response->assertUnauthorized();
    }

    /**
     * Тест ошибки 403 при попытке обновить фильм обычным пользователем.
     * 
     * @return void
     */

    public function testUpdateFilmAsUser(): void
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $response = $this->actingAs($user)->patchJson(route('films.update', $film->id), [
            'name' => 'Forbidden',
        ]);

        $response->assertForbidden();
    }

    /**
     * Тест получения текущего промо-фильма.
     *
     * @return void
     */

    public function testShowPromo(): void
    {
        $promoFilm = Film::factory()->create(['is_promo' => true]);
        $response = $this->getJson(route('promo.show'));

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $promoFilm->id,
                    'is_promo' => true
                ]
            ]);
    }

    /**
     * Тест создания промо-фильма модератором.
     *
     * @return void
     */

    public function testCreatePromo(): void
    {
        $moderator = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
        ]);
        $film = Film::factory()->create();

        $response = $this->actingAs($moderator)->postJson(route('promo.create', $film->id));

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }

    /**
     * Тест ошибки 403 при попытке создать промо-фильм обычным пользователем.
     * 
     * @return void
     */

    public function testCreatePromoAsUser(): void
    {
        $user = User::factory()->create();
        $film = Film::factory()->create();

        $response = $this->actingAs($user)->postJson(route('promo.create', $film->id));

        $response->assertForbidden();
    }

    /**
     * Тест ошибки 401 при попытке создать промо-фильм без авторизации.
     * 
     * @return void
     */

    public function testCreatePromoUnauthenticated(): void
    {
        $film = Film::factory()->create();

        $response = $this->postJson(route('promo.create', $film->id));

        $response->assertUnauthorized();
    }

    /**
     * Тест получения списка похожих фильмов.
     *
     * @return void
     */

    public function testSimilarFilms(): void
    {
        $film = Film::factory()->create();

        $response = $this->getJson(route('films.similar', $film->id));

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }
}
