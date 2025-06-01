<?php

namespace App\Providers;

use App\Repositories\MovieRepositoryInterface;
use App\Repositories\OmdbMovieRepository;
use Illuminate\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MovieRepositoryInterface::class, function ($app) {
            return new OmdbMovieRepository(config('services.omdb.api_key'));
        });
    }
} 