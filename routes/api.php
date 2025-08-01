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

// Public routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::get('/user', [UserController::class, 'me']);
    Route::patch('/user', [UserController::class, 'update']);
    
    // Film routes
    Route::get('/films', [FilmController::class, 'index']);
    Route::get('/films/{film}', [FilmController::class, 'show']);
    Route::post('/films', [FilmController::class, 'store']);
    Route::get('/films/{film}/similar', [FilmController::class, 'similar']);
    Route::get('/promo', [FilmController::class, 'showPromo']);
    
    // Genre routes
    Route::get('/genres', [GenreController::class, 'index']);
    
    // Comment routes
    Route::get('/comments/{film}', [CommentController::class, 'index']);
    Route::post('/comments/{film}', [CommentController::class, 'store']);
    
    // Favorite routes
    Route::get('/favorite', [FavoriteController::class, 'index']);
    Route::post('/films/{film}/favorite', [FavoriteController::class, 'store']);
    Route::delete('/films/{film}/favorite', [FavoriteController::class, 'destroy']);
    
    // Moderator routes
    Route::middleware(['moderator'])->group(function () {
        Route::patch('/films/{film}', [FilmController::class, 'update']);
        Route::delete('/films/{film}', [FilmController::class, 'destroy']);
        Route::patch('/genres/{genre}', [GenreController::class, 'update']);
        Route::patch('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
        Route::post('/promo/{film}', [FilmController::class, 'createPromo']);
    });
});

