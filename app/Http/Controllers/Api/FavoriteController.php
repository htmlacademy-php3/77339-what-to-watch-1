<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilmListResource;
use App\Http\Resources\FilmResource;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\FavoriteFilm;
use App\Models\Film;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * @psalm-suppress UnusedClass
 */
class FavoriteController extends Controller
{
    /**
     * Список фильмов в избранном
     */
    public function index(): SuccessResponse
    {
        $userId = auth()->id();
        $perPage = 8;

        /**
         * @var LengthAwarePaginator<FavoriteFilm> $favorites
         */
        $favorites = FavoriteFilm::where('user_id', $userId)
            ->with(
                ['film' => function ($query) {
                    $query->with(
                        [
                        'genres:genres.id,genres.name',
                        'actors:actors.id,actors.name',
                        'directors:directors.id,directors.name',
                        ]
                    );
                }]
            )
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);

        $items = collect($favorites->items());
        $formatted = $items->map(
            function ($favorite) {
                $film = $favorite->film;
                $film->is_favorite = true;
                $film->added_at = $favorite->created_at->format('Y-m-d H:i:s');
                return new filmResource($film);
            }
        );

        return $this->success(FilmListResource::collection($formatted));
    }

    /**
     * Добавление фильма в избранное
     *
     * @param $filmId
     *
     * @return SuccessResponse|ErrorResponse
     */
    public function store($filmId): SuccessResponse|ErrorResponse
    {
        $usrId = auth()->id();

        /**
 * @psalm-suppress UndefinedMagicMethod 
*/
        if (!Film::where('id', $filmId)->exists()) {
            return $this->error('Фильм не найден', [], 404);
        }

        /**
 * @psalm-suppress UndefinedMagicMethod 
*/
        if (FavoriteFilm::where('user_id', $usrId)->where('film_id', $filmId)->exists()) {
            return $this->success(['message' => "Фильм уже в избранном"], 200);
        }

        FavoriteFilm::create(
            [
            'user_id' => $usrId,
            'film_id' => $filmId,
            ]
        );

        return $this->success(['message' => "Фильм успешно добавлен в избранное!"], 201);
    }

    /**
     * Удаление из избранного
     *
     * @param $filmId
     *
     * @return SuccessResponse|ErrorResponse
     */
    public function destroy($filmId): SuccessResponse|ErrorResponse
    {
        $userId = auth()->id();

        /**
 * @psalm-suppress UndefinedMagicMethod 
*/
        $deleted = FavoriteFilm::where('user_id', $userId)
            ->where('film_id', $filmId)
            ->delete();

        if ($deleted) {
            return $this->success(['message' => "Фильм удален из избранного"], 200);
        }

        return $this->error('Фильм не найден в избранном', [], 404);
    }
}
