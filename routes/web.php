<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();


// FRONTEND
Route::get('/home','HomeController@home');
Route::get('/member-card','HomeController@memberCard');
Route::get('/course-category','HomeController@courseCategory');
Route::get('/detail-teacher','HomeController@detailTeacher');
Route::get('/student-profile','HomeController@studentProfile');
Route::get('/course-learning','HomeController@courseLearning');