<?php

namespace App\Services;

use App\Repositories\MovieRepositoryInterface;
use RuntimeException;

class MovieService
{
    private MovieRepositoryInterface $repository;

    public function __construct(MovieRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get movie information by IMDB ID
     *
     * @param string $imdbId
     * @return array
     * @throws RuntimeException
     */
    public function getMovieInfo(string $imdbId): array
    {
        return $this->repository->getMovieByImdbId($imdbId);
    }
} 