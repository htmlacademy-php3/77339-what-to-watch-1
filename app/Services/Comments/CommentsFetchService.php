<?php

namespace App\Services\Comments;

use App\Models\Comment;
use App\Repositories\Comments\CommentsFetchRepository;
use Illuminate\Support\Collection;

/**
 * Сервис получения всех комментариев к фильму
 */
class CommentsFetchService
{
    public function __construct(protected CommentsFetchRepository $commentsFetchRepository)
    {
    }

    /**
     * Получение комментариев к фильму
     */
    public function getFilmComments(int $filmId): Collection
    {
        return collect(
            collect($this->commentsFetchRepository->getComments($filmId)->all())->map(
                function (Comment $comment) {
                    return [
                    'text' => $comment->text,
                    'author' => $comment->user?->name ?? 'Гость',
                    'created_at' => $comment->created_at->toDateTimeString(),
                    'rate' => $comment->rate,
                    ];
                }
            )
        );
    }
}
