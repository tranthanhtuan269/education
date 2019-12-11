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

Route::get('trinhnk', function( ){
    dd(\Auth::id());
});

Route::get('delete/{course}', 'Frontends\HomeController@deleteCourse');

Route::get('test', function(){
    dd(\Helper::putFilesToServerVideo(\App\Video::find(1)));
    $connection = ssh2_connect('45.79.103.103', 22);
    ssh2_auth_password($connection, 'root', 'TOHlinode@123');

    ssh2_scp_send($connection, '/var/www/html/unica/public/images/avatar.jpg', '/var/www/html/avatar.jpg', 0644);
});

Route::get('thay-state-video', function(){
    $videos = \App\Video::where('created_at', null)->get();
    foreach ($videos as $key => $video) {
        $video->state = 1;
        $video->save();
    }
});

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
        Route::get('/', function(){
            return redirect('/admincp/users');
        });

        // Trinhnk Duyet khoa hoc
        Route::get('courses', 'Backends\CourseController@getCourse');
        Route::get('courses/getCourseAjax', 'Backends\CourseController@getCourseAjax');
        Route::put('courses/accept', 'Backends\CourseController@accept');
        Route::put('courses/accept-multiple-course', 'Backends\CourseController@acceptMultiCourse');
        Route::put('courses/inaccept-multiple-course', 'Backends\CourseController@inacceptMultiCourse');
        Route::put('courses/delete', 'Backends\CourseController@deleteCourse');
        Route::delete('courses/delete-multiple-course', 'Backends\CourseController@deleteMultiCourse');
        Route::put('courses/activeCourse', 'Backends\CourseController@activeCourse');
        // Duyet khoa hoc
        Route::get('courses/request-accept', 'Backends\CourseController@getRequestAccept');
        Route::get('courses/get-request-accept-ajax', 'Backends\CourseController@getRequestAcceptCourseAjax');
        // Sua khoa hoc
        Route::get('courses/request-edit', 'Backends\CourseController@getRequestEditCourse');
        Route::get('courses/get-edit-course-ajax', 'Backends\CourseController@getRequestEditCourseAjax');
        Route::post('courses/accept-edit-course', 'Backends\CourseController@acceptEditCourse');
        // Khoa hoc da duyet
        Route::get('courses/accepted-courses', 'Backends\CourseController@getAcceptedCourse');
        Route::get('courses/get-accepted-courses-ajax', 'Backends\CourseController@getAcceptedCourseAjax');
        Route::put('courses/stop-selling-course', 'Backends\CourseController@stopSellingCourse');

        // Trinhnk Duyet video
        Route::get('videos', 'Backends\VideoController@getVideo');
        Route::get('videos/getVideoAjax', 'Backends\VideoController@getVideoAjax');
        Route::put('videos/accept', 'Backends\VideoController@accept');
        Route::put('videos/disable', 'Backends\VideoController@disable');
        Route::put('videos/accept-multiple-video', 'Backends\VideoController@acceptMultiVideo');
        Route::put('videos/inaccept-multiple-video', 'Backends\VideoController@inacceptMultiVideo');
        Route::delete('videos/delete', 'Backends\VideoController@deleteVideo');
        Route::delete('videos/delete-multiple-video', 'Backends\VideoController@deleteMultiVideo');

        // Request Accept Video 
        Route::get('request-accept-videos', 'Backends\VideoController@getRequestAcceptVideo');
        Route::get('get-request-accept-videos', 'Backends\VideoController@getRequestAcceptVideoAjax');
        Route::delete('delete-request-accept-video', 'Backends\VideoController@deleteRequestAcceptVideo');

        // Request Delete Videos 
        Route::get('request-delete-videos', 'Backends\VideoController@getRequestDeleteVideo');
        Route::get('request-delete-videos/getRequestDeleteVideoAjax', 'Backends\VideoController@getRequestDeleteVideoAjax');
        Route::put('request-delete-videos/reject', 'Backends\VideoController@rejectRequestDeleteVideo');
        Route::put('request-delete-videos/delete', 'Backends\VideoController@acceptRequestDeleteVideo');

        // Edit Videos 
        Route::get('request-edit-videos', 'Backends\VideoController@getRequestEditVideo');
        Route::get('request-edit-videos-ajax', 'Backends\VideoController@getRequestEditVideoAjax');
        Route::put('accept-edit-video', 'Backends\VideoController@acceptEditVideo');
        Route::put('reject-edit-video', 'Backends\VideoController@rejectEditVideo');

        // Delete Videos in Trash
        Route::get('video-in-trash', 'Backends\VideoController@getVideoInTrash');
        Route::get('get-videos-in-trash-ajax', 'Backends\VideoController@getVideoInTrashAjax');
        Route::put('delete-video-in-trash', 'Backends\VideoController@deleteVideoInTrash');
        Route::put('delete-multi-video-in-trash', 'Backends\VideoController@deleteMultiVideoInTrash');

        // Route::put('request-delete-videos/reject', 'Backends\VideoController@rejectRequestDeleteVideo');
        // Route::get('videos-of-course', 'Backends\VideoController@getVideoOfCourse');
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
        Route::post('categories/editCategory/{id}', 'Backends\CategoryController@editCategory');
        Route::delete('categories/delete', 'Backends\CategoryController@deleteCategory');

        // Trinhnk Feature Course
        Route::get('feature-course', 'Backends\CourseController@getFeatureCourse');
        Route::post('feature-course/handling-feature-course', 'Backends\CourseController@handlingFeatureCourseAjax');
        Route::get('feature-teacher', 'Backends\UserController@getFeatureTeacher');
        Route::post('feature-teacher/handling-feature-teacher', 'Backends\UserController@handlingFeatureTeacherAjax');
        Route::post('feature-teacher/auto-feature-teacher', 'Backends\UserController@autoFeatureTeacherAjax');
        Route::get('featured-category', 'Backends\CategoryController@getFeaturedCategory');
        Route::get('featured-category/get-featured-category-ajax', 'Backends\CategoryController@getFeaturedCategoryAjax');
        Route::post('featured-category/set-feature-category-ajax', 'Backends\CategoryController@setFeaturedCategoryAjax');

        // Title Homepage
        Route::get('title-homepage', 'Backends\HomeController@getTitleHomepage');
        Route::post('set-title-homepage', 'Backends\HomeController@setTitleHomepage');
        Route::get('menu-setting', 'Backends\CategoryController@getMenuSetting');
        Route::post('menu-setting/sort-category', 'Backends\CategoryController@sortCategoryMenu');

        // Trinhnk Tạo Coupon
        Route::get('create-coupon', 'Backends\HomeController@createCoupon');
        Route::post('add-coupon', 'Backends\HomeController@addCoupon');
        Route::get('coupon/getCouponAjax', 'Backends\HomeController@getCouponAjax');
        Route::delete('coupon/delete', 'Backends\HomeController@deleteCoupon');
        Route::post('coupon/update', 'Backends\HomeController@updateCoupon');

        // Trinhnk Quan ly nap the 
        // Route::get('recharge', 'Backends\HomeController@createCoupon');
        Route::get('recharge-bank-transfer', 'Backends\RechargeController@bankTransfer');
        Route::get('recharge-bank-transfer/get-bank-account', 'Backends\RechargeController@getBankTransferAccountAjax');
        Route::post('recharge-bank-transfer/add-bank-account', 'Backends\RechargeController@addBankTransferAccount');
        Route::post('recharge-bank-transfer/edit-bank-account', 'Backends\RechargeController@editBankTransferAccount');
        Route::post('recharge-bank-transfer/delete-bank-account', 'Backends\RechargeController@deleteBankTransferAccount');
        Route::post('recharge-bank-transfer/save-bank-transfer', 'Backends\RechargeController@saveBankTransferSetting');

        Route::get('user-amount', 'Backends\RechargeController@userAmount');
        Route::get('user-amount/get-user-amount', 'Backends\RechargeController@getUserAmountAjax');
        Route::post('user-amount/edit-user-amount', 'Backends\RechargeController@editUserAmountAjax');

        Route::group(['prefix' => 'comment'],function () {
            Route::get('comment-course', 'Backends\CommentController@getAllCommentCourse');
            Route::get('get-comment-course-ajax', 'Backends\CommentController@getAllCommentCourseAjax');
            Route::delete('delete-comment-course', 'Backends\CommentController@deleteCommentCourse');

            Route::get('comment-video', 'Backends\CommentController@getAllCommentVideo');
            Route::get('get-comment-video-ajax', 'Backends\CommentController@getAllCommentVideoAjax');
            Route::delete('delete-comment-video', 'Backends\CommentController@deleteCommentVideo');
            Route::get('comment-report', 'Backends\CommentController@getAllCommentReport');
            Route::get('get-comment-report-ajax', 'Backends\CommentController@getAllCommentReportAjax');
            Route::delete('delete-comment-report', 'Backends\CommentController@deleteReportCourse');
            Route::put('cancel-comment', 'Backends\CommentController@cancelComment');
        });
        // End

        Route::get('teachers', 'Backends\UserController@getTeacher');
        Route::get('teachers/getTeacherAjax', 'Backends\UserController@getTeacherAjax');
        Route::put('teachers/accept', 'Backends\UserController@accept');
        Route::put('teachers/disable', 'Backends\TeacherController@disable');
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
        Route::put('users/edit-email/{id}', 'Backends\EmailController@edit');
        Route::get('users/delete-email', 'Backends\EmailController@destroy');
        Route::get('users/send-email', 'Backends\EmailController@sendEmail');
        Route::get('users/send-multiple-emails', 'Backends\EmailController@sendMultiple');
        Route::get('users/delete-multiple-emails', 'Backends\EmailController@destroyMultiple');
        Route::post('users/upload-email-photo', 'Backends\EmailController@uploadEmailPhoto')->name('upload-email-photo');

        Route::post('users/store-teacher', 'Backends\TeacherController@store');
        Route::put('users/update-teacher', 'Backends\TeacherController@update');
        Route::put('users/disable-teacher', 'Backends\TeacherController@disable');
        Route::post('users/store-student', 'Backends\StudentController@store');
        Route::put('users/update-student', 'Backends\StudentController@update');


        Route::resource('users', 'Backends\UserController');
        Route::put('users/updateSefl', 'Backends\UserController@updateSefl')->name('user.updateSefl');
        Route::post('users/info', 'Backends\UserController@infoRoleUser');
        Route::delete('users/delMultiUser', ['as' => 'delMultiUser', 'uses' => 'Backends\UserController@delMultiUser']);
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

        Route::get('statistic/getDataAjax', 'Backends\StatisticController@getDataAjax');
        Route::delete('statistic/delMulti', 'Backends\StatisticController@delMulti');
        Route::resource('statistic', 'Backends\StatisticController');
        Route::post('statistic/detailOrder', 'Backends\StatisticController@detailOrder');

        Route::resource('stripe', 'Backends\StripeController');
        Route::post('stripe/update', 'Backends\StripeController@updateAccount');
        Route::get('history', 'Backends\StripeController@recharge');
        Route::get('history/getDataAjax', 'Backends\StripeController@getDataAjax');
    });
});

