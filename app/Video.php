<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'name', 'url_video', 'duration', 'unit_id', 'state'
    ];

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
