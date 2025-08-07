<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Class User
 *
 * @property      int                                $id
 * @property      int                                $role
 * @property      string|null                        $avatar
 * @property      string                             $name
 * @property      string                             $email
 * @property      Carbon|null                        $email_verified_at
 * @property      string                             $password
 * @property      string|null                        $remember_token
 * @property      Carbon|null                        $created_at
 * @property      Carbon|null                        $updated_at
 * @property-read Collection<int, Comment>      $comments
 * @property-read Collection<int, FavoriteFilm> $favorite_films
 * @property-read Collection<int, Film>         $favoriteFilms
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read Collection<int, PersonalAccessToken>     $tokens
 *
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User where(string $column, $operator = null, $value = null, string $boolean = 'and')
 * @method static User|null first(array $columns = ['*'])
 * @method static Model|static create(array $attributes = [])
 * @method static Model|static findOrFail(int $id)
 * @method static Model|static firstOrCreate(array $attributes, array $values = [])
 * @method NewAccessToken createToken(string $name, array $abilities = [])
 * @method static Collection|static[] pluck(string $column, string|null $key = null)
 *
 * @mixin Eloquent
 * @mixin HasApiTokens<User>
 * @mixin HasFactory<User>
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    public const int ROLE_USER = 1;
    public const int ROLE_MODERATOR = 2;

    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'integer',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'role',
        'avatar',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * @return         HasMany<Comment>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function favoriteFilms(): BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'favorite_films')
            ->withTimestamps();
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }
}
