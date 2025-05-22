<?php

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
        $url = $this->baseUrl . '?' . http_build_query([
            'i' => $imdbId,
            'apikey' => $this->apiKey
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new RuntimeException('Failed to fetch movie data: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Failed to parse movie data: ' . json_last_error_msg());
        }
        
        if (isset($data['Error'])) {
            throw new RuntimeException('API Error: ' . $data['Error']);
        }
        
        return $data;
    }
} 