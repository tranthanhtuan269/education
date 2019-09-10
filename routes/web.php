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

Route::get('fix-course', 'Frontends\HomeController@fixDurationCourse');
Route::get('fix-video', 'Frontends\HomeController@fixDurationVideo');
Route::get('fix-will-learn', 'Frontends\HomeController@fixWillLearn');

Route::get('mailable', function () {
    $order = App\Order::find(9);
    return new App\Mail\OrderCompleted($order, Auth::user() );
});

Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');
// // FRONTEND
// Route::get('/home','HomeController@home');
// Route::get('/member-card','HomeController@memberCard');
// Route::get('/course-category','HomeController@courseCategory');
// Route::get('/detail-teacher','HomeController@detailTeacher');
// Route::get('/course-learning','HomeController@courseLearning');
// Route::get('/course-detail','HomeController@courseDetail');
Route::get('them-banner-cho-category', 'Frontends\HomeController@themBannerChoCategory');
Route::get('duyet-tat-ca-giang-vien','Frontends\HomeController@duyetAllTeacher' );
Route::get('dem-video-cho-unit', 'Frontends\HomeController@demVideoChoUnit');
Route::get('them-video-link', 'Frontends\HomeController@themVideoLink');


// BACKEND
Route::get('toh-admin', 'Backends\LoginController@getLoginAdmin')->name('toh-admin');

Route::post('/login-admin', 'Backends\LoginController@postLoginAdmin');
Route::get('login-admin', function () {
    return redirect('/');
});
Route::get('/logout-admin', 'Backends\LoginController@getLogoutAdmin')->name('logout-admin');

// Route::get('mailable', function () {
//     $user = App\User::find(1);
//     $email = App\Email::find(1);

//     return new App\Mail\DiscountNot($user, $email);
// });

// BACKEND
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admincp'], function () {
        Route::get('/', 'Backends\UserController@index');

        // Trinhnk Duyet khoa hoc
        Route::get('courses', 'Backends\CourseController@getCourse');
        Route::get('courses/getCourseAjax', 'Backends\CourseController@getCourseAjax');
        Route::put('courses/accept', 'Backends\CourseController@accept');
        Route::put('courses/accept-multiple-course', 'Backends\CourseController@acceptMultiCourse');
        Route::put('courses/inaccept-multiple-course', 'Backends\CourseController@inacceptMultiCourse');
        Route::delete('courses/delete', 'Backends\CourseController@deleteCourse');
        Route::delete('courses/delete-multiple-course', 'Backends\CourseController@deleteMultiCourse');
        Route::put('courses/activeCourse', 'Backends\CourseController@activeCourse');

        // Trinhnk Duyet video
        Route::get('videos', 'Backends\VideoController@getVideo');
        Route::get('videos/getVideoAjax', 'Backends\VideoController@getVideoAjax');
        Route::put('videos/accept', 'Backends\VideoController@accept');
        Route::put('videos/accept-multiple-video', 'Backends\VideoController@acceptMultiVideo');
        Route::put('videos/inaccept-multiple-video', 'Backends\VideoController@inacceptMultiVideo');
        Route::delete('videos/delete', 'Backends\VideoController@deleteVideo');
        Route::delete('videos/delete-multiple-video', 'Backends\VideoController@deleteMultiVideo');
        Route::get('request-delete-videos', 'Backends\VideoController@getRequestDeleteVideo');
        Route::get('request-delete-videos/getRequestDeleteVideoAjax', 'Backends\VideoController@getRequestDeleteVideoAjax');
        Route::put('request-delete-videos/reject', 'Backends\VideoController@rejectRequestDeleteVideo');
        // Route::delete('request-delete-videos/accept', 'Backends\VideoController@acceptRequestDeleteVideo');


        // Trinhnk Block Users
        Route::put('users/block-user', 'Backends\UserController@blockUser');

        // Trinhnk Tang khoa hoc
        Route::get('gifts', 'Backends\GiftController@getGiveGift');
        Route::get('gifts/getGiftStudentAjax', 'Backends\GiftController@getGiftStudentAjax');
        Route::get('gifts/getGiftCourse', 'Backends\GiftController@getGiftCourse');
        Route::post('gifts/handling-gift-ajax', 'Backends\GiftController@handlingGiftAjax');

        // Trinhnk Category
        Route::get('categories', 'Backends\CategoryController@getCategory');
        Route::get('categories/getCategoryAjax', 'Backends\CategoryController@getCategoryAjax');
        Route::post('categories/addCategory', 'Backends\CategoryController@addCategory');
        Route::post('categories/editCategory', 'Backends\CategoryController@editCategory');
        Route::post('categories/delete', 'Backends\CategoryController@deleteCategory');

        // Trinhnk Feature Course
        Route::get('feature-course', 'Backends\CourseController@getFeatureCourse');
        Route::post('feature-course/handling-feature-course', 'Backends\CourseController@handlingFeatureCourseAjax');

        // Trinhnk Tạo Coupon
        Route::get('create-coupon', 'Backends\HomeController@createCoupon');
        Route::post('add-coupon', 'Backends\HomeController@addCoupon');

        // End

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

        Route::get('verify-video', 'Backends\VideoController@verifyVideo');
        Route::get('get-unverified-video', 'Backends\VideoController@getUnverifiedVideoAjax');
        Route::put('verify-video/accept', 'Backends\VideoController@acceptVideo');
        Route::delete('verify-video/delete', 'Backends\VideoController@destroy');


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
Route::put('button-add-to-card', 'Frontends\HomeController@buttonAddToCart');
Route::get('proceed-checkout', ['uses' =>'Frontends\HomeController@proceedCheckout']);

