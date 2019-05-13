<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name', 'course', 'video_count'
    ];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function videos()
    {
        return $this->hasMany('App\Videos');
    }
}
