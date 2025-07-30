<?php

interface MovieRepositoryInterface
{
    /**
     * @param string
     * @return array
     */
    public function getMovieByImdbId(string $imdbId): array;
} 