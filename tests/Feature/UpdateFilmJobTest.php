<?php

namespace Tests\Feature;

use App\Interfaces\FilmsOmdbRepositoryInterface;
use App\Jobs\UpdateFilmJob;
use App\Models\Film;
use App\Services\OmdbFilmsService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

/**
 * Тестирование очередной задачи по обновлению данных фильма.
 *
 * Проверяет:
 * - что задача ставится в очередь через dispatch();
 * - что задача исполняется вручную через handle();
 * - что данные фильма сохраняются в базе;
 * - что зависимости подменяются через мок-интерфейс.
 */
class UpdateFilmJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет, что задача обновления фильма исполняется вручную и сохраняет
     * данные в БД с использованием замоканного репозитория.
     *
     * @return void
     * @throws Exception
     */
    public function testUpdateFilmJobDispatchesAndSavesFilmData(): void
    {
        Queue::fake();

        $film = Film::factory()->create([
            'imdb_id' => 'tt0111161',
        ]);

        $this->app->bind(FilmsOmdbRepositoryInterface::class, function () {
            return Mockery::mock(FilmsOmdbRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('getFilmById')->once()->with('tt0111161')->andReturn([
                    'imdbID' => 'tt0111161',
                    'Title' => 'The Shawshank Redemption',
                    'Plot' => 'A banker convicted of uxoricide...',
                    'Runtime' => '142 min',
                    'Year' => 1994,
                    'imdbRating' => '9.3',
                    'Poster' => 'https://example.com/poster.jpg',
                    'imdbVotes' => '3,059,994',
                    'Director' => 'Frank Darabont',
                    'Actors' => 'Tim Robbins, Morgan Freeman, Bob Gunton',
                    'Genre' => 'Drama',
                ]);
                $mock->shouldReceive('getError')->zeroOrMoreTimes()->andReturn(null);
            });
        });

        $service = app(OmdbFilmsService::class);

        $job = new UpdateFilmJob('tt0111161', $film);
        $job->handle($service);

        $this->assertDatabaseHas('films', [
            'imdb_id' => 'tt0111161',
            'name' => 'The Shawshank Redemption',
            'description' => 'A banker convicted of uxoricide...',
            'run_time' => 142,
            'released' => 1994,
            'rating' => '9.3',
            'poster_image' => 'https://example.com/poster.jpg',
            'imdb_votes' => 3059994,
        ]);
    }

    /**
     * Проверяет, что задача ставится в очередь с корректными аргументами.
     *
     * @return void
     */
    public function testUpdateFilmJobIsQueued(): void
    {
        Queue::fake();

        $film = Film::factory()->create([
            'imdb_id' => 'tt0111161',
        ]);

        UpdateFilmJob::dispatch('tt0111161', $film);

        Queue::assertPushed(UpdateFilmJob::class, function (UpdateFilmJob $job) use ($film) {
            return $job->film->is($film);
        });
    }
}
