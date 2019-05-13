<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name', 'status'
    ];

    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }
}
