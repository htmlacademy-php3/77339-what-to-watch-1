<?php
namespace Tests\Feature;

use App\Jobs\FetchAndSaveMovie;
use App\Models\Film;
use App\Services\MovieFetcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Mockery;

class FetchAndSaveMovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function DispatchMovieFetchJobToQueue()
    {
        Queue::fake();

        $imdbId = 'tt0111161';

        FetchAndSaveMovie::dispatch($imdbId);

        Queue::assertPushed(FetchAndSaveMovie::class, function ($job) use ($imdbId) {
            return $job->imdbId === $imdbId;
        });
    }

    /** @test */
    public function SaveMovieDataFromMockedFetcher()
    {
        $mockedFetcher = Mockery::mock(MovieFetcher::class);
        $mockedFetcher->shouldReceive('fetchByImdbId')
            ->once()
            ->with('tt1234567')
            ->andReturn([
                'Title' => 'Mocked Movie',
                'Year' => '2025',
                'Genre' => 'Action, Comedy',
                'Director' => 'Jane Doe',
                'Poster' => 'https://poster.com/image.jpg',
                'Plot' => 'This is a mocked plot.',
                'Response' => 'True',
            ]);

        // Execute: run the job
        $job = new FetchAndSaveMovie('tt1234567');
        $job->handle($mockedFetcher);

        // Assert: data is actually in the database
        $this->assertDatabaseHas('films', [
            'imdb_id' => 'tt1234567',
            'title' => 'Mocked Movie',
            'year' => '2025',
            'director' => 'Jane Doe',
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
