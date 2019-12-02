<?php

namespace App\Http\Controllers\Frontends;

use App\Helper\Helper;
use App\Http\Controllers\Frontends\Requests\ChangePassUserRequest;
use App\Http\Controllers\Frontends\Requests\LoginUserRequest;
use App\Http\Controllers\Frontends\Requests\RegisterUserRequest;
use App\Http\Controllers\Frontends\Requests\UpdateProfileTeacherRequest;
use App\Http\Controllers\Frontends\Requests\UpdateProfileUserRequest;
use App\Http\Controllers\Frontends\Requests\InsertTeacherRequest;
use App\User;
use App\Email;
use App\Course;
use App\Teacher;
use App\Category;
use App\UserRole;
use App\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\CustomMail;


class UserController extends Controller
{
    public function loginAjax(LoginUserRequest $request)
    {
        $email = trim($request->login_email);
        $password = trim($request->login_password);

        // if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1], $request->get('remember'))) {
        //     // auth()->logoutOtherDevices($request->password);
        //     return response()->json(['message' => 'Ok', 'status' => 200]);
        // } else {
        //     if (Auth::check() && Auth::user()->status == 0) {
        //         return response()->json(['message' => 'This account locked', 'status' => 404]);
        //     }

        //     return response()->json(['message' => 'The email or password is incorrect', 'status' => 404]);
        // }

        $user = User::where('email', $email)->first();

        if( !isset($user) ) {
            return response()->json(['message' => 'Địa chỉ Email hoặc Mật khẩu không chính xác.', 'status' => 404]);
        } else {
            if ( \Hash::check($password, $user->password) ) {
                if ($user->status == 0) {
                    return response()->json(['message' => 'Tài khoản của bạn đang bị khóa.', 'status' => 404]);
                } else {
                    Auth::login($user, $request->get('remember'));
                    return response()->json(['message' => 'Ok', 'status' => 200]);
                }
            } else {
                return response()->json(['message' => 'Địa chỉ Email hoặc Mật khẩu không chính xác.', 'status' => 404]);
            }
        }

    }