// FRONTEND

Route::post('stripe', 'Frontends\StripePaymentController@stripePost')->name('stripe.post');
Route::post('stripe-recharge', 'Frontends\StripeRechargeController@stripeRecharge')->name('stripe.recharge');

Route::post('/loginAjax', 'Frontends\UserController@loginAjax');
Route::post('/registerAjax', 'Frontends\UserController@registerAjax');

Route::post('/loginAjax-course-detail', 'Frontends\UserController@loginAjaxCourseDetail');

Route::get('/', 'Frontends\HomeController@home')->name('home');
Route::get('/home', 'Frontends\HomeController@home')->name('home');
Route::get('/member-card', 'Frontends\HomeController@memberCard')->name('member-card');
Route::get('/detail-teacher', 'Frontends\HomeController@detailTeacher')->name('detail-teacher');

Route::get('/course-learning', 'Frontends\HomeController@courseLearning');
Route::get('/course-detail', 'Frontends\HomeController@courseDetail')->name('course-detail');

Route::get('/course-list','Frontends\HomeController@courseList');
Route::get('/student-profile','Frontends\HomeController@studentProfile');

Route::get('category/{cat}', ['as'  => 'category', 'uses' =>'Frontends\HomeController@showCategory']);
Route::get('tags/{tag}', ['as'  => 'tags', 'uses' =>'Frontends\HomeController@showTag']);
Route::get('course/{id}/{slug}', ['as'  => 'course', 'uses' =>'Frontends\HomeController@showCourse']);
Route::get('learning/{course}', ['as'  => 'course', 'uses' =>'Frontends\HomeController@courseLearning']);
Route::get('teacher/{teacher}', ['as'  => 'teacher', 'uses' =>'Frontends\HomeController@showTeacher']);
Route::get('list-course', ['uses' =>'Frontends\HomeController@listCourse']);
Route::get('list-course-category', ['uses' =>'Frontends\HomeController@listCourseCategory']);

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
// Route::get('test', 'Frontends\HomeController@test');
Route::get('coming-soon', 'Frontends\HomeController@comingSoon')->name('coming-soon');
Route::get('comments/see-more', 'Frontends\HomeController@seeMore')->name('see-more');
Route::post('comments-child/see-more', 'Frontends\HomeController@seeMoreChild')->name('see-more-child');