// Đăng nhập mới đánh giá khóa học dc
Route::post('reviews/info', 'Backends\UserController@infoRoleUser');

Route::post('/saveFileAjax', 'Frontends\HomeController@saveFileAjax');
Route::get('duration', 'Frontends\HomeController@duration');
Route::get('logout', 'Frontends\HomeController@logout');
Route::get('test', 'Frontends\HomeController@test');
Route::get('coming-soon', 'Frontends\HomeController@comingSoon')->name('coming-soon');
Route::get('comments/see-more', 'Frontends\HomeController@seeMore')->name('see-more');


Route::get('search', 'Frontends\HomeController@search');



Route::get('nap-tien', 'Frontends\HomeController@naptien');

Route::post('googleLogin', 'Frontends\UserController@googleLogin');

Route::get('become-teacher', 'Frontends\HomeController@becomeTeacher');

Route::get('about', 'Frontends\HomeController@aboutPage');
Route::get('faq', 'Frontends\HomeController@faqPage');
Route::get('terms-of-service', 'Frontends\HomeController@termsOfServicePage');
Route::get('payment-guide', 'Frontends\HomeController@paymentGuidePage');
Route::get('affiliate', 'Frontends\HomeController@affiliatePage');


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

    // Route::get('cart/payment/checkout-step', 'Frontends\HomeController@showMethodSelector');
    Route::get('cart/payment/method-selector', 'Frontends\HomeController@showMethodSelector');
    Route::get('cart/payment/getFinalPrice', 'Frontends\HomeController@getFinalPrice');

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
            Route::get('top-up', 'Frontends\UserController@showTopup');
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
            Route::get('{id}/get-video', 'Backends\UnitController@getVideos');
            Route::post('store', 'Backends\UnitController@store');
            Route::put('{id}/update', 'Backends\UnitController@update');
            Route::put('sort', 'Backends\UnitController@sort');
            Route::put('sort-video', 'Backends\UnitController@sortVideo');
            Route::post('video/store', 'Backends\VideoController@store');
            Route::post('video/edit', 'Backends\VideoController@edit');
            Route::post('video/{id}/update', 'Backends\VideoController@update');
            Route::delete('video/remove', 'Backends\VideoController@sendRemoveVideoRequest');
            Route::delete('delete', 'Backends\UnitController@destroy');
        });

        Route::group(['prefix' => 'videos'],function () {
            Route::get('{id}', 'Backends\UnitController@getVideo');
            Route::put('sort', 'Backends\VideoController@sort');
        });

        Route::get('register-teacher', 'Frontends\UserController@registerTeacher'); 
        Route::post('register-teacher', 'Frontends\UserController@insertRegisterTeacher'); 
    });

    Route::post('upload-image', 'Frontends\UserController@uploadImage');
});

