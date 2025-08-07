<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\SuccessResponse;
use App\Services\Auth\RegisterService;

class RegisterController extends Controller
{
    public function __construct(protected RegisterService $registerService)
    {

    }

    /**
     * Регистрирует нового пользователя и возвращает токен.
     *
     * @param RegisterRequest $request
     *
     * @return SuccessResponse
     */
    public function register(RegisterRequest $request): SuccessResponse
    {
        $params = $request->validated();

        $result = $this->registerService->registerUser($params);

        return $this->success($result, 201);
    }
}
