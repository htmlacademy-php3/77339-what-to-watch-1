<?php

namespace App\Interfaces;

use App\Models\User;

/**
 * Интерфейс репозитория пользователей.
 */
interface UserRepositoryInterface
{
    /**
     * Обновляет данные пользователя по его идентификатору.
     *
     * @param  int   $userId  Идентификатор
     *                        пользователя.
     * @param  array $details Ассоциативный массив
     *                        обновляемых данных.
     * @return User|null Обновлённая модель пользователя.
     */
    public function updateUser(int $userId, array $details): ?User;
}
