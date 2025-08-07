<?php

namespace App\Services;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

/**
 * Сервис для работы с жанрами.
 */
class GenreService
{
    /**
     * Получить список всех жанров.
     *
     * @return Collection<Genre> Коллекция жанров.
     */
    public function getAllGenres(): Collection
    {
        return Genre::all();
    }

    /**
     * Обновить жанр по ID.
     *
     * @param int   $id   Идентификатор жанра.
     * @param array $data Данные для обновления (например, ['name' => 'New name']).
     *
     * @return Genre Обновлённая модель жанра.
     */
    public function updateGenre(int $id, array $data): Genre
    {
        $genre = Genre::findOrFail($id);
        $genre->update($data);

        return $genre;
    }
}
