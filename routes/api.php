<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/movie', [MovieController::class, 'getMovieInfo']); 