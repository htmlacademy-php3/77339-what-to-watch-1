<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Films\FilmsListRequest;
use App\Http\Requests\Films\StoreFilmRequest;
use App\Http\Requests\Films\UpdateFilmRequest;
use App\Http\Resources\FilmListResource;
use App\Http\Resources\FilmResource;
use App\Http\Responses\SuccessResponse;
use App\Models\Film;
use App\Services\Films\FavoriteFilmCheckService;
use App\Services\Films\FilmCreateService;
use App\Services\Films\FilmDetailsService;
use App\Services\Films\FilmListService;
use App\Services\Films\FilmUpdateService;
use App\Services\Films\PromoFilmService;
use App\Services\Films\SimilarFilmService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class FilmController extends Controller
{
    public function __construct(
        protected FavoriteFilmCheckService $favoriteFilmCheckService,
        protected FilmListService $filmListService,
        protected FilmDetailsService $filmDetailsService,
        protected FilmCreateService $filmCreateService,
        protected FilmUpdateService $filmUpdateService,
        protected SimilarFilmService $similarFilmService,
        protected PromoFilmService $promoFilmService,
    ) {
    }

    /**
     * Список фильмов
     *
     * @param FilmsListRequest $request
     *
     * @return SuccessResponse
     */
    public function index(FilmsListRequest $request): SuccessResponse
    {
        $filters = $request->validated();
        $userId = (int) auth()->id();

        $perPage = $filters['per_page'] ?? 8;

        $films = $this->filmListService->getFilmList($filters, $userId, $perPage);

        return $this->success(FilmListResource::collection($films));
    }

    /**
     * Просмотр страницы фильма
     *
     * @param int $id
     *
     * @return SuccessResponse
     */
    public function show(int $id): SuccessResponse
    {
        $film =
            $this->filmDetailsService->getFilmDetails($id);
        $this->setFavoriteFlag($film);

        return $this->success(new FilmResource($film));
    }

    /**
     * Устанавливает флаг "избранного" для переданного фильма,
     * если пользователь авторизован и добавил фильм в избранное.
     *
     * @param Film $film
     *
     * @return void
     */
    protected function setFavoriteFlag(Film $film): void
    {
        $film->is_favorite = auth()->check()
            && $this->favoriteFilmCheckService->isFavorite($film->id, (int)auth()->id());
    }

    /**
     * Добавление фильма в бд
     *
     * @param StoreFilmRequest $request
     *
     * @return SuccessResponse
     * @throws Throwable
     */
    public function store(StoreFilmRequest $request): SuccessResponse
    {
        $film = $this->filmCreateService->createFilm($request->validated());

        return $this->success(new FilmResource($film), Response::HTTP_CREATED);
    }

    /**
     * Обновление данных фильма
     *
     * @param UpdateFilmRequest $request
     * @param int               $id
     *
     * @return SuccessResponse
     * @throws Throwable
     */
    public function update(UpdateFilmRequest $request, int $id): SuccessResponse
    {
        $film = $this->filmUpdateService->updateFilm($id, $request->validated());
        return $this->success(new FilmResource($film));
    }

    /**
     * Список похожих фильмов
     *
     * @param int $id
     *
     * @return SuccessResponse
     */
    public function similar(int $id): SuccessResponse
    {
        $films = $this->similarFilmService->getSimilarFilms($id);
        return $this->success(FilmListResource::collection($films));
    }

    /**
     * Показ промо
     *
     * @return SuccessResponse
     */
    public function showPromo(): SuccessResponse
    {
        $film = $this->promoFilmService->getPromoFilm();
        $this->setFavoriteFlag($film);

        return $this->success(new FilmResource($film));
    }

    /**
     * Создание промо
     *
     * @param $filmId
     *
     * @return SuccessResponse
     * @throws Throwable
     */
    public function createPromo($filmId): SuccessResponse
    {
        $film = $this->promoFilmService->setPromoFilm($filmId);

        return $this->success(new FilmResource($film));
    }
}
