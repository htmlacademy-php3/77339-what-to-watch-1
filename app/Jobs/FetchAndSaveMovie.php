<?php
namespace App\Jobs;

use App\Models\Movie;
use App\Services\MovieFetcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchAndSaveMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imdbId;

    public function __construct(string $imdbId)
    {
        $this->imdbId = $imdbId;
    }

    public function handle(MovieFetcher $fetcher)
    {
        $data = $fetcher->fetchByImdbId($this->imdbId);

        Movie::updateOrCreate(
            ['imdb_id' => $this->imdbId],
            [
                'title' => $data['Title'],
                'year' => $data['Year'],
                'genre' => $data['Genre'],
                'director' => $data['Director'],
                'poster' => $data['Poster'],
                'plot' => $data['Plot'],
            ]
        );
    }
}
