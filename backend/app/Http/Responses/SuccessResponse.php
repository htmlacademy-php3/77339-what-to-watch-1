<?php

namespace App\Http\Responses;

final class SuccessResponse extends BaseResponse
{
    /**
     * Формирование содержимого ответа
     *
     * @return array|null
     */
    protected function makeResponseData() : ?array
    {
        return $this->data ? [
            'data' => $this->prepareData(),
        ] : null;
    }
}
