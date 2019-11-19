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
        try {
            $product_stripe = json_decode($request->product_stripe);
            $arr = [];
            // dd($product_stripe);
            if (count($product_stripe) > 0) {
                $total = 0;
                foreach ($product_stripe as $key => $value) {
                    $course_id = $value->id;
                    $price = Course::where('id',$course_id)->value('price');
                    $course = Course::where('id',$course_id)->first();

                    if ($course) {
                        $price = $course->price;
                        $coupon_code = trim($value->coupon_code);
                        $coupon = Coupon::where('name', $coupon_code)->whereDate('expired', '>=', date('Y-m-d'))->first();
                        $coupon_value = 0;

                        if ($coupon) {
                            if ($coupon->course_id != '') {
                                $arr_course = explode(",", $coupon->course_id);
            
                                if (in_array($course_id, $arr_course)) {
                                    $coupon_value  = $coupon->value;
                                    $price = $price * ((100 - $coupon_value)/100);
                                }
                            }
                        }
                        
                        $total += $price;

                        $arr[] = [
                                    'course_id' => $course_id,
                                    'coupon_value' => $coupon_value,
                                    'coupon_code' => $coupon_code,
                                    'total_price' => $total
                                ];
                    }

                }
            }

            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $charge=Stripe\Charge::create ([
                "amount" => $total/20,
                "currency" => "usd",
                "source" => $request->stripeToken
            ]);
        
            if($charge->getLastResponse()->code == 200){
                $current_user = Auth::user();
                $coins_user = Auth::user()->coins;
                $user_role_id = $current_user->userRolesStudent();

                $coupon = null;
                $coupon_value = null;
                $coupon_name = null;
                $total_price = 0;

                $order = new Order;
                $order->payment_id = 2; // 1 = ck
                $order->user_id = $user_role_id->id;
                $order->status = 1; // 1 = ok, 2 = pending, 0 = cancel
                $order->total_price = 0;
                $order->coupon = '';
                $order->save();

                $bought = [];
                if (strlen($current_user->bought) > 0) {
                    $bought = \json_decode($current_user->bought);
                }

                foreach ($arr as $key => $value) {
                    $course_id = $value['course_id'];
                    $coupon_value = $value['coupon_value'];
                    $coupon_code = $value['coupon_code'];
                    $bought[] = $course_id; 
                    $coupon = Coupon::where('name', $coupon_code)->first();
                    $course = Course::where('status', '!=', -100)->find($course_id);

                    $course->userRoles()->attach($user_role_id->id, ['videos' => Helper::buildJsonForCheckout($course_id)]);
                    $order->courses()->attach($course_id, ['coupon'=>$value["coupon_code"], 'percent' => $coupon_value]);

                    // lưu vào bảng teacher của mỗi course để tăng số lượng học viên cho mỗi teacher
                    $teacher = $course->Lecturers()->first()->teacher;
                    if($teacher){
                        $teacher->student_count += 1;
                        $teacher->save();
                    }

                    $course2 = Course::where('status', '!=', -100)->find($course_id);
                    $course2->student_count += 1;
                    $course2->sale_count += 1;
                    $course2->save();
                }

                $order->total_price = $value['total_price'];

                // if ($coupon) {
                //     // $order->total_price = $total_price * (100 - $coupon->value) / 100;
                //     $order->total_price = $total_price;
                //     $order->coupon = $coupon->name;
                // } else {
                //     $order->total_price = $total_price;
                //     $order->coupon = '';
                // }

                Mail::to($current_user)->queue(new OrderCompleted($order, $current_user));
                // dd($order->courses[0]->pivot->coupon);
                
                $order_content = [];
                foreach ( $order->courses as $course ){
                    $orderCourseObj = new OrderCourseObj;
                    $orderCourseObj->id = $course->id;
                    $orderCourseObj->name = $course->name;
                    $orderCourseObj->price = $course->price;
                    $orderCourseObj->real_price = $course->real_price;
                    $orderCourseObj->sale = $course->price * (100 - $course->pivot->percent) / 100;
                    $orderCourseObj->coupon = $course->pivot->coupon;
                    $orderCourseObj->coupon_value = $course->pivot->percent;
                    $order_content[] = $orderCourseObj;
                }

                $order->content = json_encode($order_content);
                $order->save();

                // Lưu vào bảng user_email
                $alertEmail = Email::find(Config::get('app.email_order_complete'));
                if($alertEmail){
                    $user_email  = new \App\UserEmail;
                    $user_email->user_id = Auth::id();
                    $user_email->email_id = $alertEmail->id;
                    $user_email->sender_user_id = 333;
                    $user_email->content = $alertEmail->content;
                    $user_email->title = $alertEmail->title;
                    $user_email->save();
                }

                $current_user->bought = \json_encode($bought);
                $current_user->coins = $current_user->coins - $total_price;
                $current_user->save();

            
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
