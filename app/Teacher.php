<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_role_id', 'cv', 'rating_count', 'vote_count', 'student_count', 'course_count', 'video_intro'
    ];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
