<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class OmdbMovieRepository implements MovieRepositoryInterface
{
    private string $apiKey;
    private string $baseUrl = 'http://www.omdbapi.com/';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getMovieByImdbId(string $imdbId): array
    {
        $response = Http::get($this->baseUrl, [
            'i' => $imdbId,
            'apikey' => $this->apiKey
        ]);

        if (!$response->successful()) {
            throw new RuntimeException('Failed to fetch movie data: ' . $response->body());
        }

        $data = $response->json();

        if (isset($data['Error'])) {
            throw new RuntimeException('API Error: ' . $data['Error']);
        }

        return $data;
    }
} 