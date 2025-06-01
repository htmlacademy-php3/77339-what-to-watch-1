<?php

namespace App\Repositories;

interface MovieRepositoryInterface
{
    /**
     * Get movie information by IMDB ID
     *
     * @param string $imdbId
     * @return array
     */
    public function getMovieByImdbId(string $imdbId): array;
} 