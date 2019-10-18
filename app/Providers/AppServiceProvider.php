<?php

namespace App\Providers;

use Auth;
use Validator;
use App\Video;
use App\Document;
use App\TempVideo;
use App\UserCourse;
use App\TempDocument;
use App\Helper\Helper;
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

    }
}
