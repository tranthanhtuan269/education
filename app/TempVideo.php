<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempVideo extends Model
{
    protected $fillable = [
        'video_id', 'name', 'link_video', 'duration', 'description', 'unit_id', 'files_delete'
    ];

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function documents(){
        return $this->hasMany('App\Document');
    }
}
