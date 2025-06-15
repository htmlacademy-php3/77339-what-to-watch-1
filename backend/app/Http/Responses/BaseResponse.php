<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseResponse implements Responsable
{
    public function __construct(protected mixed $data = [], public int $statusCode = Response::HTTP_OK)
    {
    }

    /**
     * Преобразует объект ответа в HTTP-ответ в формате JSON.
     *
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function toResponse($request) : JsonResponse|Response
    {
        return response()->json($this->makeResponseData(), $this->statusCode);
    }

    /**
     * Преобразование данных к массиву
     *
     * @return array
     */
    protected function prepareData() : array
    {
        if ($this->data instanceof Arrayable) {
            return $this->data->toArray();
        }

        return $this->data;
    }

    /**
     * Формирование содержимого ответа
     *
     * @return array|null
     */
    abstract protected function makeResponseData() : ?array;
}
