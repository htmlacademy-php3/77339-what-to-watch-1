<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class MovieFetcher
{
    public function fetchByImdbId(string $imdbId): array
    {
        $response = Http::get('https://www.omdbapi.com/', [
            'i' => $imdbId,
            'apikey' => env('OMDB_API_KEY'),
        ]);

        if ($response->failed() || $response->json('Response') === 'False') {
            throw new \Exception('Failed to fetch movie data.');
        }

        return $response->json();
    }
}
