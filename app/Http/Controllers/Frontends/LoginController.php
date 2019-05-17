<?php
namespace App\Http\Controllers\Frontends;
use App\Http\Controllers\Frontends\Requests\LoginUserRequest;
use Illuminate\Support\MessageBag;
use Auth;
use Validator;
use Cache;
use Illuminate\Http\Request;

class LoginController {
    public function loginAjax( LoginUserRequest $request ){
        $email = $request->email;
        $password = $request->password;

        if(Auth::attempt(['email'=>$email,'password'=>$password],$request->get('remember') )){
            return response()->json(['success'=>'Your account has been created!']);
        }else{
            return response()->json(['error' => 'The email or password is incorrect']);
        }

    }

    public function getLogoutAdmin(){
        Auth::logout();
        return redirect()->route('toh-admin');
    }

}