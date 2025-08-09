<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Http\Responses\SuccessResponse;
use App\Models\Comment;
use App\Services\Comments\CommentCreateService;
use App\Services\Comments\CommentDeleteService;
use App\Services\Comments\CommentsFetchService;
use App\Services\Comments\CommentUpdateService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

/**
 * API для управления комментариями к фильмам: просмотр, добавление, редактирование и удаление
 *
 * @psalm-suppress UnusedClass
 */
class CommentController extends Controller
{
    public function __construct(
        protected CommentsFetchService $commentsFetchService,
        protected CommentCreateService $commentCreateService,
        protected CommentUpdateService $commentUpdateService,
        protected CommentDeleteService $commentDeleteService,
    ) {
    }

    /**
     * Список комментариев к фильму
     *
     * @param int $film_id
     *
     * @return SuccessResponse
     */
    public function index(int $film_id): SuccessResponse
    {
        $comments = $this->commentsFetchService->getFilmComments($film_id);

        return $this->success($comments, 201);
    }

    /**
     * Добавление комментария
     *
     * @param StoreCommentRequest $request
     * @param $filmId
     *
     * @return SuccessResponse
     */
    public function store(StoreCommentRequest $request, $filmId): SuccessResponse
    {
        $comment = $this->commentCreateService->createComment(
            [
            'user_id' => auth()->id(),
            'film_id' => $filmId,
            'text' => $request->text,
            'rate' => $request->rate,
            ]
        );

        return $this->success($comment, 201);
    }

    /**
     * Редактирование комментария
     *
     * @param UpdateCommentRequest $request
     * @param Comment              $comment
     *
     * @return SuccessResponse
     * @throws AuthorizationException
     */
    public function update(UpdateCommentRequest $request, Comment $comment): SuccessResponse
    {
        Gate::authorize('update-comment', $comment);

        $updatedComment = $this->commentUpdateService->updateComment($comment, $request->validated());

        return $this->success(
            [
            'text' => $updatedComment->text,
            'rate' => $updatedComment->rate,
            ], 200
        );
    }

    /**
     * Удаление комментария
     *
     * @param Comment $comment
     *
     * @return SuccessResponse
     * @throws AuthorizationException
     */
    public function destroy(Comment $comment): SuccessResponse
    {
        Gate::authorize('delete-comment', $comment);

        if (!auth()->user()->isModerator() && $comment->replies()->exists()) {
            throw new AuthorizationException('Нельзя удалить комментарий с ответами');
        }

        $this->commentDeleteService->deleteComment($comment);

        return $this->success([], 204);
    }
}
