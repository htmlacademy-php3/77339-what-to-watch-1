<?php


use App\Http\Middleware\CheckModerator;
use App\Http\Responses\ErrorResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\AuthenticateSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'isModerator' => CheckModerator::class,
            'auth' => Authenticate::class,
            'auth.basic' => AuthenticateWithBasicAuth::class,
            'auth.session' => AuthenticateSession::class,
        ]);
        Authenticate::redirectUsing(function () {
            return null;
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ModelNotFoundException $e) {
            return new ErrorResponse(
                message: 'Запрашиваемая сущность не найдена.',
                statusCode: Response::HTTP_NOT_FOUND
            );
        });

        $exceptions->render(function (NotFoundHttpException $e) {
            return new ErrorResponse(
                message: 'Запрашиваемая страница не существует.',
                statusCode: Response::HTTP_NOT_FOUND
            );
        });
        $exceptions->render(function (AuthenticationException $e) {
            return response()->json(['message' => 'Запрос требует аутентификации.'], 401);
        });
    })->create();
