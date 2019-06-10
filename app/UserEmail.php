<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmail extends Model
{
    protected $fillable = [
        'user_role_id', 'email_id', 'sender_user_id',
    ];

    protected $table = 'user_email';

    public function detail_email()
    {
        return $this->belongsto('App\Email', 'email_id');
    }
}
