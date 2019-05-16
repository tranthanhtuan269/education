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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// // FRONTEND
// Route::get('/home','HomeController@home');
// Route::get('/member-card','HomeController@memberCard');
// Route::get('/course-category','HomeController@courseCategory');
// Route::get('/detail-teacher','HomeController@detailTeacher');
// Route::get('/course-learning','HomeController@courseLearning');
// Route::get('/course-detail','HomeController@courseDetail');

// BACKEND
Route::get('toh-admin', 'Backends\LoginController@getLoginAdmin')->name('toh-admin');
Route::post('/login-admin', 'Backends\LoginController@postLoginAdmin');
Route::get('login-admin', function () {
    return redirect('/');
});
Route::get('/logout-admin', 'Backends\LoginController@getLogoutAdmin')->name('logout-admin');

// BACKEND
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admincp'], function () {
        Route::get('/', 'Backends\HomeController@getAdminCp');

        Route::get('users/suggest', 'Backends\UserController@suggestSearch');
        Route::get('users/getDataAjax', 'Backends\UserController@getDataAjax');
        Route::get('users/getInfoByID/{id}', 'Backends\UserController@getInfoByID');
        Route::put('users/updateSefl', 'Backends\UserController@updateSefl')->name('user.updateSefl');
        Route::post('users/info', 'Backends\UserController@infoRoleUser');
        Route::delete('users/delMultiUser', ['as' => 'delMultiUser', 'uses' => 'Backends\UserController@delMultiUser']);
        Route::resource('users', 'Backends\UserController');
        Route::post('users/store', 'Backends\UserController@store')->middleware('clearance-ajax');

        Route::get('permissions/suggest', 'Backends\PermissionController@suggestSearch')->middleware('clearance-ajax');
        Route::get('permissions/getDataAjax', 'Backends\PermissionController@getDataAjax');
        Route::delete('permissions/delMulti', 'Backends\PermissionController@delMulti');
        Route::resource('permissions', 'Backends\PermissionController');

        Route::get('roles/{id}/listpermission', 'Backends\RoleController@listpermission');
        Route::get('roles/suggest', 'Backends\RoleController@suggestSearch');
        Route::get('roles/getDataAjax', 'Backends\RoleController@getDataAjax');
        Route::get('roles/getInfoByID/{id}', 'Backends\RoleController@getInfoByID');
        Route::get('roles/getRoleByID/{id}', 'Backends\RoleController@getRoleByID');
        Route::delete('roles/delMulti', 'Backends\RoleController@delMulti');
        Route::resource('roles', 'Backends\RoleController');
        // Route::get('posts/getDataAjax', 'PostController@getDataAjax');
        // Route::delete('posts/delMulti', 'PostController@delMulti');
        // Route::resource('posts', 'PostController');
        // Route::resource('postcategories', 'PostCategoryController');

        Route::get('list', ['as' => 'getUserList', 'uses' => 'Backends\UserController@getUserList']);

    });
});

// FRONTEND
Route::get('/', 'Frontends\HomeController@home')->name('home');
Route::get('/home', 'Frontends\HomeController@home')->name('home');
Route::get('/member-card', 'Frontends\HomeController@memberCard')->name('member-card');
Route::get('/course-category', 'Frontends\HomeController@courseCategory')->name('course-category');
Route::get('/detail-teacher', 'Frontends\HomeController@detailTeacher')->name('detail-teacher');

Route::get('/course-learning', 'Frontends\HomeController@courseLearning');
Route::get('/course-detail', 'Frontends\HomeController@courseDetail')->name('course-detail');

Route::get('/course-list','Frontends\HomeController@courseList');
Route::get('/student-profile','Frontends\HomeController@studentProfile');

Route::get('/learning-page/{courseId}/lecture/{videoId}', 'Frontends\VideoPlayerController@show');

Route::get('category/{cat}', ['as'  => 'category', 'uses' =>'Frontends\HomeController@showCategory']);
Route::get('course/{course}', ['as'  => 'course', 'uses' =>'Frontends\HomeController@showCourse']);
Route::get('teacher/{teacher}', ['as'  => 'teacher', 'uses' =>'Frontends\HomeController@showTeacher']);


// Đăng nhập mới đánh giá khóa học dc
Route::post('reviews/info', 'Backends\UserController@infoRoleUser');

Route::post('reviews/store', 'Frontends\CommentController@storeCommentCourse');
Route::post('comments/store', 'Frontends\CommentController@storeCommentVideo');
