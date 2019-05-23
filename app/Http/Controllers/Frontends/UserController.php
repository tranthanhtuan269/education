<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Frontends\Requests\LoginUserRequest;
use App\Http\Controllers\Frontends\Requests\RegisterUserRequest;
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
            return response()->json(['success' => 'Your account has been created!', 'status' => 200]);
        } else {
            return response()->json(['error' => 'The email or password is incorrect', 'status' => 404]);
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
        return response()->json(['success' => 'Your account has been created!', 'status' => 200]);
    }

    public function course(Request $request)
    {
        $keyword = trim($request->get('keyword'));
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
}
