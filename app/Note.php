<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'content', 'video_id', 'user_id', 'time_tick'
    ];

    public function video(){
    	return $this->belongsTo('App\Video');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
