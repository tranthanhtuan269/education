<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'from', 'to', 'content'
    ];

    public function from()
    {
        return $this->hasOne('App\User', 'from');
    }

    public function to()
    {
        return $this->hasOne('App\User', 'to');
    }
}
