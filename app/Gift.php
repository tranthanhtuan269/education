<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'user_role_id','course_id'
    ];

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
