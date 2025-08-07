<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenreResource;
use App\Http\Responses\SuccessResponse;
use App\Services\GenreService;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __construct(protected GenreService $genreService)
    {
    }

    /**
     * Список жанров
     *
     * @return SuccessResponse
     */
    public function index(): SuccessResponse
    {
        $genres = $this->genreService->getAllGenres();

        return $this->success(GenreResource::collection($genres));
    }

    /**
     * Обновление жанров
     *
     * @param Request $request
     * @param $id
     *
     * @return SuccessResponse
     */
    public function update(Request $request, $id): SuccessResponse
    {
        $genre = $this->genreService->updateGenre($id, $request->only('name'));

        return $this->success(new GenreResource($genre));
    }
}
