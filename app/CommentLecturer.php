<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentLecturer extends Model
{
    protected $fillable = [
        'content', 'user_id', 'lecturer_id', 'parent_id', 'state'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function lecturer(){
    	return $this->belongsTo('App\User', 'lecturer_id');
    }

    public function parent(){
    	return $this->belongsTo('App\CommentLecturer', 'parent_id');
    }

    public function children(){
    	return $this->hasMany('App\CommentLecturer', 'parent_id');
    }
}
