<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Get movie information by IMDB ID
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMovieInfo(Request $request): JsonResponse
    {
        $request->validate([
            'imdb_id' => 'required|string'
        ]);

        try {
            $movieInfo = $this->movieService->getMovieInfo($request->input('imdb_id'));
            return response()->json($movieInfo);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
} 