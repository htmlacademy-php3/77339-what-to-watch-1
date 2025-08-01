<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Genre
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection<int, \App\Models\Film> $films
 * @property-read int|null $films_count
 * @method static Builder<static>|Genre newModelQuery()
 * @method static Builder<static>|Genre newQuery()
 * @method static Builder<static>|Genre query()
 * @method static Builder<static>|Genre whereCreatedAt($value)
 * @method static Builder<static>|Genre whereId($value)
 * @method static Builder<static>|Genre whereName($value)
 * @method static Builder<static>|Genre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Genre extends Model
{
	use HasFactory;
	
	protected $table = 'genres';

	protected $fillable = [
		'name'
	];

	public function films() : BelongsToMany
    {
		return $this->belongsToMany(Film::class, 'genre_films');
	}
}
