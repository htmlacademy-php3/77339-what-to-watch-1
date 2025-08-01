<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GenreController extends Controller
{
    /**
     * Список жанров
     *
     * @return SuccessResponse
     */
    public function index() : SuccessResponse
    {
        $genres = Genre::all();
        return $this->success($genres);
    }

    /**
     * Обновление жанров
     *
     * @param Request $request
     * @param Genre $genre
     *
     * @return SuccessResponse
     */
    public function update(Request $request, Genre $genre) : SuccessResponse
    {
        $this->authorize('edit-resource', $genre);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        
        $genre->update($validated);
        
        return $this->success($genre);
    }
}
