<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentVideo extends Model
{
    protected $fillable = [
        'content', 'video_id', 'parent_id', 'state'
    ];

    public function video(){
    	return $this->belongsTo('App\Video');
    }

    public function parent(){
    	return $this->belongsTo('App\CommentVideo', 'parent_id');
    }

    public function children(){
    	return $this->hasMany('App\CommentVideo', 'parent_id');
    }
}
