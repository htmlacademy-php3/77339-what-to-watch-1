<?php

require_once 'MovieRepositoryInterface.php';
require_once 'OmdbMovieRepository.php';
require_once 'MovieService.php';

$apiKey = 'your-api-key-here';

$repository = new OmdbMovieRepository($apiKey);

$movieService = new MovieService($repository);

try {
    $movieInfo = $movieService->getMovieInfo('tt0133093');
    
    print_r($movieInfo);
} catch (RuntimeException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
