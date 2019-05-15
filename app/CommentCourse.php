<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentCourse extends Model
{
    protected $fillable = [
        'content', 'user_id', 'course_id', 'parent_id', 'state'
    ];

    public function course(){
    	return $this->belongsTo('App\Course');
    }

    public function parent(){
    	return $this->belongsTo('App\CommentCourse', 'parent_id');
    }

    public function children(){
    	return $this->hasMany('App\CommentCourse', 'parent_id');
    }
}
