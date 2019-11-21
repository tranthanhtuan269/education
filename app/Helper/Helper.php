<?php

namespace App\Helper;

use Auth;
use Config;
use DateTime;
use App\Email;
use App\Video;
use App\Course;
use App\VideoJson;
use App\UserEmail;
use App\UserCourse;

class Helper
{
    public static function formatDate($format_time, $time, $format)
    {
        return (!empty($time)) ? \Carbon\Carbon::createFromFormat($format_time, $time)->format($format) : '';
    }

    public static function getUserRoleOfComment($course_id){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            if(Auth::user()->isAdmin()){
                return Auth::user()->userRolesAdmin()->id;
            }
            $user_role_list = Auth::user()->userRoles;
            $demanding_user_course = null;
            foreach ($user_role_list as $key => $user_role) {
                $user_course_item = UserCourse::where('course_id', $course_id)
                    ->where('user_role_id', $user_role->id)
                    ->first();

                if (!empty($user_course_item)) {
                    $demanding_user_course = $user_course_item->user_role_id;
                    break;
                }
            }
        }else{
            $demanding_user_course = null;
        }
        return $demanding_user_course;
    }
    
    public static function getUserRoleOfCourse($course_id)
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            if(Auth::user()->isAdmin()){
                return Auth::user()->userRolesAdmin();
            }
            $user_role_list = Auth::user()->userRoles;
            // dd($user_role_list);
            $course = \App\Course::find($course_id);
            $lecturer_user_role = $course->Lecturers()->first();

            $demanding_user_course = null;

            foreach ($user_role_list as $key => $user_role) {
                $user_course_item = UserCourse::where('course_id', $course_id)
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

    public static function convertVideoToMultiResolution($video, $resolution, $path_video){
        $t=time();
        $input = public_path('/uploads/videos/').$video;
        // $output = public_path('/uploads/videos_output/').$resolution.'/'.$video;
        $output = "/usr/local/WowzaStreamingEngine/content/".$resolution.'/'.$video;
        $block_txt = public_path('/uploads/block_'.$t.'.txt');

        $format = 'mp4';
        $avcodec = '-c:v libx264 -strict -2';
        $time = '-ss ' . "00:00:00";
        $bitrate = '-vf scale='.$resolution.':-2';

        $command = config('config.path_ffmpeg_exe') .' -i '.$input.' '.$time.' '.$avcodec.' '.$bitrate.' '.$output.' 1> '.$block_txt.' 2>&1';
        exec($command);
    }

    public static function getYouTubeVideoId($url)
    {
        // preg_match('/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $results);
        preg_match('/^(?:http(?:s)?:\/\/)?(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $results);
        // dd($results[6]);
        if(isset($results[6])) return $results[6];
        if(isset($results[5])) return $results[5];
        if(isset($results[4])) return $results[4];
    }

    public static function moveElementInArray(&$a, $oldpos, $newpos) {
        if ($oldpos==$newpos) {return;}
        array_splice($a,max($newpos,0),0,array_splice($a,max($oldpos,0),1));
    }

    public static function getJSONVideoOfCourse($id){
        $course = \App\Course::find($id);
        $units = $course->units;
        $array = "[";
        $list_units = "";
        foreach($units as $unit){
            $videos = $unit->videos;
            $list_units = "[";
            $list_videos = "";
            foreach($videos as $video){
                $list_videos .= "0,";
            }
            $list_units .= rtrim($list_videos, ',');
            $list_units .= "],";
            $array .= $list_units;
        }
        $array = rtrim($array, ',');
        $array .= "]";
        return \json_decode($array);
    }

    public static function getVideoFirst($course_id){
        $course = Course::where('status', '!=', -100)->find($course_id);
        if($course){
            $units = $course->units;
            if(count($units) > 0){
                foreach($units as $unit){
                    if(count($unit->videos) > 0){
                        return $unit->videos[0]->id;
                    }
                }
            }
            return -1;
        }
        return -1;
    }

    public static function buildJsonForCheckout($course_id){
        // when checkout
        $course = Course::where('status', '!=', -100)->find($course_id);
        if($course){
            $videoJson = new VideoJson;
            $videoJson->videos = Helper::getJSONVideoOfCourse($course->id);
            $videoJson->learning = 1;
            $videoJson->learning_id = Helper::getVideoFirst($course->id);
            return json_encode($videoJson);
        }
    }

    public static function reSortIndexVideoOfCourse($course_id){
        $course = Course::where('status', '!=', -100)->find($course_id);
        if($course){
            $units = $course->units;
            if(count($units) > 0){
                foreach($units as $unit){
                    $videos = $unit->videos; 
                    if(count($videos) > 0){
                        foreach($videos as $key => $video){
                            $video->index = $key + 1;
                            $video->save();
                        }
                    }
                }
            }
        }
    }

    public static function putFilesToServerVideo($video){
        if($video){
            $video_urls = json_decode($video->url_video, true);
            foreach ($video_urls as $key => $video_url) {
                $url = str_replace ( 'vod/_definst_', '/usr/local/WowzaStreamingEngine/content', $video_url);
                $connection = ssh2_connect('45.79.103.103', 22);
                ssh2_auth_password($connection, 'root', 'TOHlinode@123');
                ssh2_scp_send($connection, $url, $url, 0644);
            }  
        }
    }

    public static function reBuildJsonWhenCreateOrDeleteLecture($course_id, $video_id, $flag = 1){
        // Sap xep lai index video
        Helper::reSortIndexVideoOfCourse($course_id);
        // $flag = 0 when delete, = 1 when create
        // when create new
        // Lấy tất cả các UserCourse của khóa học này
        $userCourses = UserCourse::where('course_id', $course_id)->get();
        // Giả sử bài học được tạo mới ở Unit số  2 và ở vị trí số  3
        foreach($userCourses as $userCourse){
            // Nếu user là teacher then $userCourse->videos = null => bỏ qua
            // Nếu user là học viên then 
            if($userCourse->videos){
                $videosJson = \json_decode($userCourse->videos);
                $videoLearning = $videosJson->learning;
                

                $video = Video::find($video_id);
                if($video){
                    $videoIndex = $video->index;
                    $unitIndex = $video->unit->index;
                    foreach($videosJson->videos as $key=>$videoJson){
                        if($unitIndex == $key + 1){
                            if($flag == 1){
                                array_splice($videosJson->videos[$key], $videoIndex-1, 0, 0 );
                            }else{
                                array_splice($videosJson->videos[$key], $videoIndex-1, 1);
                                $video->index = -1;
                                $video->state = 5;
                                $video->save();
                            }

                            if($videoLearning < $videoIndex){
                                if($flag == 1){
                                    $videosJson->learning += 1;
                                }else{
                                    $videosJson->learning -= 1;
                                }
                            }elseif($videoLearning == $videoIndex){
                                if($flag == 1){
                                    $videosJson->learning += 1;
                                }else{
                                    $videosJson->learning = 1;
                                    $videosJson->learning_id = Helper::getVideoFirst($course_id);
                                }
                            }

                            $userCourse->videos = \json_encode($videosJson);
                            $userCourse->save();
                        }
                    }
                }
            }
        }
        // Sap xep lai index video
        Helper::reSortIndexVideoOfCourse($course_id);
    }

    // Hàm cắt chuỗi thông minh ^-^
    public static function smartStr($string, $length = 60, $character = '...') {
        $limit = abs((int)$length);

        if(strlen($string) > $limit) {
           $string = preg_replace("/^(.{1,$limit})(\s.*|$)/s", '\1'.$character, $string);
        }
       
        return $string;
    }

    // send alert to user
    public static function addAlert($userToSend, $emailKey){
        $alertEmail = Email::find(Config::get($emailKey));
        if($alertEmail){
            $user_email  = new UserEmail;
            $user_email->user_id = $userToSend->id;
            $user_email->email_id = $alertEmail->id;
            $user_email->sender_user_id = 333;
            $user_email->content = $alertEmail->content;
            $user_email->title = $alertEmail->title;
            $user_email->save();
        }
    }

    // send alert to user
    public static function addAlertCustomize($userToSend, $title = null, $content = null, $of_teacher = null){
        $user_email  = new UserEmail;
        $user_email->user_id = $userToSend->id;
        $user_email->email_id = 0;
        $user_email->sender_user_id = 333;
        $user_email->content = $content;
        $user_email->title = $title;
        $user_email->teacher = $of_teacher;
        $user_email->save();
    }

    public static function insertInputForm($ip_type, $ip_name, $lb_text, $ip_value, $alert_class, $ip_feature = '')
    {
        $html = '';
        $html .= '<div class="form-group form-html">';
        $html .= '<label>'. $lb_text .'</label>';
        $html .= '<div class="form-group">';
        $html .= '<input type="'. $ip_type .'" class="form-control" name="'. $ip_name .'" value="'. $ip_value .'" '. $ip_feature .'>';
        $html .= '</div>';
        $html .= '<div class="form-html-validate '. $alert_class .'"></div>';
        $html .= '</div>';
        // echo \Form::submit('Click Me!');
        // die;
        return $html;
    }

    public static function insertTextareaForm($lb_text, $row, $col, $name, $value, $alert_class, $feature='')
    {
        $html = '';
        $html .= '<div class="form-group form-html">';
            $html .= '<label>'. $lb_text .'</label>';
            $html .= '<div class="form-group">';
                $html .= '<textarea class="form-control" rows="'. $row .'" cols="'. $col.'" name="'. $name .'">'. $value .'</textarea>';
            $html .= '</div>';
            $html .= '<div class="form-html-validate '. $alert_class .'"></div>';
        $html .= '</div>';

        return $html;
    }
}
