<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

/**
 * Запрос на обновление данных пользователя.
 *
 * Валидация включает:
 * — имя (опционально, строка, до 255 символов),
 * — email (опционально, корректный, уникальный, до 255 символов),
 * — пароль (опционально, подтверждён, от 8 символов, со строчными/прописными, цифрами и символами),
 * — аватар (опционально, изображение JPEG/PNG/JPG, до 10 МБ).
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * Определяет, авторизован ли пользователь выполнять этот запрос.
     *
     * @return         bool
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации запроса.
     *
     * @return         array<string, mixed>
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id)
            ],
            'password' => [
                'sometimes',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg|max:10240'
        ];
    }
}
