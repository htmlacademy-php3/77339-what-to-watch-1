<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Repositories\Users\UserRepository;
use Auth;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * Просмотр своего профиля
     *
     * @return SuccessResponse
     */
    public function me(): SuccessResponse
    {
        $user = auth()->user();
        return $this->success(new UserResource($user));
    }

    /**
     * Изменение профиля
     *
     * @param UpdateUserRequest $request
     *
     * @return SuccessResponse|ErrorResponse
     */
    public function update(UpdateUserRequest $request): SuccessResponse|ErrorResponse
    {
        $userId = Auth::id();

        if ($userId === null) {
            return $this->error('Пользователь не аутентифицирован');
        }

        $user = $this->userRepository->updateUser(
            (int)$userId,
            $request->validated()
        );

        return $this->success(new UserResource($user));
    }
}
