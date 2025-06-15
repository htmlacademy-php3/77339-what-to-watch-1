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

Route::get('/films', [FilmController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout']);
Route::get('/user', [UserController::class, 'me']);
Route::patch('/user', [UserController::class, 'update']);
Route::apiResource('/films', FilmController::class);
Route::get('/genres', [GenreController::class, 'index']);
Route::patch('/genres/{genre}', [GenreController::class, 'update']);
Route::get('/favorite', [FavoriteController::class, 'index']);
Route::post('/films/{id}/favorite', [FavoriteController::class, 'store']);
Route::delete('/films/{id}/favorite', [FavoriteController::class, 'destroy']);
Route::get('/films/{id}/similar', [FilmController::class, 'similar']);
Route::get('/comments/{id}', [CommentController::class,  'index']);
Route::post('/comments/{id}', [CommentController::class,  'store']);
Route::patch('/comments/{comment}', [CommentController::class,  'update']);
Route::delete('/comments/{comment}', [CommentController::class,  'destroy']);
Route::get('/promo', [FilmController::class,  'showPromo']);
Route::post('/promo/{id}', [FilmController::class,  'createPromo']);

