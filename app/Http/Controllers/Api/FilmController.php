<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Models\Film;
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
        $films = Film::all();
        return $this->success($films);
    }

    /**
     * Просмотр страницы фильма
     *
     * @param Film $film
     *
     * @return SuccessResponse
     */
    public function show(Film $film) : SuccessResponse
    {
        return $this->success($film);
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'nullable|string|max:4',
            'description' => 'nullable|string',
            'director' => 'nullable|string|max:255',
            'actors' => 'nullable|string',
            'duration' => 'nullable|string|max:10',
            'imdb_rating' => 'nullable|numeric|between:0,10',
            'imdb_votes' => 'nullable|integer|min:0',
            'imdb_id' => 'nullable|string|max:20',
            'poster_url' => 'nullable|url',
            'preview_url' => 'nullable|url',
            'background_color' => 'nullable|string|max:7',
            'cover_url' => 'nullable|url',
            'video_url' => 'nullable|url',
            'video_preview_url' => 'nullable|url',
        ]);
        
        $film = Film::create($validated);
        
        return $this->success($film, 201);
    }

    /**
     * Обновление данных фильма
     *
     * @param Request $request
     * @param Film $film
     *
     * @return SuccessResponse
     */
    public function update(Request $request, Film $film) : SuccessResponse
    {
        $this->authorize('edit-resource', $film);
        
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|nullable|string|max:4',
            'description' => 'sometimes|nullable|string',
            'director' => 'sometimes|nullable|string|max:255',
            'actors' => 'sometimes|nullable|string',
            'duration' => 'sometimes|nullable|string|max:10',
            'imdb_rating' => 'sometimes|nullable|numeric|between:0,10',
            'imdb_votes' => 'sometimes|nullable|integer|min:0',
            'imdb_id' => 'sometimes|nullable|string|max:20',
            'poster_url' => 'sometimes|nullable|url',
            'preview_url' => 'sometimes|nullable|url',
            'background_color' => 'sometimes|nullable|string|max:7',
            'cover_url' => 'sometimes|nullable|url',
            'video_url' => 'sometimes|nullable|url',
            'video_preview_url' => 'sometimes|nullable|url',
        ]);
        
        $film->update($validated);
        
        return $this->success($film);
    }

    /**
     * Список похожих фильмов
     *
     * @param Film $film
     *
     * @return SuccessResponse
     */
    public function similar(Film $film) : SuccessResponse
    {
        $similarFilms = Film::where('id', '!=', $film->id)
            ->limit(5)
            ->get();
        
        return $this->success($similarFilms);
    }

    /**
     * Показ промо
     *
     * @return SuccessResponse
     */
    public function showPromo() : SuccessResponse
    {
        $promoFilm = Film::first();
        
        return $this->success($promoFilm);
    }

    /**
     * Создание промо
     *
     * @param Request $request
     * @param Film $film
     *
     * @return SuccessResponse
     */
    public function createPromo(Request $request, Film $film) : SuccessResponse
    {
        return $this->success($film);
    }

    /**
     * Удаление фильма
     *
     * @param Film $film
     *
     * @return SuccessResponse
     */
    public function destroy(Film $film) : SuccessResponse
    {
        $this->authorize('edit-resource', $film);
        
        $film->delete();
        
        return $this->success(['message' => 'Film deleted successfully']);
    }
}
