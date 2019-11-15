<?php

namespace App\Http\Controllers\Frontends;

use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends Controller
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
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $charge=Stripe\Charge::create ([
            "amount" => 100 * 100,
            "currency" => "usd",
            "source" => $request->stripeToken
        ]);
       
        if($charge->getLastResponse()->code == 200){
            Session::flash('success', 'Payment successful!');
            return back();
        }
        else{
            Session::flash('fail');
            return back();
        }
    }
}
