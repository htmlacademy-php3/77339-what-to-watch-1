<?php
namespace App\Repositories\Films;

use App\Models\FavoriteFilm;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Репозиторий для проверки, добавлен ли фильм в избранное пользователем.
 *
 * Отвечает за обращение к таблице избранных фильмов (favorite_films)
 * и предоставляет метод для проверки наличия записи по ID пользователя и фильма.
 *
 * @template TModel of Model
 */
final class FavoriteFilmCheckRepository
{
    /**
     * Проверяет, добавлен ли фильм в избранное пользователем.
     *
     * @param  int $filmId ID фильма
     * @param  int $userId ID пользователя
     * @return bool true, если фильм в избранном; иначе false
     */
    public function isFavorite(int $filmId, int $userId): bool
    {
        return FavoriteFilm::query()->where('film_id', $filmId)
            ->where('user_id', $userId)
            ->exists();
    }
}
