<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\APIKey
 *
 * @property int $id
 * @property int $user_id
 * @property string $api_key
 * @property string|null $last_used
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey query()
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey whereLastUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKey whereUserId($value)
 * @mixin \Eloquent
 */
class APIKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'api_key', 'last_used'
    ];

    protected $table = 'api_keys';

    protected $casts = [
      'last_used' => 'datetime'
    ];
}
