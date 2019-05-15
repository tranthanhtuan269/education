<?php

namespace App\Helper;

use Auth;
use App\UserCourse;

class Helper
{
    public static function getUserRoleOfCourse($course_id){
        $user_id = Auth::user()->id;
        $user_role_list = Auth::user()->userRoles;

        $demanding_user_role = null;
        foreach ($user_role_list as $key => $user_role_item) {
            $user_course_item = UserCourse::where('course_id', $course_id)->where('user_role_id', $user_role_item->id)->first();
            if(!empty($user_course_item)){
                $demanding_user_role = $user_course_item;
                break;
            }
        }

        return $demanding_user_role;
    }
}