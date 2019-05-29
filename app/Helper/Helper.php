<?php

namespace App\Helper;

use App\UserCourse;
use Auth;
use DateTime;

class Helper
{
    public static function formatDate($format_time, $time, $format)
    {
        return (!empty($time)) ? \Carbon\Carbon::createFromFormat($format_time, $time)->format($format) : '';
    }

    public static function getUserRoleOfCourse($course_id)
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $user_role_list = Auth::user()->userRoles;

            $demanding_user_course = null;

            foreach ($user_role_list as $key => $user_role) {
                $user_course_item = UserCourse::where('course_id', $course_id)
                    ->where('user_role_id', $user_role->id)
                    ->first();

                if (!empty($user_course_item)) {
                    $demanding_user_course = $user_course_item;
                    break;
                }
            }
        }else{
            $demanding_user_course = null;
        }

        return $demanding_user_course;
    }

    public static function convertSecondToTimeFormat($time)
    {
        if ($time == 0) {
            return "0:00";
        }

        $hr = (int) ($time / 3600);
        $min = (int) (($time % 3600) / 60);
        $sec = $time % 60;
        $sec_min = "";
        if ($hr > 0) {
            $sec_min = $sec_min . "" . $hr . ":" . ($min < 10 ? "0" : "");

        }
        $sec_min = $sec_min . "" . $min . ":" . ($sec < 10 ? "0" : "");
        $sec_min = $sec_min . "" . $sec;
        return $sec_min;
    }

    // Hàm so sánh các khoảng thời gian
    public static function handlingTime($date)
    {
        $dt = new DateTime($date);
        return $dt->format('U');
    }

    public static function checkPermissions($permission, $list_roles){
	    if (in_array($permission, $list_roles) || in_array('super-admin', $list_roles)) {
	     	return true;
		}  

		return false;
	}
}
