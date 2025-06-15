<?php

namespace App\Http\Responses;

use Symfony\Component\HttpFoundation\Response;

final class ErrorResponse extends BaseResponse
{
    public int $statusCode = Response::HTTP_BAD_REQUEST;

    /**
     * @param             $data
     * @param string|null $message
     * @param int         $statusCode
     */
    public function __construct($data, protected ?string $message = null, int $statusCode = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct([], $statusCode);
    }

    /**
     * Формирование содержимого ответа
     *
     * @return array
     */
    protected function makeResponseData(): array
    {
        return [
            'message' => $this->message,
            'errors' => $this->prepareData(),
        ];
    }
}