Route::get('search', 'Frontends\HomeController@search');



Route::get('nap-tien', 'Frontends\HomeController@naptien');

Route::post('googleLogin', 'Frontends\UserController@googleLogin');
Route::post('facebookLogin', 'Frontends\UserController@facebookLogin');

Route::get('become-teacher', 'Frontends\HomeController@becomeTeacher');

Route::get('about', 'Frontends\HomeController@aboutPage');
Route::get('faq', 'Frontends\HomeController@faqPage');
Route::get('terms-of-service', 'Frontends\HomeController@termsOfServicePage');
Route::get('payment-guide', 'Frontends\HomeController@paymentGuidePage');
Route::get('affiliate', 'Frontends\HomeController@affiliatePage');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/videos/getNote', 'Frontends\NoteController@getNote')->name('videos.getNote');
    Route::get('/videos/getDocument', 'Frontends\CommentController@getDocument')->name('videos.getDocument');
    Route::get('/videos/getDiscussion', 'Frontends\CommentController@getDiscussion')->name('videos.getDiscussion');
    Route::get('/learning-page/{courseId}', 'Frontends\VideoPlayerController@show')->name('videoplayer.show');
    Route::get('/learning-page/{courseId}/{slug}', 'Frontends\VideoPlayerController@show')->name('videoplayer.show');
    Route::get('/learning-page/{courseId}/lecture/{videoId}', 'Frontends\VideoPlayerController@show')->name('videoplayer.show');
    Route::get('/learning-page/search-lecture-list', 'Frontends\VideoPlayerController@searchLectureList')->name('videoplayer.search');
    Route::post('/videos/get-note-count', 'Frontends\VideoPlayerController@getNoteCount');

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
    Route::post('user-course/update-not-watched', 'Frontends\VideoPlayerController@updateNotWatched');
    Route::get('user-course/get-info-course', 'Frontends\VideoPlayerController@getInfoCourse');
    Route::get('user/logout', 'Frontends\UserController@logout')->name('logout');

    Route::post('comments/report','Frontends\CommentController@reportComment');

    // Route::get('cart/payment/checkout-step', 'Frontends\HomeController@showMethodSelector');
    Route::get('cart/payment/method-selector', 'Frontends\HomeController@showMethodSelector');
    Route::get('cart/payment/getFinalPrice', 'Frontends\HomeController@getFinalPrice');

    Route::group(['prefix' => 'user'],function () {
        Route::put('change-pass-ajax', 'Frontends\UserController@changePassAjax');
        Route::get('logout', 'Frontends\UserController@logout');


        Route::get('getDataMailBoxStudentAjax', 'Frontends\UserController@getDataMailBoxStudentAjax');
        Route::get('getDataMailBoxTeacherAjax', 'Frontends\UserController@getDataMailBoxTeacherAjax');
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
            Route::get('get-recharge-logs', 'Backends\RechargeController@getRechargeLogs');
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
            Route::post('stop-sell', 'Backends\CourseController@destroy');
            Route::post('continue-sell', 'Backends\CourseController@continueSell');
            Route::post('check-request-edit', 'Backends\CourseController@checkRequestEditCourse');
            Route::post('view-request-edit', 'Backends\CourseController@viewRequestEditCourse');
        });

        Route::group(['prefix' => 'units'],function () {
            Route::get('{id}/get-video', 'Backends\UnitController@getVideos');
            Route::post('store', 'Backends\UnitController@store');
            Route::put('{id}/update', 'Backends\UnitController@update');
            Route::put('sort', 'Backends\UnitController@sort');
            Route::put('sort-video', 'Backends\UnitController@sortVideo');
            Route::post('video/store', 'Backends\VideoController@store');
            Route::post('video/edit', 'Backends\VideoController@edit');
            Route::put('video/{id}/update', 'Backends\VideoController@update');
            Route::put('video/{id}/request-update', 'Backends\VideoController@requestUpdate');
            Route::put('video/remove-request-update', 'Backends\VideoController@removeRequestUpdate');
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

