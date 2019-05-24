<?php

namespace App\Http\Controllers\Frontends;

use App\Helper\Helper;
use App\Http\Controllers\Frontends\Requests\LoginUserRequest;
use App\Http\Controllers\Frontends\Requests\RegisterUserRequest;
use App\Http\Controllers\Frontends\Requests\UpdateProfileUserRequest;
use App\Http\Controllers\Frontends\Requests\ChangePassUserRequest;
use App\User;
use App\UserRole;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginAjax(LoginUserRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->get('remember'))) {
            auth()->logoutOtherDevices($request->password);
            Auth::login($user, true);
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
        $user_role->role_id = 3; //: Mặc định là học sinh
        $user_role->save();

        Auth::login($user, true);
        return response()->json(['message' => 'Your account has been created!', 'status' => 200]);
    }

    public function course(Request $request)
    {
        $keyword = trim($request->get('u-keyword'));
        $id = Auth::user()->id;
        $user = User::find($id);
        $lifelong_course = $user->userRolesStudent()[0]->userLifelongCourse($keyword);
        // dd($lifelong_course);
        return view('frontends.users.course', compact('lifelong_course'));
    }

    public function profile()
    {
        return view('frontends.users.profile');
    }

    public function updateProfile(UpdateProfileUserRequest $request)
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

    public function uploadImage(Request $request)
    {
        echo 1;
    }

    public function changePassAjax(ChangePassUserRequest $request)
    {
        if (Auth::check()) {
            auth()->logoutOtherDevices($request->password);

            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();
            Auth::login($user, true);
            return \Response::json(['message' => 'You have changed the password to success!', 'status' => 200]);
        }

        return \Response::json(['message' => 'You have changed the password to unsuccess!', 'status' => 404]);
    }
}
