<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'name', 'index', 'course', 'video_count'
    ];
    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function videos()
    {
        return $this->hasMany('App\Video')->whereIn('state', [1,2,4])->orderBy('index', 'asc');
    }

    public function videosNoState()
    {
        return $this->hasMany('App\Video')->orderBy('index', 'asc');
    }
}
