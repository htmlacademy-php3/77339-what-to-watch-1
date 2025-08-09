<?php

namespace App\Http\Resources;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

/**
 * @mixin Genre
 *
 * Ресурс жанров для API-ответов.
 */
class GenreResource extends JsonResource
{
    /**
     * Преобразует ресурс в массив для JSON-ответа.
     *
     * @return (int|string)[]
     *
     * @psalm-return array{id: int, name: string}
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
