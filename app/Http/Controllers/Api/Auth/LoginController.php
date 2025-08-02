<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Responses\SuccessResponse;
use App\Http\Responses\ErrorResponse;

class LoginController extends Controller
{
    public function login(Request $request): SuccessResponse|ErrorResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return new ErrorResponse('Неверный логин или пароль', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return new SuccessResponse([
            'token' => $token,
            'user' => $user,
        ]);
    }
}