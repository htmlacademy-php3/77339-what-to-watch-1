<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Database\Factories\FavoriteFilmFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class FavoriteFilm
 *
 * @package       App\Models
 * @property      int                             $id
 * @property      int                             $user_id
 * @property      int                             $film_id
 * @property      string|null $added_at
 * @property      Carbon|null $created_at
 * @property      Carbon|null $updated_at
 * @property-read Film                       $film
 * @property-read User                       $user
 * @method        static Builder<static>|FavoriteFilm newModelQuery()
 * @method        static Builder<static>|FavoriteFilm newQuery()
 * @method        static Builder<static>|FavoriteFilm query()
 * @method        static Builder<static>|FavoriteFilm whereCreatedAt($value)
 * @method        static Builder<static>|FavoriteFilm whereFilmId($value)
 * @method        static Builder<static>|FavoriteFilm whereId($value)
 * @method        static Builder<static>|FavoriteFilm whereUpdatedAt($value)
 * @method        static Builder<static>|FavoriteFilm whereUserId($value)
 * @method        static Model|static         create(array $attributes = [])
 * @method        static Builder|FavoriteFilm where(string $column, $operator = null, $value = null, string $boolean = 'and')
 * @method        static User|null            first(array $columns = ['*'])
 * @method        static Collection|static[] pluck(string $column, string|null $key = null)
 * @method        static Model|static findOrFail(int $id)
 * @method        static Model|static firstOrCreate(array $attributes, array $values = [])
 * @method        static FavoriteFilmFactory factory($count = null, $state = [])
 * @method        static Builder<static>|Film with($relations)
 *
 * @mixin Eloquent
 */
class FavoriteFilm extends Model
{
    use HasFactory;

    protected $table = 'favorite_films';

    protected $casts = [
        'user_id' => 'int',
        'film_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'film_id'
    ];

    /**
     * @return         BelongsTo
     */
    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    /**
     * @return         BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
