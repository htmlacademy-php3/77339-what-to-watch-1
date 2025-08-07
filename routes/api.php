<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Фильмы
Route::prefix('films')->group(function () {
    Route::get('/', [FilmController::class, 'index'])->name('films.index');
    Route::get('/{id}', [FilmController::class, 'show'])->name('films.show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [FilmController::class, 'store'])->middleware('isModerator')->name('films.store');
        Route::patch('/{id}', [FilmController::class, 'update'])->middleware('isModerator')->name('films.update');
        Route::post('{id}/favorite', [FavoriteController::class, 'store'])->name('films.favorite.store');
        Route::delete('{id}/favorite', [FavoriteController::class, 'destroy'])->name('films.favorite.destroy');
    });

    Route::get('{id}/similar', [FilmController::class, 'similar'])->name('films.similar');
});

// Избранное
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('films.favorite.index');
});

// аутентификация
Route::post('/register', [RegisterController::class, 'register'])->name('user.register');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('user.logout');
});

// Пользователи
Route::prefix('/user')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'me'])->name('user.self.account');
    Route::patch('/', [UserController::class, 'update'])->name('user.account.update');
});

// Жанры
Route::prefix('/genres')->group(function () {
    Route::get('/', [GenreController::class, 'index'])->name('genres.index');
    Route::patch('/{genre}', [GenreController::class, 'update'])->middleware(['auth:sanctum', 'isModerator'])->name(
        'genres.update'
    );
});

// Комментарии
Route::prefix('/comments')->group(function () {
    Route::get('/{id}', [CommentController::class, 'index'])->name('comments.index');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/{id}', [CommentController::class, 'store'])->name('comments.store');
        Route::patch('/{comment}', [CommentController::class, 'update'])->middleware(
            'can:update-comment,comment'
        )->name('comments.update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->middleware(
            'can:delete-comment,comment'
        )->name('comments.destroy');
    });
});

// Промо
Route::prefix('/promo')->group(function () {
    Route::get('/', [FilmController::class, 'showPromo'])->name('promo.show');
    Route::post('/{id}', [FilmController::class, 'createPromo'])->middleware(['auth:sanctum', 'isModerator'])->name(
        'promo.create'
    );
});
