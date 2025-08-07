<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModerator
{
    /**
     * Проверяет, является ли пользователь модератором
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isModerator()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
