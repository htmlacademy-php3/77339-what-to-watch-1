<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Override;


/**
 * @psalm-suppress UnusedClass
 * Класс используется Laravel для:
 *  - Регистрации связей в контейнере
 *  - Запуска начальной загрузки сервисов
 *  - Регистрации middleware, роутов, команд
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $policies = [];
    /**
     * Register services.
     */
    #[Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('update-comment', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id || $user->role === User::ROLE_MODERATOR;
        });

        Gate::define(
            'delete-comment', function (User $user, Comment $comment) {
                if ($user->isModerator()) {
                    return true;
                }
                return $user->id === $comment->user_id && !$comment->replies()->exists();
            }
        );
    }
}
