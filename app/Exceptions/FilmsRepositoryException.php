<?php

namespace App\Exceptions;

use Exception;

/**
 * Исключение, выбрасываемое при ошибках в репозитории фильмов.
 * @package App\Exceptions
 */
final class FilmsRepositoryException extends Exception
{
    /**
     * Возвращает HTTP-код ошибки по умолчанию.
     *
     * @return         int
     */
    public function getStatusCode(): int
    {
        return 500;
    }
}
