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
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password], $request->get('remember'))) {
            // auth()->logoutOtherDevices($request->password);
            return response()->json(['message' => 'Your account has been created!', 'status' => 200]);
        } else {
            return response()->json(['message' => 'The email or password is incorrect', 'status' => 404]);
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
        $user->password = bcrypt(trim($request->password));
        $user->save();

        $user_role = new UserRole();
        $user_role->user_id = $user->id;
        $user_role->role_id = \Config::get('app.student');
        $user_role->save();

        Auth::login($user);
        return response()->json(['message' => 'Your account has been created!', 'status' => 200]);
    }

    public function courseStudent(Request $request)
    {
        $keyword = trim($request->get('u-keyword'));
        $lifelong_course = Auth::user()->userRolesStudent()->userLifelongCourse($keyword);
        
        // dd($lifelong_course);
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

            return \Response::json(['message' => 'Change profile success!', 'status' => 200]);
        }

        return \Response::json(['message' => 'Change profile unsuccess!', 'status' => 404]);
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

            $user->save();

            $teacher = Auth::user()->userRolesTeacher()->teacher;
            $teacher->expert = $request->expert;
            $teacher->cv = $request->cv;
            $teacher->video_intro = $request->video_intro;
            $teacher->save();

            return \Response::json(['message' => 'Change profile success!', 'status' => 200]);
        }

        return \Response::json(['message' => 'Change profile unsuccess!', 'status' => 404]);
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
                $teacher->video_intro = $request->video_intro;
                $teacher->save();
    
                return \Response::json(['message' => 'Register teacher success!', 'status' => 200]);
            }

            return \Response::json(['message' => 'You are registered as a teacher!', 'status' => 404]);
        }

        return \Response::json(['message' => 'Register teacher unsuccess!', 'status' => 404]);
    }

    public function courseTeacher(Request $request)
    {
        $keyword = trim($request->get('u-keyword'));
        $lifelong_course = Auth::user()->userRolesTeacher()->userLifelongCourse($keyword);
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
            return \Response::json(['message' => 'You have changed the password to success!', 'status' => 200]);
        }

        return \Response::json(['message' => 'You have changed the password to unsuccess!', 'status' => 404]);
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

    public function getDataMailBoxAjax()
    {
        $user = Auth::user();
        $emails = $user->user_emails;
        // dd($emails);

        return datatables()->collection($emails)
            ->addColumn('sender', function ($email) {
                $sender_user_id = $email->sender_user_id;
                $sender = User::find($sender_user_id);
                return $sender->name;
            })
            ->addColumn('title', function ($email) {
                $wanted_email = Email::find($email->email_id);
                return $wanted_email->title;
            })
            ->addColumn('content', function ($email) {
                $wanted_email = Email::find($email->email_id);
                return $wanted_email->content;
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
            $email_id = $request->email_id;
            $user_email_instance = UserEmail::find($request->user_email_id);
            $email_template = Email::find($user_email_instance->email_id);
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
        
        
        return response()->json([
            'status' => '200',
            'message' => 'Success',
            'unread_emails' => $unread_emails,
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
                return '#Order_' . $order->id;
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

}
