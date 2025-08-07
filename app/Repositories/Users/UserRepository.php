<?php

namespace App\Repositories\Users;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Override;

/**
 * Репозиторий для работы с пользователями.
 *
 * @template TModel of Model
 */
final class UserRepository implements UserRepositoryInterface
{
    /**
     * Найти пользователя по email
     *
     * @param  string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        /**
 * @var Builder<User> $query 
*/
        $query = User::where('email', $email);
        return $query->first();
    }

    /**
     * Обновляет данные пользователя по ID.
     *
     * @param  int   $userId  Идентификатор
     *                        пользователя.
     * @param  array $details Ассоциативный массив с
     *                        обновляемыми данными.
     * @return User|null            Обновлённая модель пользователя.
     *
     * @throws ModelNotFoundException Если пользователь не найден.
     */
    #[Override]
    public function updateUser(int $userId, array $details): ?User
    {
        $user = User::findOrFail($userId);
        $user->update($details);

        return $user->fresh();
    }
}
