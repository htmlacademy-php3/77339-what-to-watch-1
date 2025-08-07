<?php

namespace App\Services\Films;

use App\Repositories\Films\FilmsListRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class FilmListService
{
    public function __construct(
        protected FilmsListRepository $filmsListRepository,
        protected FavoriteFilmCheckService $favoriteFilmCheckService
    ) {
    }

    /**
     *  Возвращает список фильмов с поддержкой фильтрации и пагинации.
     *
     * @param array
     * @param int
     *
     * @return LengthAwarePaginator
     */
    public function getFilmList(array $filters = [], ?int $userId = null, int $perPage = 8): LengthAwarePaginator
    {
        $films = $this->filmsListRepository->getFilms($filters, $perPage);

        if ($userId) {
            $films->getCollection()->transform(
                function ($film) use ($userId) {
                    $film->is_favorite = $this->favoriteFilmCheckService->isFavorite($film->id, $userId);
                    return $film;
                }
            );
        }

        return $films;
    }
}
