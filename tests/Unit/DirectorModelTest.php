<?php

namespace Tests\Unit;

use App\Models\Director;
use App\Models\Film;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Модельные (юнит) тесты для модели Director.
 *
 * @package Tests\Unit
 */
class DirectorModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет fillable-поля модели.
     */
    public function testFillableFields(): void
    {
        $director = new Director();
        $this->assertEquals(['name'], $director->getFillable());
    }

    /**
     * Проверяет создание режиссера.
     */
    public function testDirectorCreation(): void
    {
        $director = Director::create(['name' => 'Кристофер Нолан']);

        $this->assertDatabaseHas('directors', [
            'id' => $director->id,
            'name' => 'Кристофер Нолан'
        ]);
    }

    /**
     * Проверяет отношение с фильмами.
     */
    public function testFilmsRelationship(): void
    {
        $director = Director::factory()->create();
        $film = Film::factory()->create();

        $director->films()->attach($film);

        $this->assertInstanceOf(Collection::class, $director->films);
        $this->assertCount(1, $director->films);
        $this->assertEquals($film->id, $director->films->first()->id);
    }

    /**
     * Проверяет счетчик фильмов.
     */
    public function testFilmsCountAttribute(): void
    {
        $director = Director::factory()
            ->has(Film::factory()->count(3))
            ->create();

        $director->loadCount('films');

        $this->assertEquals(3, $director->films_count);
    }

    /**
     * Проверяет имя режиссера.
     */
    public function testNameAttribute(): void
    {
        $director = Director::create(['name' => 'Квентин Тарантино']);
        $this->assertEquals('Квентин Тарантино', $director->name);
    }
}
