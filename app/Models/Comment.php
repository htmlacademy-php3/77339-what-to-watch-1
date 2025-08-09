<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Comment
 *
 * @package       App\Models
 * @property      int                           $id
 * @property      string                        $text
 * @property      string                        $author
 * @property      int|null                      $rate
 * @property      int|null                      $comment_id
 * @property      int                           $user_id
 * @property      int                           $film_id
 * @property      Carbon|null                   $created_at
 * @property      Carbon|null                   $updated_at
 * @property-read Comment|null             $comment
 * @property-read Collection<int, Comment> $comments
 * @property-read int|null                 $comments_count
 * @property-read Film                     $film
 * @property-read User                     $user
 * @method        static Builder<static>|Comment newModelQuery()
 * @method        static Builder<static>|Comment newQuery()
 * @method        static Builder<static>|Comment query()
 * @method        static Builder<static>|Comment whereAuthor($value)
 * @method        static Builder<static>|Comment whereCommentId($value)
 * @method        static Builder<static>|Comment whereContent($value)
 * @method        static Builder<static>|Comment whereCreatedAt($value)
 * @method        static Builder<static>|Comment whereFilmId($value)
 * @method        static Builder<static>|Comment whereId($value)
 * @method        static Builder<static>|Comment whereRate($value)
 * @method        static Builder<static>|Comment whereUpdatedAt($value)
 * @method        static Builder<static>|Comment whereUserId($value)
 * @method        static Model|static         create(array $attributes = [])
 * @method        static Collection|static[] pluck(string $column, string|null $key = null)
 * @method        static Model|static findOrFail(int $id)
 * @method        static Model|static firstOrCreate(array $attributes, array $values = [])
 * @property-read Comment|null $parentComment
 * @property-read Collection<int, Comment> $replies
 * @property-read int|null $replies_count
 * @method        static CommentFactory factory($count = null, $state = [])
 * @method        static Builder<static>|Comment whereText($value)
 * @mixin         Eloquent
 *
 * @psalm-suppress MissingTemplateParam
 */
class Comment extends Model
{
    use HasFactory;

    public const string DEFAULT_AUTHOR_NAME = "Гость";

    protected $table = 'comments';

    protected $casts = [
        'rate' => 'int',
        'comment_id' => 'int',
        'user_id' => 'int',
        'film_id' => 'int'
    ];

    protected $fillable = [
        'text',
        'author',
        'rate',
        'comment_id',
        'user_id',
        'film_id'
    ];

    /**
     * Родительский комментарий
     *
     * @return         BelongsTo
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    /**
     * Связь с фильмом, к которому относится комментарий.
     *
     * @return         BelongsTo
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    /**
     * Связь с пользователем, который оставил комментарий.
     *
     * @return         BelongsTo
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ответы на этот комментарий (дочерние)
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'comment_id');
    }

    /**
     * Получить имя автора комментария
     *
     * @return         string
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function getAuthorName(): string
    {
        return $this->user ? $this->user->name : self::DEFAULT_AUTHOR_NAME;
    }

    /**
     * Удаление комментария с ответами
     */
    public function deleteWithReplies(): void
    {
        $this->replies->each(
            function ($reply) {
                $reply->deleteWithReplies();
            }
        );

        $this->delete();
    }
}
