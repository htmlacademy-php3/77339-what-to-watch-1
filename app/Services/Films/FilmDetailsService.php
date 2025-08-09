<?php

namespace App\Services\Films;

use App\Models\Film;
use App\Repositories\Films\FilmDetailsRepository;

/**
 * Сервис получения подробной информации о фильме
 */
class FilmDetailsService
{
    /**
     * @psalm-suppress PossiblyUnusedMethod
     * Laravel DI автоматически вызывает этот конструктор
     */
    public function __construct(protected FilmDetailsRepository $filmDetailsRepository)
    {

    }

    /**
     *  Возвращает подробную информацию о фильме по его ID с отметкой об избранном.
     *
     * @param int $id ID фильма
     *
     * @return Film Модель фильма со связями
     */
    public function getFilmDetails(int $id, ?int $userId = null): Film
    {
        return $this->filmDetailsRepository->details($id, $userId);
    }
}
