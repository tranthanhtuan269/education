<?php
namespace App\Http\Controllers\Backends;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Validator;

class LoginController
{

    public function getLoginAdmin()
    {
        if (Auth::check()) {
            return redirect('admincp');
        } else {
            return view('backends.login.index');
        }
    }

    public function postLoginAdmin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];

        $messages = [];
        $validator = Validator::make($request->all(), $rules, $messages);

        // if ( $validator->fails() ) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // } else {
        //     $remember = ($request->input('remember')) ? true : false;
        //     $email = $request->input('email');
        //     $password = $request->input('password');

        //     if ( Auth::attempt( ['email'=>$email,'password'=>$password], $remember ) ) {
        //         return redirect()->intended('/admincp');
        //     } else {
        //         $errors = new MessageBag(['errorlogin'=>'The email or password is incorrect']);
        //         return redirect()->back()->withErrors($errors);
        //     }
        // }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $email = trim($request->input('email'));
            $password = trim($request->input('password'));
            $user = User::where('email', $email)->first();

            if (!isset($user)) {
                $errors = new MessageBag(['errorlogin' => 'Email is incorrect.']);
                return redirect()->back()->withErrors($errors);
            } else {
                if (\Hash::check($password, $user->password)) {
                    if ($user->status == 0) {
                        $errors = new MessageBag(['errorlogin' => 'This account locked.']);
                        return redirect()->back()->withErrors($errors);
                    } else {
                        Auth::login($user, $request->get('remember'));
                        return redirect()->intended('/admincp');
                    }
                } else {
                    $errors = new MessageBag(['errorlogin' => 'Password is incorrect.']);
                    return redirect()->back()->withErrors($errors);
                }
            }

        }
    }

    public function getLogoutAdmin()
    {
        Auth::logout();
        return redirect()->route('toh-admin');
    }

}
