<?php
namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Frontends\Requests\LoginUserRequest;
use App\Http\Controllers\Frontends\Requests\RegisterUserRequest;
use Auth;

class LoginController
{
    public function loginAjax(LoginUserRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->get('remember'))) {
            return response()->json(['success' => 'Your account has been created!']);
        } else {
            return response()->json(['error' => 'The email or password is incorrect']);
        }

    }

    public function getLogoutAdmin()
    {
        Auth::logout();
        return redirect()->route('toh-admin');
    }

}
