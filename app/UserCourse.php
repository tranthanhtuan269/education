<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    protected $fillable = [
        'user_role_id', 'course_id', 'status'
    ];

    // public function course()
    // {
    //     return $this->hasMany('App\Course','course_id');
    // }

}
