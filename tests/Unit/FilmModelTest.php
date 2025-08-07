<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Film;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilmModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет, что свойство rating действительно
     * возвращает правильный рейтинг, который основывается на оценках
     * этого фильма, оставленных пользователями
     */
    public function testCorrectRatingCalculation(): void
    {
        $film = Film::factory()->create();

        Comment::factory()->create([
            'film_id' => $film->id,
            'rate' => 6.1,
            ]);
        Comment::factory()->create([
            'film_id' => $film->id,
            'rate' => 8.5,
            ]);
        Comment::factory()->create([
            'film_id' => $film->id,
            'rate' => 10,
            ]);

        $rating = $film->rating;

        $this->assertEquals(8.3, $rating);
    }
}
