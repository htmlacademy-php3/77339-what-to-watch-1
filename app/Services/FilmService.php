<?php

namespace App\Services;

use App\Models\Movie;

class MovieService
{
    public function getMovies(array $filters = [])
    {
        $query = Movie::query();

        if (!empty($filters['genre'])) {
            $query->where('genre', 'like', '%' . $filters['genre'] . '%');
        }

        if (!empty($filters['year'])) {
            $query->where('year', $filters['year']);
        }

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getMovieDetails(int $id): Movie
    {
        return Movie::with(['comments.user'])->findOrFail($id);
    }
}
