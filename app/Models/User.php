<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
/**
 * Class User
 *
 * @package App\Models
 * @property int                                            $id
 * @property string                                         $role
 * @property string|null                        $avatar
 * @property string                             $name
 * @property string                             $email
 * @property Carbon|null                        $email_verified_at
 * @property string                             $password
 * @property string|null                        $remember_token
 * @property Carbon|null                        $created_at
 * @property Carbon|null                        $updated_at
 * @property-read Collection<int, Comment>      $comments
 * @property-read int|null                      $comments_count
 * @property-read Collection<int, FavoriteFilm> $favorite_films
 * @property-read int|null                      $favorite_films_count
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereAvatar($value)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereRole($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    const int ROLE_USER = 1;
    const int ROLE_MODERATOR = 2;
    protected $table = 'users';
    protected $casts = [
        'email_verified_at' => 'datetime'
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
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function favoriteFilms() : BelongsToMany
    {
        return $this->belongsToMany(Film::class, 'favorite_films', 'user_id', 'film_id')
            ->withTimestamps();
    }

    public function isModerator() : bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }
}