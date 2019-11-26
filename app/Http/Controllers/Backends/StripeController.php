<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Order;
use Auth;
use Validator;
use Cache;
use App\Helper\Helper;
use App\User;
use App\Setting;

class StripeController extends Controller
{
    public function index()
    {
        return view('backends.stripe.index');
    }
    public function updateAccount(Request $request)
    {
        $KEY = $request->STRIPE_KEY;
        $SECRET = $request->STRIPE_SECRET;
        
        $STRIPE_KEY = Setting::where('name','STRIPE_KEY')->first();
        $STRIPE_KEY->value = $KEY;$STRIPE_KEY->save();

        $STRIPE_SECRET = Setting::where('name','STRIPE_SECRET')->first();
        $STRIPE_SECRET->value = $SECRET;$STRIPE_SECRET->save();

        // $STRIPE_KEY = Setting::where('name','STRIPE_KEY')->first();
        // $STRIPE_SECRET = Setting::where('name','STRIPE_KEY')->first();
        // dd($STRIPE_KEY, $STRIPE_SECRET);
        return \Response::json(array('status' => '200', 'message' => 'Đã đổi tài khoản thành công!'));
    }
}
