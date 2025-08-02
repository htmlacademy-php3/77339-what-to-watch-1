<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\TransientToken;

class LogoutController extends Controller
{
    public function logout(Request $request): SuccessResponse
    {
        if ($request->user() && !$request->user()->currentAccessToken() instanceof TransientToken) {
            $request->user()->currentAccessToken()->delete();
        }

        return new SuccessResponse(['message' => 'Вы успешно вышли из системы']);
    }
}
