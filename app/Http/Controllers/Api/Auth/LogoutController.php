<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Responses\SuccessResponse;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function logout(Request $request): SuccessResponse
    {
        $request->user()->currentAccessToken()->delete();

        return new SuccessResponse(['message' => 'Вы успешно вышли из системы']);
    }
}
