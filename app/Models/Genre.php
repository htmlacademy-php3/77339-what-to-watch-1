<?php

namespace App\Models;

use Database\Factories\GenreFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class Genre
 *
 * @package       App\Models
 * @property      int                        $id
 * @property      string                     $name
 * @property      Carbon|null                $created_at
 * @property      Carbon|null                $updated_at
 * @property-read Collection<int, Film> $films
 * @property-read int|null              $films_count
 * @method        static Builder<static>|Genre newModelQuery()
 * @method        static Builder<static>|Genre newQuery()
 * @method        static Builder<static>|Genre query()
 * @method        static Builder<static>|Genre whereCreatedAt($value)
 * @method        static Builder<static>|Genre whereId($value)
 * @method        static Builder<static>|Genre whereName($value)
 * @method        static Builder<static>|Genre whereUpdatedAt($value)
 * @method        static Collection|static[] pluck(string $column, string|null $key = null)
 * @method        static Model|static findOrFail(int $id)
 * @method        static Model|static firstOrCreate(array $attributes, array $values = [])
 * @method        static GenreFactory factory($count = null, $state = [])
 * @mixin         Eloquent
 *
 * @psalm-suppress MissingTemplateParam
 */
class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';

    protected $fillable = [
        'name'
    ];

    /**
     * @psalm-suppress PossiblyUnusedMethod
     * Laravel использует динамически
     */
    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'genre_film');
    }
}
