<?php

namespace App\Providers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Validator;
use App\Helper\Helper;
use Auth;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use App\Video;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        // Validate email customize
        Validator::extend('regex_email', function($attribute, $value, $parameters, $validator) {
            if (!is_string($value) && !is_numeric($value)) {
                return false;
            }
            return preg_match($parameters[0], $value);
        });

        // Validate email customize
        Validator::extend('regex_phone', function($attribute, $value, $parameters, $validator) {
            if (!is_string($value) && !is_numeric($value)) {
                return false;
            }
            return preg_match($parameters[0], $value);
        });

        // Validate birthday customize
        Validator::extend('validate_birthday', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $birthday = $data['birthday'];
            $birthday = Helper::formatDate('d/m/Y', $birthday, 'Y-m-d');
            $dateCurrent = date('Y-m-d');
            return (Helper::handlingTime($birthday) <= Helper::handlingTime($dateCurrent) ) ? TRUE : FALSE ;
        });

        Validator::extend('validate_dob', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $birthday = $data['dob'];
            $birthday = Helper::formatDate('d/m/Y', $birthday, 'Y-m-d');
            $dateCurrent = date('Y-m-d');
            return (Helper::handlingTime($birthday) <= Helper::handlingTime($dateCurrent) ) ? TRUE : FALSE ;
        });

        // Validate Youtube Url
        // Validator::extend('validate_youtube_url', function(){

        // });

        // Validate check password old when change password
        Validator::extend('check_pass', function($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $password_old = $data['password_old'];
            return (\Hash::check($password_old, Auth::user()->password)) ? TRUE : FALSE ;
        });

        Queue::before(function (JobProcessing $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
            $job = $event->job;
            Log::info('Job ready: ' . $event->job->resolveName());
            Log::info('Job started: ' . $event->job->resolveName());

        });

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            if($event->job->resolveName() == "App\Jobs\ProcessLecture"){
                $job = $event->job->payload();
    
                $payload = json_decode( $event->job->getRawBody() );
                $data = unserialize( $payload->data->command );
                $video_id = $data->video_id;
    
                $video = Video::find($video_id);
                if($video){
                    $video->state = 1;
                    $video->save();
                    // DuongNT // thêm 1 video vào lượng đã xem vào bảng user_courses
                    $unit = $video->unit;
                    $course = $unit->course;
                    $user_roles = $course->userRoles()->where('role_id', 3)->get()->all();//lấy những user_role đại diện student
                    #Insert cho từng student
                    foreach ($user_roles as $key => $user_role) {
                        $user_course = UserCourse::where("user_role_id", $user_role->id)->where("course_id", $course->id)->first();
                        $videos = json_decode($user_course->videos);
                        array_push($videos->{'videos'}[($unit->index) - 1 ], 0);
                        $videos = json_encode($videos);
                        $user_course->videos = $videos;
                        $user_course->save();
                    }
                }
    
                
                $json_data = \json_encode($data->video_id);
            }

            
            // $job = unserialize($job);
            // $job = \json_encode($job);
            // Log::notice('Job done: ' . $event->job->payload());
            // exec("echo ".$json_data." >> /home/gnoud/Desktop/afterlog.txt");
        });

    }
}
