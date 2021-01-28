<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Error
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $code
 * @property string $file
 * @property int $line
 * @property string $message
 * @property string $trace
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Error newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Error newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Error query()
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereTrace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Error whereUserId($value)
 * @mixin \Eloquent
 */
class Error extends Model
{
    use HasFactory;

    protected $table = 'errors';

    protected $fillable = [
        'user_id' , 'code' , 'file' , 'line' , 'message' , 'trace'
    ];
}
