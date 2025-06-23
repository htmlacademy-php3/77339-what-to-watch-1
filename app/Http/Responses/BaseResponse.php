<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

abstract class BaseResponse implements Responsable
{
    protected mixed $data;
    protected int $statusCode;
    protected array $headers;

    public function __construct(mixed $data, int $statusCode = 200, array $headers = [])
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    /**
     * Преобразует объект ответа в HTTP-ответ в формате JSON.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            $this->prepareData(),
            $this->statusCode,
            $this->headers
        );
    }

    /**
     * Преобразование данных к массиву
     *
     * @return array
     */
    abstract protected function prepareData(): array;
}
