<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Список комментариев к фильму
     *
     * @param int $film_id
     *
     * @return SuccessResponse
     */
    public function index(int $film_id) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Добавление комментария
     *
     * @param Request $request
     * @param int     $film_id
     *
     * @return SuccessResponse
     */
    public function store(Request $request, int $film_id) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Изменение комментария
     *
     * @param Request $request
     * @param string  $comment
     *
     * @return SuccessResponse
     */
    public function update(Request $request, string $comment) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Удаление комментария
     *
     * @param string $comment
     *
     * @return SuccessResponse
     */
    public function destroy(string $comment) : SuccessResponse
    {
        return $this->success([]);
    }
}
