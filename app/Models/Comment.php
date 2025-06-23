<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Comment
 *
 * @package App\Models
 * @property int                             $id
 * @property string                          $content
 * @property string                          $author
 * @property int|null                        $rate
 * @property int|null                        $comment_id
 * @property int                             $user_id
 * @property int                             $film_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Comment|null               $comment
 * @property-read Collection<int, Comment>   $comments
 * @property-read int|null                   $comments_count
 * @property-read Film                       $film
 * @property-read User                       $user
 * @method static Builder<static>|Comment newModelQuery()
 * @method static Builder<static>|Comment newQuery()
 * @method static Builder<static>|Comment query()
 * @method static Builder<static>|Comment whereAuthor($value)
 * @method static Builder<static>|Comment whereCommentId($value)
 * @method static Builder<static>|Comment whereContent($value)
 * @method static Builder<static>|Comment whereCreatedAt($value)
 * @method static Builder<static>|Comment whereFilmId($value)
 * @method static Builder<static>|Comment whereId($value)
 * @method static Builder<static>|Comment whereRate($value)
 * @method static Builder<static>|Comment whereUpdatedAt($value)
 * @method static Builder<static>|Comment whereUserId($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    protected $table = 'comments';

    protected $casts = [
        'rate' => 'int',
        'comment_id' => 'int',
        'user_id' => 'int',
        'film_id' => 'int'
    ];

    protected $fillable = [
        'content',
        'author',
        'rate',
        'comment_id',
        'user_id',
        'film_id'
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function film() : BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
