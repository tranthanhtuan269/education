<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_role_id', 'cv', 'rating_count', 'vote_count', 'rating_score', 'student_count', 'course_count', 'video_intro'
    ];

    // public function user(){
    // 	return $this->belongsTo('App\User');
    // }

    public function userRole()
    {
        return $this->belongsTo('App\UserRole');
    }

    static public function getTeacherBestVote()
    {
        return Teacher::orderBy('rating_score', 'DESC')->take(4)->get();
    }

    static public function getTeacherBestStudent()
    {
        return Teacher::orderBy('student_count', 'DESC')->take(4)->get();
    }
}
