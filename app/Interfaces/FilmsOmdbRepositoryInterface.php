<?php

namespace App\Interfaces;

/**
 * Интерфейс для репозитория, получающего данные о фильмах из OMDb API.
 */
interface FilmsOmdbRepositoryInterface
{
    /**
     * Получает информацию о фильме по IMDb ID.
     *
     * @param  string $imdbId IMDb ID фильма (например, tt0111161)
     * @return array|null Ассоциативный массив данных о фильме или null при ошибке
     */
    public function getFilmById(string $imdbId): ?array;

    /**
     * Возвращает сообщение об ошибке, если оно имеется.
     *
     * @return         string|null
     */
    public function getError(): ?string;
}
