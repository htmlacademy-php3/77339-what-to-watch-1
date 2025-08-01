<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Models\Comment;
use App\Models\Film;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Список комментариев к фильму
     *
     * @param Film $film
     *
     * @return SuccessResponse
     */
    public function index(Film $film) : SuccessResponse
    {
        $comments = $film->comments()->with('user')->get();
        
        return $this->success($comments);
    }

    /**
     * Добавление комментария
     *
     * @param Request $request
     * @param Film $film
     *
     * @return SuccessResponse
     */
    public function store(Request $request, Film $film) : SuccessResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'author' => 'required|string|max:255',
            'rate' => 'nullable|integer|between:1,10',
            'comment_id' => 'nullable|exists:comments,id',
        ]);
        
        $validated['user_id'] = $request->user()->id;
        $validated['film_id'] = $film->id;
        
        $comment = Comment::create($validated);
        
        return $this->success($comment);
    }

    /**
     * Изменение комментария
     *
     * @param Request $request
     * @param Comment $comment
     *
     * @return SuccessResponse
     */
    public function update(Request $request, Comment $comment) : SuccessResponse
    {
        $this->authorize('edit-resource', $comment);
        
        $validated = $request->validate([
            'content' => 'sometimes|required|string|max:1000',
            'author' => 'sometimes|required|string|max:255',
            'rate' => 'sometimes|nullable|integer|between:1,10',
        ]);
        
        $comment->update($validated);
        
        return $this->success($comment);
    }

    /**
     * Удаление комментария
     *
     * @param Comment $comment
     *
     * @return SuccessResponse
     */
    public function destroy(Comment $comment) : SuccessResponse
    {
        $this->authorize('edit-resource', $comment);
        
        $comment->delete();
        
        return $this->success(['message' => 'Comment deleted successfully']);
    }
}
