<?php

namespace App\Http\Responses;

class SuccessResponse extends BaseResponse
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

    protected function prepareData(): array
    {
        return [
            'success' => true,
            'data' => $this->data,
            'timestamp' => now()->toIso8601String()
        ];
    }
}
