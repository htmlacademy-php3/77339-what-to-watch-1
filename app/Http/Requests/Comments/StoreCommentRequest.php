<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

/**
 * @property string $text
 * @property int $rate
 */
final class StoreCommentRequest extends FormRequest
{
    /**
     * @return         bool
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return         array
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function rules(): array
    {
        return [
            'text' => 'required|string|min:50|max:400',
            'rate' => 'required|integer|min:1|max:10',
            'comment_id' => [
                'nullable',
                'integer',
                Rule::exists('comments', 'id')->whereNull('deleted_at')
            ]
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'text.required' => 'Текст комментария обязателен',
            'text.min' => 'Комментарий должен содержать не менее 50 символов',
            'text.max' => 'Комментарий должен содержать не более 400 символов',
            'rate.required' => 'Оценка обязательна',
            'rate.min' => 'Оценка должна быть не менее 1',
            'rate.max' => 'Оценка должна быть не более 10',
            'comment_id.exists' => 'Родительский комментарий не найден',
            'film_id.required' => 'Не указан фильм',
            'film_id.exists' => 'Указанный фильм не найден'
        ];
    }
}
