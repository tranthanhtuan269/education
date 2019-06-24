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

Route::get('mailable', function () {
    $user = App\User::find(1);
    $email = App\Email::find(1);

    return new App\Mail\DiscountNot($user, $email);
});

// BACKEND
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admincp'], function () {
        Route::get('/', 'Backends\HomeController@getAdminCp');

        Route::get('teachers', 'Backends\UserController@getTeacher');
        Route::get('teachers/getTeacherAjax', 'Backends\UserController@getTeacherAjax');
        Route::put('teachers/accept', 'Backends\UserController@accept');
        Route::put('teachers/accept-multiple-teacher', 'Backends\UserController@acceptMultiTeacher');
        Route::put('teachers/inaccept-multiple-teacher', 'Backends\UserController@inacceptMultiTeacher');
        Route::delete('teachers/delete', 'Backends\UserController@deleteTeacher');
        Route::delete('teachers/delete-multiple-teacher', 'Backends\UserController@deleteMultiTeacher');

        Route::get('users/suggest', 'Backends\UserController@suggestSearch');
        Route::get('emails/getEmailAjax', 'Backends\UserController@getEmailAjax');
        Route::get('users/getDataAjax', 'Backends\UserController@getDataAjax');
        Route::get('users/getInfoByID/{id}', 'Backends\UserController@getInfoByID');

        Route::get('users/email', 'Backends\UserController@email');
        Route::post('users/store-email', 'Backends\EmailController@store');
        Route::put('users/edit-email', 'Backends\EmailController@edit');
        Route::get('users/delete-email', 'Backends\EmailController@destroy');
        Route::get('users/send-email', 'Backends\EmailController@sendEmail');
        Route::get('users/send-multiple-emails', 'Backends\EmailController@sendMultiple');
        Route::get('users/delete-multiple-emails', 'Backends\EmailController@destroyMultiple');
        
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
Route::post('/loginAjax', 'Frontends\UserController@loginAjax');
Route::post('/registerAjax', 'Frontends\UserController@registerAjax');
Route::get('/', 'Frontends\HomeController@home')->name('home');
Route::get('/home', 'Frontends\HomeController@home')->name('home');
Route::get('/member-card', 'Frontends\HomeController@memberCard')->name('member-card');
Route::get('/course-category', 'Frontends\HomeController@courseCategory')->name('course-category');
Route::get('/detail-teacher', 'Frontends\HomeController@detailTeacher')->name('detail-teacher');

Route::get('/course-learning', 'Frontends\HomeController@courseLearning');
Route::get('/course-detail', 'Frontends\HomeController@courseDetail')->name('course-detail');

Route::get('/course-list','Frontends\HomeController@courseList');
Route::get('/student-profile','Frontends\HomeController@studentProfile');

Route::get('category/{cat}', ['as'  => 'category', 'uses' =>'Frontends\HomeController@showCategory']);
Route::get('tags/{tag}', ['as'  => 'tags', 'uses' =>'Frontends\HomeController@showTag']);
Route::get('course/{course}', ['as'  => 'course', 'uses' =>'Frontends\HomeController@showCourse']);
Route::get('learning/{course}', ['as'  => 'course', 'uses' =>'Frontends\HomeController@courseLearning']);
Route::get('teacher/{teacher}', ['as'  => 'teacher', 'uses' =>'Frontends\HomeController@showTeacher']);
Route::get('list-course', ['uses' =>'Frontends\HomeController@listCourse']);

Route::get('cart', ['uses' =>'Frontends\HomeController@cart'])->name('cart.show');
Route::get('check-coupon', ['uses' =>'Frontends\HomeController@checkCoupon'])->name('coupon.check');
Route::post('checkout', ['uses' =>'Frontends\HomeController@checkout'])->name('cart.checkout');

// Đăng nhập mới đánh giá khóa học dc
Route::post('reviews/info', 'Backends\UserController@infoRoleUser');


