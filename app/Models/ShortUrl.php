<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ShortUrl
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $image_id
 * @property string $original_url
 * @property string $short_url_hash
 * @property string|null $expiries_at
 * @property int $expiried
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereExpiried($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereExpiriesAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereOriginalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereShortUrlHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereName($value)
 */
class ShortUrl extends Model
{
    use HasFactory;

    protected $table = 'short_urls';

    protected $fillable = [
       'user_id', 'image_id', 'original_url', 'short_url_hash',
       'expiries_at', 'expiried', 'name'
    ];
}
