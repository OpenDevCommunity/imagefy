<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property int $user_id
 * @property string $image_del_hash
 * @property string|null $image_share_hash
 * @property string $image_name
 * @property string|null $title
 * @property string|null $description
 * @property int $public
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageDelHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageShareHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUserId($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    use HasFactory;

    protected $table = 'images';
    protected $fillable = [
      'user_id', 'image_del_hash', 'image_name', 'public', 'image_share_hash'
    ];


    public function ShortUrls()
    {
        return $this->hasMany(ShortUrl::class, 'image_id', 'id')
            ->orderBy('created_at', 'desc')->take(5);
    }
}
