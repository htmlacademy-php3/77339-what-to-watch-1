<?php

namespace App\Models;

use Database\Factories\DirectorFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class Director
 *
 * @package       App\Models
 * @property      int                          $id
 * @property      string                       $name
 * @property      Carbon|null                  $created_at
 * @property      Carbon|null                  $updated_at
 * @property-read Collection<int, Film>   $films
 * @property-read int|null                $films_count
 * @method        static Builder|Director newModelQuery()
 * @method        static Builder|Director newQuery()
 * @method        static Builder|Director query()
 * @method        static Builder|Director whereId($value)
 * @method        static Builder|Director whereName($value)
 * @method        static Builder|Director whereCreatedAt($value)
 * @method        static Builder|Director whereUpdatedAt($value)
 * @method        static Collection|static[] pluck(string $column, string|null $key = null)
 * @method        static Model|static findOrFail(int $id)
 * @method        static Model|static firstOrCreate(array $attributes, array $values = [])
 * @method        static DirectorFactory factory($count = null, $state = [])
 * @mixin         Eloquent
 *
 * @psalm-suppress MissingTemplateParam
 */
class Director extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return         BelongsToMany
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'director_film');
    }
}
