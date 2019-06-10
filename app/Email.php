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
}
