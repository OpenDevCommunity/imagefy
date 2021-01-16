<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserSettings
 *
 * @property int $id
 * @property int $user_id
 * @property string $default_image_visibility
 * @property int $upload_to_imgur
 * @property int $send_to_discord
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereDefaultImageVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereSendToDiscord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereUploadToImgur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSettings whereUserId($value)
 * @mixin \Eloquent
 */
class UserSettings extends Model
{
    use HasFactory;

    protected $table = 'user_settings';

    protected $fillable = [
      'user_id', 'default_image_visibility', 'upload_to_imgur',
      'send_to_discord'
    ];
}
