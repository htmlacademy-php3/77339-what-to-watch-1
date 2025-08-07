<?php

namespace App\Services\Comments;

use App\Models\Comment;

/**
 * Сервис удаления комментария к фильму
 */
class CommentDeleteService
{
    /**
     * Удаление комментария с ответами
     */
    public function deleteComment(Comment $comment): void
    {
        $comment->deleteWithReplies();
    }
}
