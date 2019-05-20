<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentVideo extends Model
{
    protected $fillable = [
        'content', 'user_role_id', 'video_id', 'parent_id', 'state'
    ];
    
    public function userRole(){
        return $this->belongsTo('App\UserRole');
    }
    
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