    public function loginAjaxCourseDetail(LoginUserRequest $request)
    {
        $email = trim($request->login_email);
        $password = trim($request->login_password);

        $user = User::where('email', $email)->first();

        $course = Course::find($request->course_id);

        if( !isset($user) ) {
            return response()->json(['message' => 'Địa chỉ Email hoặc Mật khẩu không chính xác.', 'status' => 404]);
        } else {
            if ( \Hash::check($password, $user->password) ) {
                if ($user->status == 0) {
                    return response()->json(['message' => 'Tài khoản của bạn đang bị khóa.', 'status' => 404]);
                } else {
                    Auth::login($user, $request->get('remember'));
                    
                    $role = 0;
                    if ( Auth::user()->isAdmin() ){
                        $role = 1; // Admin
                    }
                    if ( Auth::user()->id == $course->userRoles[0]->user_id ){
                        $role = 2; // Khoa hoc cua chinh user
                    }
                    $bought = Auth::user()->bought;
                    $bought = str_replace("[", "", $bought);
                    $bought = str_replace("]", "", $bought);
                    $bought = str_replace('"', "", $bought);
                    $bought = explode(",", $bought);
                    if ( in_array($request->course_id, $bought)){
                        $role = 3; // Khoa hoc user da mua
                    }
                    return response()->json(['message' => 'Ok', 'status' => 200, 'role' => $role]);
                }
            } else {
                return response()->json(['message' => 'Địa chỉ Email hoặc Mật khẩu không chính xác.', 'status' => 404]);
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function registerAjax(RegisterUserRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = 'images/avatar.jpg';
        $user->password = bcrypt(trim($request->password));
        $user->status = 1;
        $user->save();

        $user_role = new UserRole();
        $user_role->user_id = $user->id;
        $user_role->role_id = \Config::get('app.student');
        $user_role->save();

        Auth::login($user);
        return response()->json(['message' => 'Chúc mừng bạn đã đăng ký thành công!', 'status' => 200]);
    }

    public function showTopup(){
        return view('frontends.users.student.top-up');
    }

    public function courseStudent(Request $request)
    {
        $keyword = trim($request->get('u-keyword'));
        // dd(Auth::user()->userRolesStudent());
        $lifelong_course = Auth::user()->userRolesStudent()->userLifelongCourse($keyword);
        // dd($li;

        return view('frontends.users.student.course', compact('lifelong_course'));
    }

    public function profileStudent()
    {
        return view('frontends.users.student.profile');
    }

    public function updateProfileStudent(UpdateProfileUserRequest $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->address = $request->address;

            if (isset($request->birthday)) {
                $user->birthday = Helper::formatDate('d/m/Y', $request->birthday, 'Y-m-d');
            } else {
                $user->birthday = null;
            }

            if ($request->link_base64 != '') {
                // Xóa avatar cũ nếu có
                if (Auth::user()->avatar && strlen(Auth::user()->avatar) > 0) {
                    if (file_exists(public_path('frontend/' . Auth::user()->avatar))) {
                        unlink(public_path('frontend/' . Auth::user()->avatar));
                    }
                }

                $img_file = $request->link_base64;
                list($type, $img_file) = explode(';', $img_file);
                list(, $img_file) = explode(',', $img_file);
                $img_file = base64_decode($img_file);
                $file_name = time() . '.png';
                file_put_contents(public_path('/frontend/images/') . $file_name, $img_file);
                $user->avatar = 'images/' . $file_name;
            }

            $user->save();

            return \Response::json(['message' => 'Sửa thông tin thành công!', 'status' => 200]);
        }

        return \Response::json(['message' => 'Sửa thông tin không thành công!', 'status' => 404]);
    }

    public function profileTeacher()
    {
        // dd(Auth::user()->userRolesTeacher()->teacher);
        return view('frontends.users.teacher.profile');
    }

    public function updateProfileTeacher(UpdateProfileTeacherRequest $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->address = $request->address;

            if (isset($request->birthday)) {
                $user->birthday = Helper::formatDate('d/m/Y', $request->birthday, 'Y-m-d');
            } else {
                $user->birthday = null;
            }

            if ($request->link_base64 != '') {
                // Xóa avatar cũ nếu có
                if (Auth::user()->avatar && strlen(Auth::user()->avatar) > 0) {
                    if (file_exists(public_path('frontend/' . Auth::user()->avatar))) {
                        unlink(public_path('frontend/' . Auth::user()->avatar));
                    }
                }

                $img_file = $request->link_base64;
                list($type, $img_file) = explode(';', $img_file);
                list(, $img_file) = explode(',', $img_file);
                $img_file = base64_decode($img_file);
                $file_name = time() . '.png';
                file_put_contents(public_path('/frontend/images/') . $file_name, $img_file);
                $user->avatar = 'images/' . $file_name;
            }

            $user->facebook = $request->facebook;

            $user->save();

            // update course info
            Course::getCourseOfTeacher(Auth::user()->id, $request->name);

            $teacher = Auth::user()->userRolesTeacher()->teacher;
            $teacher->expert = $request->expert;
            $teacher->cv = $request->cv;
            $teacher->video_intro = "https://www.youtube.com/embed/" . Helper::getYouTubeVideoId($request->video_intro);
            $teacher->save();

            return \Response::json(['message' => 'Sửa thông tin thành công!', 'status' => 200]);
        }

        return \Response::json(['message' => 'Sửa thông tin không thành công!', 'status' => 404]);
    }

    public function registerTeacher()
    {
        return view('frontends.users.teacher.register');
    }

    public function insertRegisterTeacher(InsertTeacherRequest $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $check_isset_teacher = UserRole::where('user_id', $user->id)->where('role_id', \Config::get('app.teacher'))->count();
            if ($check_isset_teacher == 0) {
                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->gender = $request->gender;
                $user->address = $request->address;
                $user->facebook = $request->facebook;

                if (isset($request->birthday)) {
                    $user->birthday = Helper::formatDate('d/m/Y', $request->birthday, 'Y-m-d');
                } else {
                    $user->birthday = null;
                }

                if ($request->link_base64 != '') {
                    // Xóa avatar cũ nếu có
                    if (Auth::user()->avatar && strlen(Auth::user()->avatar) > 0) {
                        if (file_exists(public_path('frontend/' . Auth::user()->avatar))) {
                            unlink(public_path('frontend/' . Auth::user()->avatar));
                        }
                    }

                    $img_file = $request->link_base64;
                    list($type, $img_file) = explode(';', $img_file);
                    list(, $img_file) = explode(',', $img_file);
                    $img_file = base64_decode($img_file);
                    $file_name = time() . '.png';
                    file_put_contents(public_path('/frontend/images/') . $file_name, $img_file);
                    $user->avatar = 'images/' . $file_name;
                }

                $user->save();

                $user_role = new UserRole;
                $user_role->user_id =  $user->id;
                $user_role->role_id = \Config::get('app.teacher');
                $user_role->save();

                $teacher = new Teacher;
                $teacher->user_role_id =  $user_role->id;
                $teacher->expert = $request->expert;
                $teacher->cv = $request->cv;
                $teacher->video_intro = "https://www.youtube.com/embed/" . Helper::getYouTubeVideoId($request->video_intro);
                $teacher->save();

                return \Response::json(['message' => 'Đăng ký giảng viên thành công! Hồ sơ của bạn đang được xét duyệt.', 'status' => 200]);
            }

            return \Response::json(['message' => 'Bạn đang là giảng viên!', 'status' => 404]);
        }

        return \Response::json(['message' => 'Đăng ký giảng viên không thành công!', 'status' => 404]);
    }

