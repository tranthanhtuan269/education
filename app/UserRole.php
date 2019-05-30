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

    public function role()
    {
    	return $this->belongsTo('App\Role','role_id');
    }

    public function order()
    {
    	return $this->hasMany('App\Order', 'user_id');
    }

    public function orderDetail($id) {
    	return $this->order()->where('id', $id)->get();
    }

    public function teacher()
    {
    	return $this->hasOne('App\Teacher', 'user_role_id');
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

    }
    
    public function userLifelongCourse($keyword)
    {
        if ($keyword != '') {
            return $this->belongsToMany('App\Course', 'user_courses')->where('name', 'LIKE', "%$keyword%")->paginate(4);
        }
        return $this->belongsToMany('App\Course', 'user_courses')->paginate(4);
    }
    
}
