<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\SuccessResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Просмотр своего профиля
     *
     * @return SuccessResponse
     */
    public function me() : SuccessResponse
    {
        return $this->success([]);
    }

    /**
     * Изменение профиля
     *
     * @param Request $request
     *
     * @return SuccessResponse
     */
    public function  update(Request $request) : SuccessResponse
    {
        return $this->success([]);
    }
}