Route::get('logout', 'Frontends\HomeController@logout');
Route::get('test', 'Frontends\HomeController@test');
Route::get('coming-soon', 'Frontends\HomeController@comingSoon')->name('coming-soon');
Route::get('comments/see-more', 'Frontends\CommentController@seeMore')->name('see-more');

Route::get('search', 'Frontends\HomeController@search');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/learning-page/{courseId}/lecture/{videoId}', 'Frontends\VideoPlayerController@show')->name('videoplayer.show');
    Route::get('/learning-page/search-lecture-list', 'Frontends\VideoPlayerController@searchLectureList')->name('videoplayer.search');

    Route::post('comment/comment-course', 'Frontends\CommentController@commentCourse');
    Route::post('reviews/store', 'Frontends\CommentController@storeCommentCourse');
    Route::post('comments/store', 'Frontends\CommentController@storeCommentVideo')->name('commentsVideo.store');
    Route::post('comments/vote', 'Frontends\CommentController@storeCommentVote');
    Route::post('comments/reply', 'Frontends\CommentController@storeReply');
    Route::put('stars/update', 'Frontends\CommentController@updateStar');
    Route::post('stars-teacher/insert', 'Frontends\CommentController@insertStarTeacher');
    Route::put('stars-teacher/update', 'Frontends\CommentController@updateStarTeacher');
    Route::post('notes/store', 'Frontends\NoteController@store')->name('notesVideo.store');
    Route::post('reports/store', 'Frontends\ReportController@store')->name('reportsVideo.store');
    Route::post('user-course/update-watched', 'Frontends\VideoPlayerController@updateWatched');
    Route::get('user/logout', 'Frontends\UserController@logout')->name('logout');
    
    Route::group(['prefix' => 'user'],function () {
        Route::put('change-pass-ajax', 'Frontends\UserController@changePassAjax');
        Route::get('logout', 'Frontends\UserController@logout');

       
        Route::get('getDataMailBoxAjax', 'Frontends\UserController@getDataMailBoxAjax');
        Route::get('getDataMailBoxNavAjax', 'Frontends\UserController@getDataMailBoxNavAjax');
        Route::get('getDataOrderAjax', 'Frontends\UserController@getDataOrderAjax');
        Route::get('getSingleEmailContentAjax', 'Frontends\UserController@getSingleEmailContentAjax');
        Route::group(['prefix' => 'student'],function () {
            Route::get('mail-box', 'Frontends\UserController@mailBoxStudent'); 
            Route::get('course', 'Frontends\UserController@courseStudent'); 
            Route::get('profile', 'Frontends\UserController@profileStudent'); 
            Route::post('profile', 'Frontends\UserController@updateProfileStudent');
            Route::get('order/{id}','Frontends\UserController@detailOrder')->where('id','[0-9]+');
            Route::get('order-logs', 'Frontends\UserController@orderLogs');
        });

        Route::group(['prefix' => 'teacher'],function () {
            Route::get('mail-box', 'Frontends\UserController@mailBoxTeacher'); 
            Route::get('course', 'Frontends\UserController@courseTeacher'); 
            Route::get('profile', 'Frontends\UserController@profileTeacher'); 
            Route::post('profile', 'Frontends\UserController@updateProfileTeacher');
        });

        Route::group(['prefix' => 'courses'],function () {
            Route::post('store', 'Backends\CourseController@store');
            Route::put('{id}/update', 'Backends\CourseController@update');
            Route::delete('delete', 'Backends\CourseController@destroy');
        });

        Route::group(['prefix' => 'units'],function () {
            Route::post('store', 'Backends\UnitController@store');
            Route::put('{id}/update', 'Backends\UnitController@update');
            Route::put('sort', 'Backends\UnitController@sort');
            Route::delete('delete', 'Backends\UnitController@destroy');
        });

        Route::get('register-teacher', 'Frontends\UserController@registerTeacher'); 
        Route::post('register-teacher', 'Frontends\UserController@insertRegisterTeacher'); 
    });

    Route::post('upload-image', 'Frontends\UserController@uploadImage');
});

