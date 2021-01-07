<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\APIKeys
 *
 * @property int $id
 * @property int $user_id
 * @property string $api_key
 * @property string|null $last_used
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys query()
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys whereLastUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APIKeys whereUserId($value)
 * @mixin \Eloquent
 */
class APIKeys extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'api_key', 'last_used'
    ];

    protected $table = 'api_keys';
}
