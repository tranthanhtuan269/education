<?php

namespace App\Providers;

use Auth;
use Mail;
use Config;
use Validator;
use App\Video;
use App\Document;
use App\TempVideo;
use App\UserCourse;
use App\TempDocument;
use App\Helper\Helper;
use App\Mail\ConvertVideoCompleted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;

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

            if($event->job->resolveName() == "App\Jobs\ProcessLecture1080"){
                Log::info('Job ready: ' . $event->job->resolveName());
                Log::info('Job started: ' . $event->job->resolveName());
                $job = $event->job->payload();
    
                $payload = json_decode( $event->job->getRawBody() );
                $data = unserialize( $payload->data->command );
                $video_id = $data->video_id;
    
                $video = Video::find($video_id);
                if($video){
                    $video->state = \Config::get('app.video_active');
                    $video->save();
                }

                Helper::reSortIndexVideoOfCourse($video->unit->course->id);

                $course = $video->unit->course;
                if ( $course ){
                    if ($course->userRoles->first()){
                        $current_user = $course->userRoles->first()->user;
                        // Mail::to($current_user)->queue(new ConvertVideoCompleted($video, $current_user));
                        // Lưu vào bảng user_email
                        $alertEmail = \App\Email::find(Config::get('app.email_convert_video_completed'));
                        if($alertEmail){
                            $user_email  = new \App\UserEmail;
                            $user_email->user_id = $current_user->id;
                            $user_email->email_id = $alertEmail->id;
                            $user_email->sender_user_id = 333;
                            $user_email->content = $alertEmail->content;
                            $user_email->title = $alertEmail->title;
                            $user_email->save();
                        }
                    }
                }      
            }

            if($event->job->resolveName() == "App\Jobs\ProcessLectureEdit1080"){
                Log::info('Job ready: ' . $event->job->resolveName());
                Log::info('Job started: ' . $event->job->resolveName());
                $job = $event->job->payload();
    
                $payload = json_decode( $event->job->getRawBody() );
                $data = unserialize( $payload->data->command );
                $temp_video_id = $data->video_temp_id;
                Log::info('video_temp_id: ' . $data->video_temp_id);
                $videoTemp = TempVideo::find($temp_video_id);
                if($videoTemp){
                    Log::info('videoTemp existed');
                    $video_id = $videoTemp->video_id;
                    $video = Video::find($video_id);
                    if($video){
                        Log::info('video existed');
                        $video->name = $videoTemp->name;
                        $video->url_video = $videoTemp->url_video;
                        $video->link_video = $videoTemp->link_video;
                        $video->duration = $videoTemp->duration;
                        $video->state = \Config::get('app.video_active');
                        $video->save();
                        Log::info('video saved');
                        
                        $documents = TempDocument::where('video_id', $video->id)->get();
                        
                        $oldDocs = Document::where('video_id', $video->id)->get();
                        foreach($oldDocs as $old){
                            if($old){
                                if (file_exists(public_path('uploads/files/'.$old->url_document))) {
                                    \unlink(public_path('uploads/files/'.$old->url_document));
                                }
                                $old->delete();
                            }
                        }

                        if($videoTemp->files_delete){
                            $document_ids = explode(",", $videoTemp->files_delete);
                            foreach ($document_ids as $key => $id) {
                                $document = Document::find($id);
                                if($document){
                                    if (file_exists(public_path('uploads/files/'.$old->url_document))) {
                                        unlink(public_path('uploads/files/'.$old->url_document));
                                    }
                                    $document->delete();
                                }
                            }
                        }
    
                        foreach($documents as $document){
                            // remove old document 
                            $newDoc = new Document;
                            $newDoc->title = $document->title;
                            $newDoc->video_id = $document->video_id;
                            $newDoc->url_document = $document->url_document;
                            $newDoc->size = $document->size;
                            $newDoc->save();
                        }
                    }
                    $videoTemp->delete();
                }
                $course = $video->unit->course;
                if ( $course ){
                    if ($course->userRoles->first()){
                        $current_user = $course->userRoles->first()->user;
                        // Mail::to($current_user)->queue(new ConvertVideoCompleted($video, $current_user));
                        // Lưu vào bảng user_email
                        $alertEmail = \App\Email::find(Config::get('app.email_convert_video_completed'));
                        if($alertEmail){
                            $user_email  = new \App\UserEmail;
                            $user_email->user_id = $current_user->id;
                            $user_email->email_id = $alertEmail->id;
                            $user_email->sender_user_id = 333;
                            $user_email->content = $alertEmail->content;
                            $user_email->title = $alertEmail->title;
                            $user_email->save();
                        }
                    }
                }  
            }
        });
    }
}
