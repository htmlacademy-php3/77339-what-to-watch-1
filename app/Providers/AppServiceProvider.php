<?php

namespace App\Providers;

use App\Interfaces\FilmsOmdbRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\Films\FilmsOmdbRepository;
use App\Repositories\Users\UserRepository;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Http\Adapter\Guzzle7\Client as GuzzleAdapter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        if ($this->app->runningInConsole()
            && !$this->app->environment('production')
            && file_exists(base_path('stubs/service.stub'))
        ) {
            $this->app->register(ConsoleServiceProvider::class);
        }

        $this->app->bind(FilmsOmdbRepositoryInterface::class, FilmsOmdbRepository::class);

        $this->app->bind(
            ClientInterface::class,
            function () {
                return new GuzzleAdapter(new Client());
            }
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('ru');
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    }
}
