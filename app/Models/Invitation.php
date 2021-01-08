<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
      'email', 'invitation_token', 'registered_at'
    ];

    public function getLink() {
        return urldecode(route('register') . '?invitation_token=' . $this->invitation_token);
    }



    public function generateInvitationToken() {
        $this->invitation_token = substr(md5(rand(0, 9) . $this->email . time()), 0, 32);
    }
}
