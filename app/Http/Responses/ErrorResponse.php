<?php

namespace App\Http\Responses;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ErrorResponse extends BaseResponse
{
    public function __construct(
        Exception|string $error,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        array $headers = []
    ) {
        if ($error instanceof Exception) {
            $this->logException($error);
            $message = $error->getMessage();
            $statusCode = $error->getCode() ?: $statusCode;
        } else {
            $message = $error;
        }

        parent::__construct($message, $statusCode, $headers);
    }

    protected function prepareData(): array
    {
        return [
            'success' => false,
            'error' => [
                'message' => $this->data,
                'code' => $this->statusCode
            ],
            'timestamp' => now()->toIso8601String()
        ];
    }

    protected function logException(Exception $exception): void
    {
        Log::error('API Error', [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}