    public function courseTeacher(Request $request)
    {
        $keyword = trim($request->get('u-keyword'));
        $lifelong_course = Auth::user()->userRolesTeacher()->userLifelongCourse($keyword);
        if(count($lifelong_course) == 0){
            if($lifelong_course->currentPage() > 1){
                return redirect($lifelong_course->previousPageUrl());
            }
        }
        $categories = Category::where('parent_id', 0)->get();
        return view('frontends.users.teacher.course', compact('lifelong_course', 'categories'));
    }

    public function uploadImage(Request $request)
    {
        echo 1;
    }

    public function changePassAjax(ChangePassUserRequest $request)
    {
        if (Auth::check()) {
            // auth()->logoutOtherDevices($request->password);

            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();
            Auth::login($user);
            return \Response::json(['message' => 'Thay đổi mật khẩu thành công!', 'status' => 200]);
        }

        return \Response::json(['message' => 'Thay đổi mật khẩu không thành công!', 'status' => 404]);
    }

    public function mailBoxStudent()
    {
        // $users = Auth::user();
        // dd($users->mail_log[0]->demo);
        return view('frontends.users.student.mail-box');
    }

    public function mailBoxTeacher()
    {
        // $users = Auth::user();
        // dd($users->mail_log[0]->demo);
        return view('frontends.users.teacher.mail-box');
    }

    public function getDataMailBoxStudentAjax()
    {
        $user = Auth::user();
        $emails = $user->user_emails->where('teacher', '<>', true);
        // dd($emails);

        return datatables()->collection($emails)
            ->addColumn('sender', function ($email) {
                $sender_user_id = $email->sender_user_id;
                $sender = User::find($sender_user_id);
                return $sender->name;
            })
            ->addColumn('title', function ($email) {
                return $email->title;
            })
            ->addColumn('content', function ($email) {
                return $email->content;
            })
            ->addColumn('user_email_id', function ($email) {
                return $email->id;
            })
            ->setRowAttr([
                'style' => function ($email) {
                    if($email->viewed == 0){
                        return 'background-color: #F2F3F6; font-weight: 600;';
                    }else if($email->viewed == 1){
                        return '';
                    }
                }
            ])
            // ->removeColumn('id')
            ->make(true);
    }

    public function getDataMailBoxTeacherAjax()
    {
        $user = Auth::user();
        $emails = $user->user_emails->where('teacher', true);
        // dd($emails);

        return datatables()->collection($emails)
            ->addColumn('sender', function ($email) {
                $sender_user_id = $email->sender_user_id;
                $sender = User::find($sender_user_id);
                return $sender->name;
            })
            ->addColumn('title', function ($email) {
                return $email->title;
            })
            ->addColumn('content', function ($email) {
                return $email->content;
            })
            ->addColumn('user_email_id', function ($email) {
                return $email->id;
            })
            ->setRowAttr([
                'style' => function ($email) {
                    if($email->viewed == 0){
                        return 'background-color: #F2F3F6; font-weight: 600;';
                    }else if($email->viewed == 1){
                        return '';
                    }
                }
            ])
            // ->removeColumn('id')
            ->make(true);
    }

    public function getSingleEmailContentAjax(Request $request){
        $user = Auth::user();

        if(isset($user) && isset($request->user_email_id)){
            $user_email_instance = UserEmail::find($request->user_email_id);

            //fake 1 email để thoả mãn CustomEmail
            $email_template = new Email;
            $email_template->title = $user_email_instance->title;
            $email_template->content = $user_email_instance->content;
            $email_template->status = 1;
            $email_template->create_user_id = $user_email_instance->sender_user_id;
            $email_template->update_user_id = $user_email_instance->sender_user_id;


            $email_html = ( new CustomMail($user, $email_template) )->render();

            $user_email_instance->viewed = 1;
            $user_email_instance->save();

            return response()->json([
                'email_html' => $email_html
            ]);
        }

        return response()->json([
            'status' => '404',
            'message'=> 'There was a problem!'
        ]);
    }

    public function getDataMailBoxNavAjax(){
        $user = Auth::user();
        $unread_user_emails = $user->user_emails->where('viewed', 0);
        $unread_emails = Email::whereIn('id', $unread_user_emails->pluck('email_id'))->get();
        $number_unread_emails = count($unread_user_emails);

        $number_unread_student_mail = count($user->user_emails->where('teacher', null)->where('viewed', 0));
        $number_unread_teacher_mail = count($user->user_emails->where('teacher', true)->where('viewed', 0));

        return response()->json([
            'status' => '200',
            'message' => 'Success',
            'unread_emails' => $unread_emails,
            'number_unread_emails' => $number_unread_emails,
            'number_of_student' => $number_unread_student_mail,
            'number_of_teacher' => $number_unread_teacher_mail,
        ]);

    }

