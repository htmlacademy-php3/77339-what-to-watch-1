<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) : JsonResponse
    {
        return response()->json(['message' => 'Успешная регистрация!']);
    }
}
