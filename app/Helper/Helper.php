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
    
    public static function getUserRoleOfTeacher($teacher_id)
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $user_role_list = Auth::user()->userRoles;

            $demanding_user_course = null;
            $list_course_by_teacher = UserCourse::where('user_role_id', $teacher_id)->pluck('course_id')->toArray();
            foreach ($user_role_list as $key => $user_role) {
                $user_course_item = UserCourse::whereIn('course_id', $list_course_by_teacher)
                    ->where('user_role_id', $user_role->id)
                    ->first();
                    // dd($user_course_item);
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

    public static function convertVideoToMultiResolution($video){

        $input = public_path('/uploads/videos/').$video;
        $output_1080 = public_path('/uploads/videos_output/1080/').$video;
        $output_720 = public_path('/uploads/videos_output/720/').$video;
        $output_480 = public_path('/uploads/videos_output/480/').$video;
        $output_360 = public_path('/uploads/videos_output/360/').$video;
        $block_txt = public_path('/uploads/block_'.$video.'.txt');


        $format = 'mp4';
        $avcodec = '-c:v libx264 -strict -2';
        $time = '-ss ' . "00:00:00";
        
        $bitrate_1080 = '-vf scale=1080:-2';
        $bitrate_720 = '-vf scale=720:-2';
        $bitrate_480 = '-vf scale=480:-2';
        $bitrate_360 = '-vf scale=360:-2';
		
        $command_1080 = config('config.path_ffmpeg_exe') .' -i '.$input.' '.$time.' '.$avcodec.' '.$bitrate_1080.' '.$output_1080.' 1> '.$block_txt.' 2>&1';
        dd($command_1080);
		exec($command_1080, $output2, $return);
		if ($return) {
	    	if(file_exists($output_1080)){
	        	unlink($output_1080);
	    	}
	    	
	    	if(file_exists($block_txt)){
	        	unlink($block_txt);
            }
            
            $command_720 = config('config.path_ffmpeg_exe') .' -i '.$input.' '.$time.' '.$avcodec.' '.$bitrate_720.' '.$output_720.' 1> '.$block_txt.' 2>&1';
            exec($command_720, $output2, $return);
            if ($return) {
                if(file_exists($output_720)){
                    unlink($output_720);
                }
                
                if(file_exists($block_txt)){
                    unlink($block_txt);
                }

                $command_480 = config('config.path_ffmpeg_exe') .' -i '.$input.' '.$time.' '.$avcodec.' '.$bitrate_480.' '.$output_480.' 1> '.$block_txt.' 2>&1';
                exec($command_480, $output2, $return);
                if ($return) {
                    if(file_exists($output_480)){
                        unlink($output_480);
                    }
                    
                    if(file_exists($block_txt)){
                        unlink($block_txt);
                    }

                    $command_360 = config('config.path_ffmpeg_exe') .' -i '.$input.' '.$time.' '.$avcodec.' '.$bitrate_360.' '.$output_360.' 1> '.$block_txt.' 2>&1';
                    exec($command_360, $output2, $return);
                    if ($return) {
                        if(file_exists($output_360)){
                            unlink($output_360);
                        }
                        
                        if(file_exists($block_txt)){
                            unlink($block_txt);
                        }

                        return '{"360": "'.$output_360.'", "480": "'.$output_480.'", "720": "'.$output_720.'", "1080": "'.$output_1080.'"}';
                    }
                    return '{"480": "'.$output_480.'", "720": "'.$output_720.'", "1080": "'.$output_1080.'"}';
                }
                return '{"720": "'.$output_720.'", "1080": "'.$output_1080.'"}';
            }
            return '{"1080": "'.$output_1080.'"}';
		}
	}
}
