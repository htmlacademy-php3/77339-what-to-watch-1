<?php

namespace App\Repositories\Comments;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Репозиторий для создания комментариев.
 *
 * @template TModel of Model
 */
final class CreateCommentRepository
{
    /**
     * Создаёт новый комментарий.
     *
     * @param  array $data Ассоциативный массив данных комментария (text, rate, user_id, film_id и т.д.)
     * @return Comment|null Созданная модель комментария
     */
    public function create(array $data): ?Comment
    {
        return Comment::create($data);
    }
}