    public function orderLogs(Request $request)
    {
        // $order_logs = Auth::user()->userRolesStudent()->order[0]->payment;
        // dd($order_logs);
        return view('frontends.users.student.order-logs');
    }

    public function getDataOrderAjax()
    {
        $order_logs = Auth::user()->userRolesStudent()->order;

        return datatables()->collection($order_logs)
            ->addColumn('code', function ($order) {
                return '#DH_' . $order->id;
            })
            ->addColumn('payment', function ($order) {
                return  $order->payment->name;
            })
            ->addColumn('course', function ($order) {
                return  $order->courses;
            })
            ->make(true);
    }

    public function detailOrder($id)
    {
        $detail_order = Auth::user()->userRolesStudent()->orderDetail($id)->courses;
        // dd($detail_order);
        return $detail_order;
    }

    public function googleLogin(Request $request)
    {
        if(User::where('email', $request->email)->first()){
            $user = User::where('email', $request->email)->first();

            if(User::where('email', $request->email)->first()->google_id == $request->google_id){
                if (User::where('email', $request->email)->first()->status == 0) {
                    return response()->json(['message' => 'Tài khoản của bạn đang bị khóa.', 'status' => 404]);
                } else {
                    Auth::login(User::where('email', $request->email)->first(), $request->get('remember'));

                    // Facebook Login on button Buy Now 
                    if ( $request->course_id != 0 ){
                        $course = Course::find($request->course_id);
                        $role = 0;
                        if ( Auth::user()->isAdmin() ){
                            $role = 1; // Admin
                        }
                        if ( Auth::user()->id == $course->userRoles[0]->user_id ){
                            $role = 2; // Khoa hoc cua chinh user
                        }
                        $bought = Auth::user()->bought;
                        $bought = str_replace("[", "", $bought);
                        $bought = str_replace("]", "", $bought);
                        $bought = str_replace('"', "", $bought);
                        $bought = explode(",", $bought);
                        if ( in_array($request->course_id, $bought)){
                            $role = 3; // Khoa hoc user da mua
                        }
                        return response()->json(['message' => 'Ok', 'status' => 200, 'role' => $role]);
                    }

                    return response()->json(['message' => 'Ok', 'status' => 200]);
                }
            }else{
                $user->google_id = $request->google_id;
                $user->save();

                Auth::login($user);
                return \Response::json(array('status' => '200'));
            }

        }else{
            $user = new User;
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->google_id= $request->google_id;
            $user->password = bcrypt(trim($request->google_id));
            $user->status   = 1;
            $user->save();

            $user_role = new UserRole();
            $user_role->user_id = $user->id;
            $user_role->role_id = \Config::get('app.student');
            $user_role->save();

            Auth::login($user);

            $user_role->save();
            return \Response::json(array('status' => '201'));
        }
    }

    public function facebookLogin(Request $request)
    {
        $user = User::where('facebook_id', $request->facebook_id)->first();

        if($user){
            if ($user->status == 0) {
                return response()->json(['message' => 'Tài khoản của bạn đang bị khóa.', 'status' => 404]);
            } else {
                Auth::login($user);

                // Facebook Login on button Buy Now 
                if ( $request->course_id ){
                    $course = Course::find($request->course_id);
                    $role = 0;
                    if ( Auth::user()->isAdmin() ){
                        $role = 1; // Admin
                    }
                    if ( Auth::user()->id == $course->userRoles[0]->user_id ){
                        $role = 2; // Khoa hoc cua chinh user
                    }
                    $bought = Auth::user()->bought;
                    $bought = str_replace("[", "", $bought);
                    $bought = str_replace("]", "", $bought);
                    $bought = str_replace('"', "", $bought);
                    $bought = explode(",", $bought);
                    if ( in_array($request->course_id, $bought)){
                        $role = 3; // Khoa hoc user da mua
                    }
                    return response()->json(['message' => 'Ok', 'status' => 200, 'role' => $role]);
                }
                return response()->json(['message' => 'Ok', 'status' => 200]);
            }
        }else{
            $user = new User;
            $user->name         = $request->name;
            if ( $request->email == '' ){
                $user->email = 'facebook_email@example.com';
            }else{
                $user->email        = $request->email;
            }
            $user->facebook_id  = $request->facebook_id;
            $user->password     = bcrypt(trim($request->facebook_id));
            $user->status       = 1;
            $user->save();

            $user_role = new UserRole();
            $user_role->user_id = $user->id;
            $user_role->role_id = \Config::get('app.student');
            $user_role->save();

            Auth::login($user);

            $user_role->save();
            return \Response::json(array('status' => '201'));
        }
    }
}
