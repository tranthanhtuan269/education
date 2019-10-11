<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_role_id', 'cv', 'rating_count', 'vote_count', 'expert', 'rating_score', 'student_count', 'course_count', 'video_intro', 'status'
    ];

    // public function user(){
    // 	return $this->belongsTo('App\User');
    // }

    public function userRole()
    {
        return $this->belongsTo('App\UserRole');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'user_courses', 'user_role_id');
    }

    static public function getTeacherBestVote($cat_id=null)
    {
        if($cat_id == null){
            $arr_check =  Teacher::join('user_courses', 'user_courses.user_role_id', '=', 'teachers.user_role_id')
                    ->join('courses', 'courses.id', '=', 'user_courses.course_id')
                    ->select('teachers.user_role_id')
                    ->where('courses.status', 1)
                    ->where('teachers.status', 1)
                    ->groupBy('teachers.user_role_id')
                    ->pluck('user_role_id');
    
            return Teacher::orderBy('rating_score', 'DESC')->whereIn('user_role_id', $arr_check)->take(4)->get();
        }
        $arr_check =  Teacher::join('user_courses', 'user_courses.user_role_id', '=', 'teachers.user_role_id')
                    ->join('courses', 'courses.id', '=', 'user_courses.course_id')
                    ->select('teachers.user_role_id')
                    ->where('courses.status', 1)
                    ->where('courses.category_id', $cat_id)
                    ->where('teachers.status', 1)
                    ->groupBy('teachers.user_role_id')
                    ->pluck('user_role_id');

        return Teacher::orderBy('rating_score', 'DESC')->whereIn('user_role_id', $arr_check)->take(4)->get();

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

    public static function getFeatureTeacher()
    {
        $arr_check =  Teacher::where('featured', 1);
        if( isset($arr_check->first()->id) ){
            $arr_check->where('featured_index','<>' ,0)
                      ->where('status', 1)
                      ->orderBy('featured_index', 'ASC');
        }else{
            $arr_check = Teacher::where('status', 1)
                        ->whereHas('userRole', function ($query) {
                            $query->whereHas('user', function ($query) {
                                $query->where('status', 1);
                            });
                        })
                        ->orderBy('student_count', 'DESC');
        }
        return $arr_check->take(4)->get();
    }

    public static function getFeatureTeacherForAdmin()
    {
        return \DB::table('courses')
        ->join('user_courses', 'user_courses.course_id', '=', 'courses.id')
        ->join('user_roles', 'user_roles.id', '=', 'user_courses.user_role_id')
        ->join('teachers', 'teachers.user_role_id', '=', 'user_roles.id')
        ->join('users', 'users.id', '=','user_roles.user_id')
        ->where('teachers.status', 1)
        ->where('users.status', 1)
        ->where('courses.status', 1)
        ->orderBy('teachers.student_count', 'desc')
        ->groupBy('teachers.id', 'users.name', 'teachers.student_count', 'teachers.featured_index')
        ->select('teachers.id as id', 'users.name as name', 'teachers.featured as featured', 'teachers.featured_index as featured_index');
    }
}
