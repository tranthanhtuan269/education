<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_role_id', 'cv', 'rating_count', 'vote_count', 'expert', 'rating_score', 'student_count', 'course_count', 'video_intro'
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

    public static function delMulti($id_list){
        $checkTeacher = Teacher::whereIn('id', $id_list);
        return ($checkTeacher->delete() > 0);
    }

    public static function acceptMulti($id_list, $status){
        $checkTeacher = Teacher::whereIn('id', $id_list);
        return ($checkTeacher->update(['status' => $status]) > 0);
    }
}
