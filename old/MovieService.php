<?php

class MovieService
{
    private MovieRepositoryInterface $repository;

    public function __construct(MovieRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string
     * @return array
     * @throws RuntimeException
     */
    public function getMovieInfo(string $imdbId): array
    {
        return $this->repository->getMovieByImdbId($imdbId);
    }
} 