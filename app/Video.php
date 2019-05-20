<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'name', 'index', 'url_video', 'duration', 'unit_id', 'state'
    ];

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function documents(){
        return $this->hasMany('App\Document');
    }
}
