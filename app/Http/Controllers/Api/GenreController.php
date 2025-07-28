<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Список жанров
     *
     * @return SuccessResponse
     */
    public function index() : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Обновление жанров
     *
     * @param Request $request
     * @param         $id
     *
     * @return SuccessResponse
     */
    public function update(Request $request, $id) : SuccessResponse
    {
        $genre = \App\Models\Genre::findOrFail($id);
        $this->authorize('edit-resource', $genre);
        return $this->success([]);
    }
}
