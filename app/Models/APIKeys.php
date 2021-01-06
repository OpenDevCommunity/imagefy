<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIKeys extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'api_key', 'last_used'
    ];

    protected $table = 'api_keys';
}
