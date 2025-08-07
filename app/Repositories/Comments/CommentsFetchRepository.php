<?php

namespace App\Repositories\Comments;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Репозиторий для получения комментариев к фильмам.
 *
 * @template TModel of Model
 */
final class CommentsFetchRepository
{
    /**
     * Получает список комментариев к фильму с загруженными пользователями.
     *
     * @param  int $filmId ID фильма
     * @return Collection<int, Comment> Коллекция комментариев с отношением user
     */
    public function getComments(int $filmId): Collection
    {
        return Comment::with('user')
            ->where('film_id', $filmId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
