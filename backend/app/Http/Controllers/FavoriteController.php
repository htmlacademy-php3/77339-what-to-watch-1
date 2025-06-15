<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Список фильмов в избранном
     *
     * @return SuccessResponse
     */
    public function index() : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Добавление фильма в избранное
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function store(Request $request) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Удаление из избранного
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function destroy(Request $request) : SuccessResponse
    {
        return $this->success([]);
    }
}
