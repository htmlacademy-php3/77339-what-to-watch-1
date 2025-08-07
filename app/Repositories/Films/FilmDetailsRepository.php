<?php

namespace App\Repositories\Films;

use App\Models\Film;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
final class FilmDetailsRepository
{
    public function details(int $id, ?int $userId = null): Film
    {
        /**
 * @var Builder<Film> $query 
*/

        $query = Film::with(
            [
            'genres',
            'actors',
            'directors',
            'favorites' => fn ($q) => $userId ? $q->where('user_id', $userId) : $q
            ]
        );

        return $query->findOrFail($id);
    }
}
