<?php

namespace Tests\Unit;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Модельные (юнит) тесты для модели Genre.
 *
 * @package Tests\Unit
 */
class GenreModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет fillable-поля модели.
     */
    public function testFillableFields(): void
    {
        $genre = new Genre();
        $this->assertEquals(['name'], $genre->getFillable());
    }

    /**
     * Проверяет создание жанра.
     */
    public function testGenreCreation(): void
    {
        $genre = Genre::create(['name' => 'Фантастика']);

        $this->assertDatabaseHas('genres', [
            'id' => $genre->id,
            'name' => 'Фантастика'
        ]);
    }

    /**
     * Проверяет отношение с фильмами.
     */
    public function testFilmsRelationship(): void
    {
        $genre = Genre::factory()->create();
        $film = Film::factory()->create();

        $genre->films()->attach($film);

        $this->assertInstanceOf(Collection::class, $genre->films);
        $this->assertCount(1, $genre->films);
        $this->assertEquals($film->id, $genre->films->first()->id);
    }

    /**
     * Проверяет счетчик фильмов.
     */
    public function testFilmsCountAttribute(): void
    {
        $genre = Genre::factory()
            ->has(Film::factory()->count(3))
            ->create();

        $genre->loadCount('films');
        $this->assertEquals(3, $genre->films_count);
    }

    /**
     * Проверяет название жанра.
     */
    public function testNameAttribute(): void
    {
        $genre = Genre::create(['name' => 'Драма']);
        $this->assertEquals('Драма', $genre->name);
    }

    /**
     * Проверяет таблицу модели.
     */
    public function testTableName(): void
    {
        $genre = new Genre();
        $this->assertEquals('genres', $genre->getTable());
    }
}
