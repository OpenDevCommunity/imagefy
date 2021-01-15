<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    use HasFactory;

    protected $table = 'errors';

    protected $fillable = [
        'user_id' , 'code' , 'file' , 'line' , 'message' , 'trace'
    ];
}
