<?php

namespace Tests\Unit;

use App\Models\Actor;
use App\Models\Film;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


/**
 * Модельные (юнит) тесты для модели Actor.
 *
 * @package Tests\Unit
 */
class ActorModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет fillable-поля модели.
     */
    public function test_fillable_fields(): void
    {
        $actor = new Actor();
        $this->assertEquals(['name'], $actor->getFillable());
    }

    /**
     * Проверяет, что актёра можно создать.
     */
    public function test_actor_can_be_created(): void
    {
        $actor = Actor::create(['name' => 'Леонардо ДиКаприо']);

        $this->assertDatabaseHas('actors', [
            'id' => $actor->id,
            'name' => 'Леонардо ДиКаприо'
        ]);
    }

    /**
     * Проверяет отношение "многие-ко-многим" с фильмами.
     */
    public function testActorHasFilmsRelation(): void
    {
        $actor = Actor::factory()->create();
        $film = Film::factory()->create();

        $actor->films()->attach($film);

        $this->assertInstanceOf(Collection::class, $actor->films);
        $this->assertCount(1, $actor->films);
        $this->assertEquals($film->id, $actor->films->first()->id);
    }

    /**
     * Проверяет, что имя актёра корректно возвращается.
     */
    public function testActorNameAccessor(): void
    {
        $actor = Actor::create(['name' => 'Том Хэнкс']);

        $this->assertEquals('Том Хэнкс', $actor->name);
    }
}
