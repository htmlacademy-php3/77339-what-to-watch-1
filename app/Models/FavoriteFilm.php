<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class FavoriteFilm
 *
 * @package App\Models
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $film_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Film                       $film
 * @property-read User                       $user
 * @method static Builder<static>|FavoriteFilm newModelQuery()
 * @method static Builder<static>|FavoriteFilm newQuery()
 * @method static Builder<static>|FavoriteFilm query()
 * @method static Builder<static>|FavoriteFilm whereCreatedAt($value)
 * @method static Builder<static>|FavoriteFilm whereFilmId($value)
 * @method static Builder<static>|FavoriteFilm whereId($value)
 * @method static Builder<static>|FavoriteFilm whereUpdatedAt($value)
 * @method static Builder<static>|FavoriteFilm whereUserId($value)
 * @mixin \Eloquent
 */
class FavoriteFilm extends Model
{
    protected $table = 'favorite_films';

    protected $casts = [
        'user_id' => 'int',
        'film_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'film_id'
    ];

    public function film() : BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
