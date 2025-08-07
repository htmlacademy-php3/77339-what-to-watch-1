<?php

namespace App\Services\Comments;

use App\Models\Comment;
use App\Repositories\Comments\CreateCommentRepository;
use RuntimeException;

/**
 * Сервис создания комментария к фильму
 */
class CommentCreateService
{
    public function __construct(protected CreateCommentRepository $createCommentRepository)
    {
    }

    /**
     * Создание нового комментария
     */
    public function createComment(array $data): Comment
    {
        $comment = $this->createCommentRepository->create($data);

        if (!$comment) {
            throw new RuntimeException('Не удалось создать комментарий');
        }

        return $comment;
    }
}
