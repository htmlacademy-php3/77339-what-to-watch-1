<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GenreFilm
 *
 * @package App\Models
 * @property int $film_id
 * @property int $genre_id
 * @property-read \App\Models\Film $film
 * @property-read \App\Models\Genre $genre
 * @method static Builder<static>|GenreFilm newModelQuery()
 * @method static Builder<static>|GenreFilm newQuery()
 * @method static Builder<static>|GenreFilm query()
 * @method static Builder<static>|GenreFilm whereFilmId($value)
 * @method static Builder<static>|GenreFilm whereGenreId($value)
 * @mixin \Eloquent
 */
class GenreFilm extends Model
{
	protected $table = 'genre_films';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'film_id' => 'int',
		'genre_id' => 'int'
	];

	public function film() : BelongsTo
    {
		return $this->belongsTo(Film::class);
	}

	public function genre() : BelongsTo
    {
		return $this->belongsTo(Genre::class);
	}
}
