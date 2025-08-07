<?php

namespace App\Services\Films;

use App\Models\Film;
use App\Repositories\Films\FilmRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Сервис для работы с промо.
 */
class PromoFilmService
{
    public function __construct(protected FilmRepository $filmRepository)
    {
    }

    /**
     * Получает текущий промо фильм
     *
     * @return Film
     */
    public function getPromoFilm(): Film
    {
        return $this->filmRepository->getPromoFilm();
    }

    /**
     * Устанавливает фильм как промо и снимает флаг с предыдущего
     *
     * @throws Throwable
     */
    public function setPromoFilm(int $filmId): Film
    {
        DB::transaction(
            function () use ($filmId) {
                $this->filmRepository->resetPromoFlags();
                $this->filmRepository->setPromoFlag($filmId);
            }
        );

        return $this->filmRepository->findOrFail($filmId);
    }
}
