<?php

namespace App\Exceptions;

use Exception;

/**
 * Исключение, выбрасываемое при ошибках в репозитории фильмов.
 *
 * Может использоваться для обработки ошибок, связанных с получением,
 * сохранением или обновлением данных фильмов в источнике данных.
 *
 * @package App\Exceptions
 */
final class FilmsRepositoryException extends Exception
{
    /**
     * Возвращает HTTP-код ошибки по умолчанию.
     *
     * @return         int HTTP-статус 500 (внутренняя ошибка сервера)
     * @psalm-suppress UnusedMethod
     */
    public function getStatusCode(): int
    {
        return 500;
    }
}
