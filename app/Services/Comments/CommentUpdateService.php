<?php

namespace App\Services\Comments;

use App\Models\Comment;
use App\Repositories\Comments\UpdateCommentRepository;
use RuntimeException;

/**
 * Сервис редактирования комментария к фильму
 */
class CommentUpdateService
{
    public function __construct(protected UpdateCommentRepository $updateCommentRepository)
    {

    }

    /**
     * Обновление комментария
     */
    public function updateComment(Comment $comment, array $data): Comment
    {
        $updatedComment = $this->updateCommentRepository->update($comment, $data);

        if (!$updatedComment) {
            throw new RuntimeException('Не удалось обновить комментарий');
        }

        return $updatedComment;
    }
}
