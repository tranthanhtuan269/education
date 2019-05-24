<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [
        'user_id', 'role_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // public function teacher()
    // {
    // 	return $this->hasMany('App\Teacher');
    // }

    public function teacher()
    {
    	return $this->hasOne('App\Teacher');
    }

    public function userCoursesByFeature()
    {
        return $this->belongsToMany('App\Course', 'user_courses')->where('featured', 1)->orderBy('featured_index', 'asc')->get();
    }

    public function userCoursesByTrendding()
    {
        return $this->belongsToMany('App\Course', 'user_courses')->orderBy('sale_count', 'asc')->get();
    }

    public function userCoursesByNew()
    {
        return $this->belongsToMany('App\Course', 'user_courses')->orderBy('id', 'desc')->get();
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'user_courses');

    public function userLifelongCourse($keyword)
    {
        if ($keyword != '') {
            return $this->belongsToMany('App\Course', 'user_courses')->where('name', 'LIKE', "%$keyword%")->paginate(4);
        }
        return $this->belongsToMany('App\Course', 'user_courses')->paginate(4);
    }
}
