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

// // Auth::routes();


// // FRONTEND
// Route::get('/home','HomeController@home');
// Route::get('/member-card','HomeController@memberCard');
// Route::get('/course-category','HomeController@courseCategory');
// Route::get('/detail-teacher','HomeController@detailTeacher');
// Route::get('/course-learning','HomeController@courseLearning');
// Route::get('/course-detail','HomeController@courseDetail');


// BACKEND
Route::get('toh-admin','Backends\LoginController@getLoginAdmin')->name('toh-admin');
Route::post('/login-admin','Backends\LoginController@postLoginAdmin');
Route::get('login-admin',function(){
	return redirect('/');
});
Route::get('/logout-admin','Backends\LoginController@getLogoutAdmin')->name('logout-admin');

// BACKEND
Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix'=>'admincp'],function(){
		Route::get('/','Backends\HomeController@getAdminCp');

		Route::get('users/suggest', 'Backends\UserController@suggestSearch');
		Route::get('users/getDataAjax', 'Backends\UserController@getDataAjax');
		Route::get('users/getInfoByID/{id}', 'Backends\UserController@getInfoByID');
		Route::put('users/updateSefl', 'Backends\UserController@updateSefl')->name('user.updateSefl');
		Route::post('users/info', 'Backends\UserController@infoRoleUser');
		Route::delete('users/delMultiUser',['as' => 'delMultiUser', 'uses' => 'Backends\UserController@delMultiUser']);
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
		Route::delete('roles/delMulti', 'Backends\RoleController@delMulti');
		Route::resource('roles', 'Backends\RoleController');
		// Route::get('posts/getDataAjax', 'PostController@getDataAjax');
		// Route::delete('posts/delMulti', 'PostController@delMulti');
		// Route::resource('posts', 'PostController');
		// Route::resource('postcategories', 'PostCategoryController');


		Route::get('list',['as' => 'getUserList', 'uses' => 'Backends\UserController@getUserList']);

	});
});

// FRONTEND
Route::get('/home','Frontends\HomeController@home');
Route::get('/member-card','Frontends\HomeController@memberCard');
Route::get('/course-category','Frontends\HomeController@courseCategory');
Route::get('/detail-teacher','Frontends\HomeController@detailTeacher');

Route::get('/course-learning','Frontends\HomeController@courseLearning');
Route::get('/course-detail','Frontends\HomeController@courseDetail');