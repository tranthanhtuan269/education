<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helper\Helper;
use Auth;

class Email extends Model
{
    protected $fillable = [
        'title', 
        'content',
        'create_user_id',
        'update_user_id'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_email', 'email_id', 'user_id');
    }
}
