<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\APILog
 *
 * @property int $id
 * @property int $api_key_id
 * @property string|null $origin
 * @property string|null $method
 * @property string|null $endpoint
 * @property string|null $status
 * @property string|null $headers
 * @property string|null $body
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|APILog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|APILog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|APILog query()
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereApiKeyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereEndpoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|APILog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class APILog extends Model
{
    use HasFactory;

    protected  $table = 'api_log';

    protected $fillable = [
      'origin', 'method', 'endpoint', 'status', 'headers', 'body', 'api_key_id'
    ];
}
