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
use App\RechargeLog;

class StripeController extends Controller
{
    public function index()
    {
        $STRIPE_KEY = Setting::where('name','STRIPE_KEY')->first();
        $STRIPE_SECRET = Setting::where('name','STRIPE_SECRET')->first();
        $ti_gia = Setting::where('name','ti_gia')->first();
        return view('backends.stripe.index',compact('STRIPE_KEY', 'STRIPE_SECRET', 'ti_gia'));
    }
    public function updateAccount(Request $request)
    {
        $KEY = $request->STRIPE_KEY;
        $SECRET = $request->STRIPE_SECRET;
        $dongNew = $request->dong;
        
        $STRIPE_KEY = Setting::where('name','STRIPE_KEY')->first();
        $STRIPE_KEY->value = $KEY;$STRIPE_KEY->save();

        $STRIPE_SECRET = Setting::where('name','STRIPE_SECRET')->first();
        $STRIPE_SECRET->value = $SECRET;$STRIPE_SECRET->save();

        $dongOld = Setting::where('name','ti_gia')->first();
        $dongOld->value = $dongNew;$dongOld->save();

        // $STRIPE_KEY = Setting::where('name','STRIPE_KEY')->first();
        // $STRIPE_SECRET = Setting::where('name','STRIPE_SECRET')->first();
        // dd($STRIPE_KEY, $STRIPE_SECRET);
        return \Response::json(array('status' => '200', 'message' => 'Đã đổi tài khoản và tỉ giá thành công!'));
    }
    public function recharge()
    {
        
        return view('backends.stripe.stripe-recharge');
    }
    public function getDataAjax()
    {
        
        
        
        $user_amounts = RechargeLog::leftJoin('users', 'users.id', '=', 'recharge_logs.user_id' )
        ->join('payments', 'payments.id', '=', 'recharge_logs.payment_id' )
        ->select('amount', 'user_id', 'users.name as user_name', 'payments.name as payments_name')
        ->get();
        return datatables()->collection($user_amounts)
            
            ->make(true);
    }
}
