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
        return $this->hasMany('App\Video')->whereIn('state', [1,2,3,4])->orderBy('index', 'asc');
    }

    public function videosNoState()
    {
        return $this->hasMany('App\Video')->orderBy('index', 'asc');
    }

    public function videosLessonList()
    {
        return $this->hasMany('App\Video')->whereIn('state', [0,1,2,3,4])->orderBy('index', 'asc');
    }

    public function timeLessonActive()
    {
        return $this->hasMany('App\Video')->whereIn('state', [1,2,3,4])->orderBy('index', 'asc');
    }
}
