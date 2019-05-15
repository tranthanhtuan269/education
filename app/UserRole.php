<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [
        'user_id', 'role_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // public function teacher()
    // {
    // 	return $this->hasMany('App\Teacher');
    // }

    public function teacher()
    {
    	return $this->hasOne('App\Teacher');
    }
}
