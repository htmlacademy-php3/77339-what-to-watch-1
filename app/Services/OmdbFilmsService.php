<?php

namespace App\Services;

use App\Exceptions\FilmsRepositoryException;
use App\Interfaces\FilmsOmdbRepositoryInterface;

/**
 * Сервис для получения данных о фильме по IMDB ID с использованием внешнего репозитория OMDb API.
 *
 *  Класс инкапсулирует логику обращения к внешнему API для получения информации о фильме и обрабатывает возможные ошибки.
 */
class OmdbFilmsService
{
    /**
     * @psalm-suppress PossiblyUnusedMethod
     * Laravel DI автоматически вызывает этот конструктор
     */
    public function __construct(protected FilmsOmdbRepositoryInterface $repository)
    {
    }

    /**
     * Получает данные о фильме по IMDB ID.
     *
     * @param string $imdbId IMDB идентификатор фильма.
     *
     * @return array Ассоциативный массив с данными о фильме.
     *
     * @throws FilmsRepositoryException Если не удалось получить данные от внешнего сервиса.
     */
    public function getFilm(string $imdbId): array
    {
        $filmData = $this->repository->getFilmById($imdbId);

        if (!$filmData) {
            throw new FilmsRepositoryException("Отсутствуют данные для обновления");
        }

        return $filmData;
    }
}
