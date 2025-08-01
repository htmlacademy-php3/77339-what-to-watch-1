<?php

namespace App\Http\Controllers;

use App\Http\Responses\SuccessResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Create a success response
     *
     * @param mixed $data
     * @param int $statusCode
     * @return SuccessResponse
     */
    protected function success($data = [], int $statusCode = 200): SuccessResponse
    {
        return new SuccessResponse($data, $statusCode);
    }
} 