<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Список фильмов
     *
     * @return SuccessResponse
     */
    public function index() : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Просмотр страницы фильма
     *
     * @param int $id
     *
     * @return SuccessResponse
     */
    public function show(int $id) : SuccessResponse
    {
        return  $this->success([]);
    }

    /**
     * Добавление фильма в бд
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function store(Request $request) : SuccessResponse
    {
        return $this->success([], 201);
    }

    /**
     * Обновление данных фильма
     *
     * @param Request $request
     * @param int     $id
     *
     * @return SuccessResponse
     */
    public function update(Request $request, int $id) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Список похожих фильмов
     *
     * @param int $id
     *
     * @return SuccessResponse
     */
    public function similar(int $id) : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Показ промо
     *
     * @return SuccessResponse
     */
    public function showPromo() : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Создание промо
     *
     * @param Request $request
     * @param         $film_id
     *
     * @return SuccessResponse
     */
    public function createPromo(Request $request, $film_id) : SuccessResponse
    {
        return $this->success([]);
    }
}
