<?php

namespace App\Helper;

use Auth;
use App\UserCourse;

class Helper
{
    public static function getUserRoleOfCourse($course_id){
        $user_id = Auth::user()->id;
        $user_role_list = Auth::user()->userRoles;

        $demanding_user_course = null;
        
        foreach ($user_role_list as $key => $user_role) {
            $user_course_item = UserCourse::where('course_id', $course_id)
            ->where('user_role_id', $user_role->id)
            ->first();
            
            if(!empty($user_course_item)){
                $demanding_user_course = $user_course_item;
                break;
            }
        }

        return $demanding_user_course;
    }

    public static function convertSecondToTimeFormat($time){
        if($time == 0 ){
            return "0:00";
        }
        
        $hr = (int)($time / 3600);
        $min = (int)(($time % 3600) / 60);
        $sec = $time % 60;
        $sec_min = "";
        if($hr > 0){
            $sec_min = $sec_min . "" . $hr . ":" . ($min < 10 ? "0" : "");

        }
        $sec_min = $sec_min . "" . $min . ":" . ($sec < 10 ? "0" : "");
        $sec_min = $sec_min . "" . $sec;
        return $sec_min;
    }
}