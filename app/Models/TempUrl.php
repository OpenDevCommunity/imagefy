<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TempUrl
 *
 * @property int $id
 * @property int $image_id
 * @property string $share_url
 * @property string $expiries_at
 * @property int $expiried
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl query()
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl whereExpiried($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl whereExpiriesAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl whereShareUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TempUrl whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TempUrl extends Model
{
    use HasFactory;

    protected $table = 'image_tempurls';

    protected $fillable = [
      'image_id', 'share_url', 'expiries_at', 'expiried'
    ];
}
