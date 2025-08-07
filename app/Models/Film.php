<?php

namespace App\Models;

use Closure;
use Database\Factories\FilmFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class Film
 *
 * @package       App\Models
 * @property      int                                $id
 * @property      string                             $name
 * @property      string                             $title
 * @property      string|null                        $released
 * @property      string|null                        $description
 * @property      string|null                        $director
 * @property      string|null                        $run_time
 * @property      float|null                         $rating
 * @property      int|null                           $imdb_votes
 * @property      string|null                        $imdb_id
 * @property      string|null                        $poster_image
 * @property      string|null                        $preview_image
 * @property      string|null                        $background_image
 * @property      string|null                        $background_color
 * @property      string|null                        $video_link
 * @property      string|null                        $preview_video_link
 * @property      Carbon|null                        $created_at
 * @property      string|null                        $added_at
 * @property      Carbon|null                        $updated_at
 * @property-read Collection<int, Comment>      $comments
 * @property-read int|null                      $comments_count
 * @property-read Collection<int, FavoriteFilm> $favorite_films
 * @property-read int|null                      $favorite_films_count
 * @property-read Collection<int, Genre>        $genres
 * @property-read int|null                      $genres_count
 * @property-read float|null                    $calculated_rating Средняя оценка по комментариям (accessor)
 * @method        static Builder|Film whereName($value)
 * @method        static Builder|Film whereReleased($value)
 * @method        static Builder|Film whereRunTime($value)
 * @method        static Builder|Film wherePosterImage($value)
 * @method        static Builder|Film wherePreviewImage($value)
 * @method        static Builder|Film whereBackgroundImage($value)
 * @method        static Builder|Film whereVideoLink($value)
 * @method        static Builder|Film wherePreviewVideoLink($value)
 * @method        static Model|static         create(array $attributes = [])
 * @method        static Builder|Film         where(string $column, $operator = null, $value = null, string $boolean = 'and')
 * @method        static User|null            first(array $columns = ['*'])
 * @method        static Collection|static[] pluck(string $column, string|null $key = null)
 * @method        static Model|static firstOrCreate(array $attributes, array $values = [])
 * @property      string                             $status
 * @property      bool                               $is_promo Флаг промо-фильма
 * @property-read Collection<int, Actor>        $actors
 * @property-read int|null                      $actors_count
 * @property-read Collection<int, Director>     $directors
 * @property-read int|null                      $directors_count
 * @property-read Collection<int, FavoriteFilm> $favoriteFilms
 * @property-read Collection<int, User>         $favorites
 * @property-read int|null                      $favorites_count
 * @property-read Collection<int, User>         $usersWhoFavorited
 * @property-read int|null                      $users_who_favorited_count
 * @method        static FilmFactory factory($count = null, $state = [])
 * @method        static Builder<static>|Film newModelQuery()
 * @method        static Builder<static>|Film whereBackgroundColor($value)
 * @method        static Builder<static>|Film whereCreatedAt($value)
 * @method        static Builder<static>|Film whereDescription($value)
 * @method        static Builder<static>|Film whereId($value)
 * @method        static Builder<static>|Film whereImdbId($value)
 * @method        static Builder<static>|Film whereImdbVotes($value)
 * @method        static Builder<static>|Film whereIsPromo($value)
 * @method        static Builder<static>|Film whereRating($value)
 * @method        static Builder<static>|Film whereStatus($value)
 * @method        static Builder<static>|Film whereUpdatedAt($value)
 * @method        static Builder<static>|Film with($relations)
 * @method        static Builder<self> newQuery()
 * @method        static Builder<self> query()
 * @method        static Builder<self> whereHas(string $relation, Closure $callback = null, string $operator = '>=', int $count = 1)
 * @method        static self findOrFail(mixed $id, array $columns = ['*'])
 *
 * @mixin Eloquent
 */
class Film extends Model
{
    use HasFactory;

    public const string STATUS_PENDING = 'pending';
    public const string STATUS_MODERATE = 'moderate';
    public const string STATUS_READY = 'ready';
    public bool $is_favorite = false;

    protected $table = 'films';

    protected $fillable = [
        'name',
        'status',
        'released',
        'description',
        'director',
        'run_time',
        'rating',
        'imdb_votes',
        'imdb_id',
        'poster_image',
        'preview_image',
        'background_image',
        'background_color',
        'video_link',
        'preview_video_link',
        'is_promo',
    ];

    protected $casts = [
        'rating' => 'float',
        'imdb_votes' => 'integer',
        'is_promo' => 'boolean',
    ];

    /**
     * Получить все комментарии, связанные с фильмом.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Получить все записи об избранных фильмах, в которых указан этот фильм.
     *
     * @return HasMany
     */
    public function favoriteFilms(): HasMany
    {
        return $this->hasMany(FavoriteFilm::class);
    }

    /**
     * Получить всех пользователей, добавивших фильм в избранное.
     *
     * @return         BelongsToMany
     */
    public function usersWhoFavorited(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_films', 'film_id', 'user_id')->withTimestamps();
    }

    /**
     * Получить жанры, к которым относится фильм.
     *
     * @return BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_film');
    }

    /**
     * Получить актёров, участвующих в фильме.
     *
     * @return BelongsToMany
     */
    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class, 'actor_film');
    }

    /**
     * Получить режиссёров, снявших фильм.
     *
     * @return BelongsToMany
     */
    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(Director::class, 'director_film');
    }

    /**
     * Получить среднюю оценку фильма на основе пользовательских комментариев.
     *
     * @return         float|null
     */
    public function getRatingAttribute(): ?float
    {
        $avg =
            $this->comments()->avg('rate');

        return $avg !== null ? round($avg, 1) : null;
    }

    /**
     * Отношение с пользователями, добавившими фильм в избранное
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'favorite_films',
            'film_id',
            'user_id'
        )->withTimestamps();
    }
}
