<?php

namespace App\Repositories\Comments;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Репозиторий для обновления комментариев.
 *
 * @template TModel of Model
 */
final class UpdateCommentRepository
{
    /**
     * Обновляет указанный комментарий новыми данными.
     *
     * @param Comment $comment Объект комментария для обновления
     * @param array   $data    Данные для обновления (например: text, rate)
     *
     * @return Comment|null Обновлённый и перезагруженный комментарий
     */
    public function update(Comment $comment, array $data): ?Comment
    {
        $comment->update($data);
        return $comment->fresh();
    }
}
