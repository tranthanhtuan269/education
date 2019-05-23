<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;
use App\Helper\Helper;

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

    }
}
