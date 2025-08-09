<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Users\UserRepository;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Сервис входа пользователя в систему
 */
class LoginService
{
    /**
     * @psalm-suppress PossiblyUnusedMethod
     * Laravel DI автоматически вызывает этот конструктор
     */
    public function __construct(protected UserRepository $userRepository)
    {

    }

    /**
     * Аутентифицирует пользователя и возвращает токен.
     *
     * @param  array $credentials
     * @return string
     */
    public function loginUser(array $credentials): string
    {
        if (!Auth::attempt($credentials)) {
            throw new UnauthorizedHttpException('', 'Неверный email или пароль.');
        }

        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user) {
            throw new UnauthorizedHttpException('', 'Пользователь не найден.');
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
}
