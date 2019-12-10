<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Course;
use App\Coupon;
use App\Category;
use App\Helper\Helper;
use App\Order;
use App\RatingCourse;
use App\RatingTeacher;
use App\Tag;
use App\Teacher;
use App\User;
use App\Unit;
use App\Email;
use App\Video;
use App\Setting;
use App\Mail\OrderCompleted;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\UserRole;
use DB;
use App\Document;
use Config;
use App\VideoJson;
use App\RechargeLog;

class StripeRechargeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripeRecharge(Request $request)
    {
        try {
            $total = $request->price_number;
            
                $userStripe = Auth::user()->name;
                $STRIPE_SECRET = Setting::where('name','STRIPE_SECRET')->value('value');
                Stripe\Stripe::setApiKey($STRIPE_SECRET);
                $price_vnd = Setting::where('name','ti_gia')->value('value');
                $customer = \Stripe\Customer::create([
                    "name" => $userStripe,
                    "card" => $request->stripeToken,
                    ]);
                $charge=Stripe\Charge::create ([
                    "amount" => $total*100,
                    "currency" => "usd",
                    "description" => 'Recharge',
                    "customer"=> $customer->id,
                    // "source" => $request->stripeToken
                ]);
                if($charge->getLastResponse()->code == 200){
                    $user = Auth::user();
                    $user->coins = $user->coins + $total * $price_vnd;
                    $user->save();
                    $userRecharge = new RechargeLog;
                    $userRecharge->amount = $total;
                    $userRecharge->message = 'USD';
                    $userRecharge->payment_id= 2;
                    $userRecharge->user_id = Auth::id();
                    $userRecharge->save();
                    Session::flash('success', 'Payment successful!');
                    return back();
                } else {
                    Session::flash('fail');
                    return back();
                }
            
            
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
        
    }
}
