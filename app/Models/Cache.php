<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cache
 *
 * @package App\Models
 * @property string $key
 * @property string $value
 * @property int    $expiration
 * @method static Builder<static>|Cache newModelQuery()
 * @method static Builder<static>|Cache newQuery()
 * @method static Builder<static>|Cache query()
 * @method static Builder<static>|Cache whereExpiration($value)
 * @method static Builder<static>|Cache whereKey($value)
 * @method static Builder<static>|Cache whereValue($value)
 * @mixin \Eloquent
 */
class Cache extends Model
{
    protected $table = 'cache';
    protected $primaryKey = 'key';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'expiration' => 'int'
    ];

    protected $fillable = [
        'value',
        'expiration'
    ];
}

