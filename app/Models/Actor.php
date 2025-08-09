<?php

namespace App\Models;

use Database\Factories\ActorFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class Actor
 *
 * @package       App\Models
 * @property      int                        $id
 * @property      string                     $name
 * @property      Carbon|null                $created_at
 * @property      Carbon|null                $updated_at
 * @property-read Collection<int, Film> $films
 * @property-read int|null              $films_count
 * @method        static Builder|Actor newModelQuery()
 * @method        static Builder|Actor newQuery()
 * @method        static Builder|Actor query()
 * @method        static Builder|Actor whereId($value)
 * @method        static Builder|Actor whereName($value)
 * @method        static Builder|Actor whereCreatedAt($value)
 * @method        static Builder|Actor whereUpdatedAt($value)
 * @method        static Collection|static[] pluck(string $column, string|null $key = null)
 * @method        static Model|static findOrFail(int $id)
 * @method        static Model|static firstOrCreate(array $attributes, array $values = [])
 * @method        static ActorFactory factory($count = null, $state = [])
 * @mixin         Eloquent
 *
 * @psalm-suppress MissingTemplateParam
 */
class Actor extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return         BelongsToMany
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'actor_film');
    }
}
